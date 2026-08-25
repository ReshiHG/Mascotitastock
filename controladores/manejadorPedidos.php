<?php
try {

  // Conecta con la base de datos
  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');

  date_default_timezone_set('America/Mexico_City');

  // Inicializa variables
  $modo = "";
  $resultadoConsulta = "";
  $IDProveedor = 0;
  $IDEstadoPedido = 0;
  $fechaEntregaEstimada = null;
  $fechaEntregaReal = null;


  $arrayProveedor = [
    ["IDProveedor" => 0, "Nombre" => "Selecciona el proveedor"]
  ];

  $arrayEstadoPedido = [
    ["IDEstadoPedido" => 0, "Descripcion" => "Selecciona la etapa del pedido"]
  ];

  //Obtenemos los proveedores
  $stmt = $bdd->query("SELECT IDProveedor, Nombre, ApellidoPaterno, ApellidoMaterno FROM proveedor WHERE BitActivo = 1 ORDER BY Nombre");

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $arrayProveedor[] = [
      "IDProveedor" => $row['IDProveedor'],
      "Nombre" => (string)$row['Nombre'] . ' ' . (string)$row['ApellidoPaterno'] . ' ' . (string)$row['ApellidoMaterno']
    ];
  }

  //Obtenemos los estados de pedido para el formulario
  $stmt = $bdd->query("SELECT IDEstadoPedido, Descripcion FROM estado_pedido WHERE BitActivo = 1 ORDER BY IDEstadoPedido");

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $arrayEstadoPedido[] = [
      "IDEstadoPedido" => $row['IDEstadoPedido'],
      "Descripcion" => $row['Descripcion']
    ];
  }

  //=====================================================================================================================================================
  //Validamos operacion UPDATE O DELETE
  //=====================================================================================================================================================
  if (isset($_GET['id']) and isset($_GET['modo'])) {
    $ID = $_GET['id'];
    $modo = $_GET['modo'];
    switch ($modo) {
      // ============ Asigna variables para llenar formulario UPDATE ================
      case "actualizar":
        $resultado = $bdd->query("
          SELECT
            P.IDPedido,
            P.IDProveedor,
            PROV.Nombre,
            PROV.ApellidoPaterno,
            PROV.ApellidoMaterno,
            P.Descripcion,
            P.FechaSolicitud,
            P.FechaModifica,
            P.FechaEntregaEstimada,
            P.FechaEntregaReal,
            EP.IDEstadoPedido,
            EP.Descripcion descripcionPedido
          FROM
            pedido P
            INNER JOIN estado_pedido EP ON EP.IDEstadoPedido = P.EstadoPedido
            INNER JOIN proveedor PROV ON PROV.IDProveedor = P.IDProveedor
          WHERE
            P.bitActivo = 1
            AND P.IDPedido = $ID
          ORDER BY
            P.FechaEntregaEstimada DESC
        ");
        foreach ($resultado as $res) {
          $IDPedido = $res['IDPedido'];
          $descripcionPedido = $res['Descripcion'];
          $IDProveedor = $res['IDProveedor'];
          $fechaEntregaEstimada = $res['FechaEntregaEstimada'];
          $fechaEntregaReal = $res['FechaEntregaReal'];
          $IDEstadoPedido = $res['IDEstadoPedido'];
        }
        break;
      // ======================= Elimina en la base de datos =========================
      case "eliminar":
        $sql = "DELETE FROM pedido WHERE IDPedido = ?";

        $stmt = $bdd->prepare($sql);
        $resultado = $stmt->execute([$ID]);

        // Valida el éxito del INSERT
        if ($resultado) {
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
  // INSERT pedido
  //=====================================================================================================================================================
  if (isset($_POST['btnInsertarPedido'])) {
    $descripcionPedido = $_POST['descripcionPedido'];
    $IDProveedor = $_POST['IDProveedor'];
    $fechaSolicitud = date("Y-m-d H-i-s");
    $fechaEntregaEstimada = $_POST['fechaEntregaEstimada'];

    //---------------------------- Inserta en la base de datos ----------------------------
    $sql = "INSERT INTO pedido (IDProveedor, Descripcion, FechaSolicitud, FechaEntregaEstimada, EstadoPedido, BitActivo)
                              VALUES (?, ?, ?, ?, 3, 1)";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([$IDProveedor, $descripcionPedido, $fechaSolicitud, $fechaEntregaEstimada]);
    $ultimoID = $bdd->lastInsertId();
    $resultado = $bdd->query("SELECT * FROM pedido where IDPedido = $ultimoID");

    //---------------------------- Valida el éxito del INSERT ----------------------------
    if ($resultado) {
      $resultadoConsulta = "insert exitoso";
    } else {
      $resultadoConsulta = "insert fallido";
      $error = print_r($stmt->errorInfo());
    }
    $modo = "insertar";
    $IDPedido = null;
    $descripcionPedido = null;
    $IDProveedor = null;
    $fechaEntregaEstimada = null;
    $fechaEntregaReal = null;
    $IDPedido = null;
    $IDPedido = null;
  }

  //=====================================================================================================================================================
  // UPDATE pedido
  //=====================================================================================================================================================

  if (isset($_POST['btnActualizarPedido'])) {
    $IDPedido = $_POST['IDPedido'];
    $descripcionPedido = $_POST['descripcionPedido'];
    $IDProveedor = $_POST['IDProveedor'];
    $fechaEntregaEstimada = $_POST['fechaEntregaEstimada'];
    $fechaEntregaReal = $_POST['fechaEntregaReal'];
    $IDEstadoPedido = $_POST['estadoPedido'];

    if ($IDEstadoPedido <> 5) {
      $fechaEntregaReal = null;
    }

    //---------------------------- UPDATE en la base de datos ----------------------------
    $sql = "UPDATE pedido 
        SET IDProveedor = ?,
            Descripcion = ?, 
            FechaModifica = ?, 
            FechaEntregaEstimada = ?, 
            FechaEntregaReal = ?, 
            EstadoPedido = ?
        WHERE IDPedido = ?";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $IDProveedor,
      $descripcionPedido,
      date("Y-m-d H-i-s"),
      $fechaEntregaEstimada,
      $fechaEntregaReal,
      $IDEstadoPedido,
      $IDPedido
    ]);

    //---------------------------- Valida el éxito del UPDATE ----------------------------
    if ($resultado) {
      $consulta = $bdd->prepare("SELECT * FROM pedido WHERE IDPedido = ?");
      $consulta->execute([$IDProveedor]);
      $resultadoConsulta = "update exitoso";
    } else {
      $error = print_r($stmt->errorInfo());
      $resultadoConsulta = "update fallido";
    }
    $modo = "insertar";
    $IDPedido = null;
    $descripcionPedido = null;
    $IDProveedor = null;
    $fechaEntregaEstimada = null;
    $fechaEntregaReal = null;
    $IDPedido = null;
    $IDPedido = null;
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
