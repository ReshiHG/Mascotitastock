<!DOCTYPE html>
<html lang="es">

<?php
require("../encabezados/head.php");
?>

<head>
  <?= generarHead('Inventario') ?>
</head>

<header>
  <?php
  require("../encabezados/encabezado_desarrollador.php");
  ?>
</header>

<body>
  <?php
  include("../../controladores/manejadorInventario.php");
  ?>
  <div class="contenedor-titulo">
    <h1 class="titulo titulo-pagina">Inventario</h1>
  </div>

  <div class="container">
    <div class="row row-cols-xs-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
      <?php
      require("../../controladores/consultarInventario.php");
      ?>
    </div>
  </div>

</body>

</html>