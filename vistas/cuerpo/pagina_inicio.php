<!DOCTYPE html>
<html lang="es">

<?php 
  require("../encabezados/head.php");
?>

<head>
  <?= generarHead('Inicio') ?>
</head>

<header>
  <?php
  require("../encabezados/encabezado_desarrollador.php");
  ?>
</header>

<body>
    <div
      class="d-flex justify-content-center align-items-center"
      style="height: 70vh"
    >
      <div class="card" style="width: 400px">
        <div class="card-body">
          <h1 class="card-title titulo">INICIO</h1>
          <br>
          <br>
          <p class="card-text">
            <a href="pagina_usuarios.php" class="btn boton-primario btn-lg btn-block">Usuarios</a>
          </p>
          <p class="card-text">
            <a href="pagina_inventario.php" class="btn boton-primario btn-lg btn-block">Inventario</a>
          </p>
          <p class="card-text">
            <a href="pagina_medicamentos.php" class="btn boton-primario btn-lg btn-block">Gestión Medicamento</a>
          </p>
          <p class="card-text">
            <a href="pagina_categorias.php" class="btn boton-primario btn-lg btn-block">Gestión Categorias</a>
          </p>
          <p class="card-text">
            <a href="pagina_proveedores.php" class="btn boton-primario btn-lg btn-block">Proveedores</a>
          </p>
          <p class="card-text">
            <a href="pagina_pedidos.php" class="btn boton-primario btn-lg btn-block">Pedidos</a>
          </p>
          <!-- <p class="card-text">
            <a href="pagina_calendario.php" class="btn boton-primario btn-lg btn-block">Calendario</a>
          </p> -->
          <p class="card-text">
            <a href="../../index.php" class="btn boton-peligro btn-lg btn-block">Salir</a>
          </p>
        </div>
      </div>
    </div>
</body>

</html>