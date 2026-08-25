<?php
try {
  if ($_POST) {
    $email = $_POST["email"];
    $contrasenia = $_POST["contrasenia"];
    // echo "email: $email <br>";
    // echo "contraseña: $contrasenia <br>";


    $conexion = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');
    $resultado = $conexion->query("SELECT IDUsuario FROM usuario where Contraseña = '$contrasenia' and Email = '$email' and BitActivo = 1");

    if ($resultado->rowCount() > 0) {
      // echo "Usuario encontrado: ";
      // print_r($resultado);
      // header("Location:pagina_inicio.php");
      echo '<script>window.location.href="vistas/cuerpo/pagina_inicio.php";</script>';
    } else {
      echo '<div class="alert alert-warning" role="alert">¡Correo o contraseña erronea, favor de validar!</div>';
    }
  } else {
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
  ?>
