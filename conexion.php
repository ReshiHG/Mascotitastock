<?php
require_once __DIR__ . '/config.php'; //Carga el .env

function getConexion(): PDO {
  static $conexion = null;

  if ($conexion === null) {
    try {
      $host     = $_ENV['DB_HOST'];
      $dbname   = $_ENV['DB_NAME'];
      $user     = $_ENV['DB_USER'];
      $password = $_ENV['DB_PASSWORD'];

      $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Error de conexión: " . $e->getMessage());
    }
  }

  return $conexion;
}