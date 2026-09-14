<?php
require_once __DIR__ . '/../config.php';

try {
  if ($_POST) {
    $email = $_POST["email"];
    $contrasenia = $_POST["contrasenia"];

    // Leer variables del .env
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];

    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conexion->prepare(
      "SELECT IDUsuario, Contrasenia FROM usuario 
       WHERE Email = :email 
         AND BitActivo = 1"
    );
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasenia, $usuario['Contrasenia'])) {
      echo '<script>window.location.href="vistas/cuerpo/pagina_inicio.php";</script>';
    } else {
      echo '<div class="alert alert-warning" role="alert">¡Correo o contraseña errónea, favor de validar!</div>';
    }
  }
} catch (PDOException $e) {
  echo '<div class="alert alert-danger" role="alert">¡Error! ' . $e->getMessage() . '</div>';
}
