<?php
// try {
//   if ($_POST) {
//     $email = $_POST["email"];
//     $contrasenia = $_POST["contrasenia"];
//     // echo "email: $email <br>";
//     // echo "contraseña: $contrasenia <br>";


//     $conexion = new PDO('mysql:host=localhost;dbname=mascotitastock', 'mascotitastockroot', 'm4sc0t1t4s');
//     $resultado = $conexion->query("SELECT IDUsuario FROM usuario where Contrasenia = '$contrasenia' and Email = '$email' and BitActivo = 1");

//     if ($resultado->rowCount() > 0) {
//       // echo "Usuario encontrado: ";
//       // print_r($resultado);
//       // header("Location:pagina_inicio.php");
//       echo '<script>window.location.href="vistas/cuerpo/pagina_inicio.php";</script>';
//     } else {
//       echo '<div class="alert alert-warning" role="alert">¡Correo o contraseña erronea, favor de validar!</div>';
//     }
//   } else {
//   }
// } catch (PDOException $e) { //Mostrar error
//   echo "Error: " . $e->getMessage();
// }


try {
  if ($_POST) {
    $email = $_POST["email"];
    $contrasenia = $_POST["contrasenia"];

    $conexion = new PDO('mysql:host=localhost;dbname=mascotitastock', 'mascotitastockroot', 'm4sc0t1t4s');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conexion->prepare("SELECT IDUsuario FROM usuario WHERE Contrasenia = :contrasenia AND Email = :email AND BitActivo = 1");
    $stmt->bindParam(':contrasenia', $contrasenia);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      echo '<script>window.location.href="vistas/cuerpo/pagina_inicio.php";</script>';
    } else {
      echo '<div class="alert alert-warning" role="alert">¡Correo o contraseña errónea, favor de validar!</div>';
    }
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>
