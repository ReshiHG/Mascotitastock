<?php
try {

  // Conecta con la base de datos
  $conexion = require_once __DIR__ . '/../conexion.php';

  // Inicializa variables
  $modo = "";

  $IDProveedor = 0;
  $Nombre = "";
  $ApellidoPaterno = "";
  $ApellidoMaterno = "";
  $Email = "";
  $Telefono = null;
  $BitActivo = 0;

  $resultadoConsulta = "";
  date_default_timezone_set('America/Mexico_City');

  //=====================================================================================================================================================
  //Validamos operacion UPDATE O DELETE
  //=====================================================================================================================================================
  if (isset($_GET['id']) and isset($_GET['modo'])) {
    $ID = $_GET['id'];
    $modo = $_GET['modo'];
    switch ($modo) {
      // ============ Asigna variables para llenar formulario UPDATE ================
      case "actualizar":
        $resultado = $conexion->query("SELECT IDProveedor, Nombre, ApellidoPaterno, ApellidoMaterno, Email, Telefono FROM proveedor where IDProveedor = $ID AND bitActivo=1");
        foreach ($resultado as $res) {
          $IDProveedor = $res['IDProveedor'];
          $Nombre = $res['Nombre'];
          $ApellidoPaterno = $res['ApellidoPaterno'];
          $ApellidoMaterno = $res['ApellidoMaterno'];
          $Email = $res['Email'];
          $Telefono = $res['Telefono'];
        }
        break;
      // ======================= Elimina en la base de datos =========================
      case "eliminar":
        $sql = "DELETE FROM proveedor WHERE IDProveedor = ?";

        $stmt = $conexion->prepare($sql);
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
  // INSERT proveedor
  //=====================================================================================================================================================
  if (isset($_POST['btnInsertarProveedor'])) {
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fechaInsert = date("Y-m-d H-i-s");

    //---------------------------- Inserta en la base de datos ----------------------------
    $sql = "INSERT INTO proveedor (Nombre, ApellidoPaterno, ApellidoMaterno, Email, FechaCreacion, Telefono, BitActivo)
                              VALUES (?, ?, ?, ?, ?, ?, 1)";

    $stmt = $conexion->prepare($sql);
    $resultado = $stmt->execute([$nombre, $apellidoPaterno, $apellidoMaterno, $email, $fechaInsert, $telefono]);
    $ultimoID = $conexion->lastInsertId();

    //---------------------------- Valida el éxito del INSERT ----------------------------
    $resultado = $conexion->query("SELECT * FROM proveedor where IDProveedor = $ultimoID");
    if ($resultado) {
      $resultadoConsulta = "insert exitoso";
    } else {
      $error = print_r($stmt->errorInfo());
      $resultadoConsulta = "insert fallido";
    }
    $modo = "insertar";
    $IDProveedor = 0;
    $Nombre = "";
    $ApellidoPaterno = "";
    $ApellidoMaterno = "";
    $Email = "";
    $Telefono = 0;
    $BitActivo = 0;
  }

  //=====================================================================================================================================================
  // UPDATE usuario
  //=====================================================================================================================================================

  if (isset($_POST['btnActualizarProveedor'])) {
    $IDProveedor = $_POST['IDProveedor'];
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $fechaUpdate = date("Y-m-d H-i-s");

    //---------------------------- UPDATE en la base de datos ----------------------------
    $sql = "UPDATE proveedor 
        SET Nombre = ?, 
            ApellidoPaterno = ?, 
            ApellidoMaterno = ?, 
            Email = ?, 
            Telefono = ?,
            FechaModifica = ?
        WHERE IDProveedor = ?";

    $stmt = $conexion->prepare($sql);
    $resultado = $stmt->execute([
      $nombre,
      $apellidoPaterno,
      $apellidoMaterno,
      $email,
      $telefono,
      $fechaUpdate,
      $IDProveedor // Este debe venir del formulario o de la URL
    ]);

    //---------------------------- Valida el éxito del UPDATE ----------------------------
    if ($resultado) {
      $consulta = $conexion->prepare("SELECT * FROM proveedor WHERE IDProveedor = ?");
      $consulta->execute([$IDProveedor]);
      $resultadoConsulta = "update exitoso";
    } else {
      $error = print_r($stmt->errorInfo());
      $resultadoConsulta = "update fallido";
    }
    $modo = "insertar";
    $IDProveedor = 0;
    $Nombre = "";
    $ApellidoPaterno = "";
    $ApellidoMaterno = "";
    $Email = "";
    $Telefono = 0;
    $BitActivo = 0;
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
