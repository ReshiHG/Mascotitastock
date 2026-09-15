<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('ROL_JEFE_CLINICA', 1);
define('ROL_VETERINARIO', 2);
define('ROL_GERENTE_INVENTARIO', 3);
define('ROL_PROVEEDOR', 4);
define('ROL_DESARROLLADOR', 5);