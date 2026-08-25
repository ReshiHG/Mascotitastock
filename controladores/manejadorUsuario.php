<?php
try {

  // Conecta con la base de datos
  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');

  // Inicializa variables
  $modo = "";

  $IDUsuario = 0;
  $IDRol = 0;
  $Nombre = "";
  $ApellidoPaterno = "";
  $ApellidoMaterno = "";
  $Email = "";
  $Contrasenia = "";
  $Telefono = 0;
  $BitActivo = 0;

  $resultadoConsulta = "";

  //=====================================================================================================================================================
  //Validamos operacion UPDATE O DELETE
  //=====================================================================================================================================================
  if (isset($_GET['id']) and isset($_GET['modo'])) {
    $ID = $_GET['id'];
    $modo = $_GET['modo'];
    switch ($modo) {
        // ============ Asigna variables para llenar formulario UPDATE ================
      case "actualizar":
        $resultado = $bdd->query("SELECT * FROM usuario where IDUsuario = $ID");
        foreach ($resultado as $res) {
          $IDUsuario = $res['IDUsuario'];
          $IDRol = $res['IDRol'];
          $Nombre = $res['Nombre'];
          $ApellidoPaterno = $res['ApellidoPaterno'];
          $ApellidoMaterno = $res['ApellidoMaterno'];
          $Email = $res['Email'];
          $Contrasenia = $res['Contraseña'];
          $Telefono = $res['Telefono'];
          $BitActivo = $res['BitActivo'];
        }
        break;
        // ======================= Elimina en la base de datos =========================
      case "eliminar":
        $sql = "DELETE FROM usuario WHERE IDUsuario = ?";

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
  // INSERT usuario
  //=====================================================================================================================================================
  if (isset($_POST['btnInsertarUsuario'])) {
    $IDRol = $_POST['IDRol'];
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $email = $_POST['email'];
    $contrasenia = $_POST['contrasenia'];
    $telefono = $_POST['telefono'];

    //---------------------------- Inserta en la base de datos ----------------------------
    $sql = "INSERT INTO usuario (IDRol, Nombre, ApellidoPaterno, ApellidoMaterno, Email, Contraseña, Telefono, BitActivo)
                              VALUES (?, ?, ?, ?, ?, ?, ?, 1)";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([$IDRol, $nombre, $apellidoPaterno, $apellidoMaterno, $email, $contrasenia, $telefono]);
    $ultimoID = $bdd->lastInsertId();

    //---------------------------- Valida el éxito del INSERT ----------------------------
    if ($resultado) {
      $resultado = $bdd->query("SELECT IDUsuario,IDRol,Nombre,ApellidoPaterno,ApellidoMaterno,Email,Contraseña,Telefono FROM usuario where IDUsuario = $ultimoID");
      $resultadoConsulta = "insert exitoso";
    } else {
      $error = print_r($stmt->errorInfo());
      $resultadoConsulta = "insert fallido";
    }
    $modo = "insertar";
    $IDUsuario = 0;
    $IDRol = 0;
    $Nombre = "";
    $ApellidoPaterno = "";
    $ApellidoMaterno = "";
    $Email = "";
    $Contrasenia = "";
    $Telefono = 0;
    $BitActivo = 0;
  }

  //=====================================================================================================================================================
  // UPDATE usuario
  //=====================================================================================================================================================

  if (isset($_POST['btnActualizarUsuario'])) {
    $IDRol = $_POST['IDRol'];
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $email = $_POST['email'];
    $contrasenia = $_POST['contrasenia'];
    $telefono = $_POST['telefono'];

    //---------------------------- UPDATE en la base de datos ----------------------------
    $sql = "UPDATE usuario 
        SET IDRol = ?, 
            Nombre = ?, 
            ApellidoPaterno = ?, 
            ApellidoMaterno = ?, 
            Email = ?, 
            Contraseña = ?, 
            Telefono = ?
        WHERE IDUsuario = ?";

    $stmt = $bdd->prepare($sql);
    $resultado = $stmt->execute([
      $IDRol,
      $nombre,
      $apellidoPaterno,
      $apellidoMaterno,
      $email,
      $contrasenia,
      $telefono,
      $IDUsuario // Este debe venir del formulario o de la URL
    ]);

    $ultimoID = $bdd->lastInsertId();

    //---------------------------- Valida el éxito del UPDATE ----------------------------
    if ($resultado) {
      $resultado = $bdd->query("SELECT IDUsuario,IDRol,Nombre,ApellidoPaterno,ApellidoMaterno,Email,Contraseña,Telefono FROM usuario where IDUsuario = $ultimoID");
      $resultadoConsulta = "update exitoso";
    } else {
      $error = print_r($stmt->errorInfo());
      $resultadoConsulta = "update fallido";
    }
    $modo = "insertar";
    $IDUsuario = 0;
    $IDRol = 0;
    $Nombre = "";
    $ApellidoPaterno = "";
    $ApellidoMaterno = "";
    $Email = "";
    $Contrasenia = "";
    $Telefono = 0;
    $BitActivo = 0;
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
