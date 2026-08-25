<?php
try {

  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');

  //===============================Inicializamos las variables==========================================
  $modo = "insertar";
  $resultadoConsulta = "";
  $ruta = "../../public/imagenes/";

  $idUnidadMedida = null;
  $idCategoria = null;
  $resArchivo = null;
  $imagenMedicamentoActual = "";

  $arrayUnidadMedida = [
    ["IDUnidadMedida" => 0, "Nombre" => "Selecciona la unidad de medida"]
  ];

  $arrayCategoria = [
    ["IDCategoria" => 0, "Nombre" => "Selecciona la categoría"]
  ];

  //Obtenemos las unidades de medida para el formulario
  $stmt = $bdd->query("SELECT IDUnidadMedida, Nombre FROM unidad_medida WHERE BitActivo = 1 ORDER BY Nombre");

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $arrayUnidadMedida[] = [
      "IDUnidadMedida" => $row['IDUnidadMedida'],
      "Nombre" => $row['Nombre']
    ];
  }

  //Obtenemos las categorias para el formulario
  $stmt = $bdd->query("SELECT IDCategoria, Nombre FROM categoria WHERE BitActivo = 1 ORDER BY Nombre");

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $arrayCategoria[] = [
      "IDCategoria" => $row['IDCategoria'],
      "Nombre" => $row['Nombre']
    ];
  }


  //=====================================================================================================================================================
  //Validamos operacion UPDATE O DELETE
  //=====================================================================================================================================================
  if (isset($_GET['idMed']) and isset($_GET['modo'])) {
    $IDMedicamento = $_GET['idMed'];
    $modo = $_GET['modo'];
    switch ($modo) {
      // ============ Asigna variables para llenar formulario UPDATE ================
      case "actualizar":
        $resultado = $bdd->query("
                            SELECT
                              M.Nombre as nomMedicamento,
                              M.Descripcion,
                              M.StockApartado,
                              M.StockTotal,
                              M.StockDisponible,
                              M.imagen,
                              UM.IDUnidadMedida,
                              UM.Nombre as nomUnidadMedida,
                              M.CantidadActualPorEnvase,
                              M.CantidadMaximaPorEnvase,
                              MCAT.IDMedicamentoCategoria,
                              CAT.IDCategoria,
                              CAT.Nombre AS nomCategoria
                            FROM
                              medicamento as M
                              INNER JOIN unidad_medida AS UM ON M.IDUnidadMedida = UM.IDUnidadMedida
                              INNER JOIN medicamento_categoria MCAT ON MCAT.IDMedicamento = M.IDMedicamento
                              INNER JOIN categoria CAT ON CAT.IDCategoria = MCAT.IDCategoria
                            WHERE
                              M.IDMedicamento = $IDMedicamento AND
                              M.BitActivo=1
        ");
        foreach ($resultado as $res) {
          $nombreMedicamento = $res['nomMedicamento'];
          $descripcionMedicamento = $res['Descripcion'];
          $stockApartado = $res['StockApartado'];
          $stockTotal = $res['StockTotal'];
          $stockDisponible = $res['StockDisponible'];
          $imagen = $res['imagen'];
          $idUnidadMedida = $res['IDUnidadMedida'];
          $nomUnidadMedida = $res['nomUnidadMedida'];
          $cantidadActualPorEnvase = $res['CantidadActualPorEnvase'];
          $cantidadMaximaPorEnvase = $res['CantidadMaximaPorEnvase'];
          $idMedicamentoCategoria = $res['IDMedicamentoCategoria'];
          $idCategoria = $res['IDCategoria'];
          $nomCategoria = $res['nomCategoria'];
        }
        break;
      // ======================= Elimina en la base de datos =========================
      case "eliminar":
        $sql = "DELETE FROM medicamento_categoria WHERE IDMedicamento = ?";

        $stmt = $bdd->prepare($sql);
        $resultadoMedCat = $stmt->execute([$IDMedicamento]);
        
        $sql = "DELETE FROM medicamento WHERE IDMedicamento = ?";

        $stmt = $bdd->prepare($sql);
        $resultadoMed = $stmt->execute([$IDMedicamento]);

        // Valida el éxito del INSERT
        if ($resultadoMedCat AND $resultadoMed) {
          $resultadoConsulta = "delete exitoso";
        } else {
          $error = print_r($stmt->errorInfo());
          $resultadoConsulta = "delete fallido";
        }
        break;
      default:
        //code block
    }
  } else {
    $modo = "insertar";
  }


  //=====================================================================================================================================================
  // INSERT Medicamento
  //=====================================================================================================================================================
  if (isset($_POST['btnInsertarMedicamento'])) {
    $nombreMedicamento = $_POST['nombreMedicamento'];
    $descripcionMedicamento = $_POST['descripcionMedicamento'];

    $imagen = $_FILES['imagenMedicamento']['tmp_name'];
    $imagenNombre = date("d-m-Y-H-i-s") . "-" . str_replace(' ', '_', $_FILES['imagenMedicamento']['name']);

    $stockTotal = $_POST['stockTotal'];
    $stockApartado = $_POST['stockApartado'];
    $stockDisponible = $stockTotal - $stockApartado;
    $cantidadMax = $_POST['cantidadMax'];
    $cantidadActual = $_POST['cantidadActual'];
    $idUnidadMedida = $_POST['idUnidadMedida'];
    $idCategoria = $_POST['idCategoria'];

    //---------------------------- Inserta en la base de datos ----------------------------
    $sql = "
            INSERT INTO
              medicamento (
                IDUnidadMedida,
                Nombre,
                Descripcion,
                StockTotal,
                StockApartado,
                StockDisponible,
                CantidadMaximaPorEnvase,
                CantidadActualPorEnvase,
                BitActivo,
                imagen
              )
            VALUES
              (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
    ";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $idUnidadMedida,
      $nombreMedicamento,
      $descripcionMedicamento,
      $stockTotal,
      $stockApartado,
      $stockDisponible,
      $cantidadMax,
      $cantidadActual,
      $imagenNombre
    ]);

    $ultimoIDMedicamento = $bdd->lastInsertId();

    // echo "$ultimoIDMedicamento";

    $sql = "INSERT INTO medicamento_categoria (IDMedicamento, IDCategoria, bitActivo)
                              VALUES (?, ?, 1)";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([$ultimoIDMedicamento, $idCategoria]);
    $ultimoIDMedicamentoCategoria = $bdd->lastInsertId();

    // ECHO "med_cat";


    $validaInsertMedicamento = $bdd->query("SELECT * FROM medicamento where IDMedicamento = $ultimoIDMedicamento AND bitActivo = 1");
    $validaInsertMedicamentoCategoria = $bdd->query("SELECT * FROM medicamento_categoria where IDMedicamentoCategoria = $ultimoIDMedicamentoCategoria AND bitActivo = 1");

    // //---------------------------- Valida el éxito del INSERT ----------------------------
    if ($validaInsertMedicamento and $validaInsertMedicamentoCategoria and move_uploaded_file($imagen, $ruta . $imagenNombre)) {
      $resultadoConsulta = "insert exitoso";
    } else {
      $error = print_r($stmt->errorInfo());
      $resultadoConsulta = "insert fallido";
    }

    $modo = "insertar";
    $IDMedicamento = NULL;
    $nombreMedicamento = NULL;
    $descripcionMedicamento = NULL;

    $imagenNombre = NULL;

    $stockTotal = NULL;
    $stockApartado = NULL;
    $stockDisponible = NULL;
    $cantidadMax = NULL;
    $cantidadActual = NULL;
    $idUnidadMedida = NULL;
    $idCategoria = NULL;
  }

  //=====================================================================================================================================================
  // UPDATE usuario
  //=====================================================================================================================================================

  if (isset($_POST['btnActualizarMedicamento'])) {
    $IDMedicamento = $_POST['IDMedicamento'];
    $imagenMedicamentoActual = $_POST['imagenMedicamentoActual'];

    $nombreMedicamento = $_POST['nombreMedicamento'];
    $descripcionMedicamento = $_POST['descripcionMedicamento'];

    $imagen = $_FILES['imagenMedicamento']['tmp_name'];

    $stockTotal = $_POST['stockTotal'];
    $stockApartado = $_POST['stockApartado'];
    $stockDisponible = $stockTotal - $stockApartado;
    $cantidadMax = $_POST['cantidadMax'];
    $cantidadActual = $_POST['cantidadActual'];
    $idUnidadMedida = $_POST['idUnidadMedida'];
    $idCategoria = $_POST['idCategoria'];

    $idMedicamentoCategoria = $_POST['idMedicamentoCategoria'];

    // Si agregaron una imagen nueva y borramos la anterior e insertamos la nueva
    if (is_file($imagen)) {
      unlink($ruta . $imagenMedicamentoActual);
      $imagenNombre = date("d-m-Y-H-i-s") . "-" . str_replace(' ', '_', $_FILES['imagenMedicamento']['name']);
      (move_uploaded_file($imagen, $ruta . $imagenNombre)) ? $resArchivo = true : $resArchivo = false;
    } else {
      // Si no, solo reasignamos el nombre del archivo al anterior
      $imagenNombre = $imagenMedicamentoActual;
      $resArchivo = true;
    }

    //---------------------------- UPDATE en la base de datos ----------------------------
    $sql = "UPDATE medicamento 
        SET IDUnidadMedida = ?,
            Nombre = ?,
            Descripcion = ?,
            StockTotal = ?,
            StockApartado = ?,
            StockDisponible = ?,
            CantidadMaximaPorEnvase = ?,
            CantidadActualPorEnvase = ?,
            imagen = ?
        WHERE IDMedicamento = ?";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $idUnidadMedida,
      $nombreMedicamento,
      $descripcionMedicamento,
      $stockTotal,
      $stockApartado,
      $stockDisponible,
      $cantidadMax,
      $cantidadActual,
      $imagenNombre,
      $IDMedicamento
    ]);

    $ultimoID = $bdd->lastInsertId();
    $validaUpdateMedicamento = $bdd->query("SELECT * FROM medicamento WHERE IDMedicamento = $IDMedicamento");
    $existeMedicamento = $validaUpdateMedicamento && $validaUpdateMedicamento->rowCount() > 0;

    $sql = "UPDATE medicamento_categoria 
        SET IDCategoria = ?
        WHERE IDMedicamentoCategoria = ?";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $idCategoria,
      $idMedicamentoCategoria
    ]);

    $ultimoID = $bdd->lastInsertId();
    $validaUpdateMedicamentoCategoria = $bdd->query("SELECT * FROM medicamento_categoria WHERE IDMedicamentoCategoria = $idMedicamentoCategoria");
    $existeCategoria = $validaUpdateMedicamentoCategoria && $validaUpdateMedicamentoCategoria->rowCount() > 0;

    //---------------------------- Valida el éxito del UPDATE ----------------------------
    if ($existeMedicamento && $existeCategoria && (isset($resArchivo) ? $resArchivo : true)) {
      $resultadoConsulta = "update exitoso";
    } else {
      $error = print_r($stmt->errorInfo(), true);
      $resultadoConsulta = "update fallido";
    }
    $modo = "insertar";
    $IDMedicamento = NULL;
    $nombreMedicamento = NULL;
    $descripcionMedicamento = NULL;

    $imagenNombre = NULL;

    $stockTotal = NULL;
    $stockApartado = NULL;
    $stockDisponible = NULL;
    $cantidadMax = NULL;
    $cantidadActual = NULL;
    $idUnidadMedida = NULL;
    $idCategoria = NULL;
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
