<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Si no hay usuario en sesión → redirigir al login
if (!isset($_SESSION['IDUsuario'])) {
  // Redirigir al index (login). Ajusta la ruta según la ubicación del archivo.
  header("Location: /index.php");
  exit;
}