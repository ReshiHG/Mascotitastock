<?php
try {

  require("conexion.php");

  $modo = 'insertar';
  $resultadoConsulta = null;

  
  //=====================================================================================================================================================
  //Validamos operacion UPDATE O DELETE
  //=====================================================================================================================================================
  if (isset($_GET['id']) and isset($_GET['modo'])) {
    $IDCategoria = $_GET['id'];
    $modo = $_GET['modo'];
    switch ($modo) {
      // ============ Asigna variables para llenar formulario UPDATE ================
      case "actualizar":
        $resultado = $bdd->query("
                            SELECT
                              Nombre
                            FROM
                              categoria
                            WHERE
                              IDCategoria = $IDCategoria
                              AND BitActivo=1
        ");
  foreach ($resultado as $res) {
    $nombreCategoria = $res['Nombre'];
  }
        break;
      // ======================= Elimina en la base de datos =========================
      case "eliminar":
        $sql = "DELETE FROM categoria WHERE IDCategoria = ?";

        $stmt = $bdd->prepare($sql);
        $resultadoDelete = $stmt->execute([$IDCategoria]);
        
        // Valida el éxito del INSERT
        if ($resultadoDelete) {
          $resultadoConsulta = "delete exitoso";
        } else {
          $resultadoConsulta = "delete fallido";
          $error = print_r($stmt->errorInfo());
        }
        break;
      default:
        //code block
    }
  } else {
    $modo = "insertar";
  }

  //=====================================================================================================================================================
  // INSERT Categoria
  //=====================================================================================================================================================
  if (isset($_POST['btnInsertarCategoria'])) {

    $nombreCategoria = $_POST['nombreCategoria'];
    //---------------------------- Inserta en la base de datos ----------------------------
    $sql = "
            INSERT INTO
              categoria (
                Nombre,
                BitActivo
              )
            VALUES
              (?, 1)
    ";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $nombreCategoria
    ]);

    $ultimoIDCategoria = $bdd->lastInsertId();
    $validaInsertCategoria = $bdd->query("SELECT * FROM categoria where IDCategoria = $ultimoIDCategoria AND bitActivo = 1");

    // //---------------------------- Valida el éxito del INSERT ----------------------------
    if ($validaInsertCategoria) {
      $resultadoConsulta = "insert exitoso";
    } else {
      $resultadoConsulta = "insert fallido";
      $error = print_r($stmt->errorInfo());
    }

    $modo = "insertar";
    $IDCategoria = NULL;
    $nombreCategoria = NULL;
  }


  //=====================================================================================================================================================
  // UPDATE usuario
  //=====================================================================================================================================================

  if (isset($_POST['btnActualizarCategoria'])) {
    $IDCategoria = $_POST['IDCategoria'];
    $nombreCategoria = $_POST['nombreCategoria'];

    //---------------------------- UPDATE en la base de datos ----------------------------
    $sql = "UPDATE categoria 
        SET Nombre = ?
        WHERE IDCategoria = ?";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $nombreCategoria,
      $IDCategoria
    ]);

    $validaUpdateCategoria = $bdd->query("SELECT * FROM categoria WHERE IDCategoria = $IDCategoria");
    $existecategoria = $validaUpdateCategoria && $validaUpdateCategoria->rowCount() > 0;

    //---------------------------- Valida el éxito del UPDATE ----------------------------
    if ($existecategoria) {
      $resultadoConsulta = "update exitoso";
    } else {
      $resultadoConsulta = "update fallido";
      $error = print_r($stmt->errorInfo(), true);
    }
    $modo = "insertar";
    $IDCategoria = NULL;
    $nombreCategoria = NULL;
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
