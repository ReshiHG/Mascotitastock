<!DOCTYPE html>
<html lang="es">

<?php
require("../encabezados/head.php");
// Array del menú. Titulo | Página | Roles autorizados
$opciones = [
  ['Usuarios',           'pagina_usuarios.php',     [ROL_JEFE_CLINICA, ROL_DESARROLLADOR]],
  ['Inventario',         'pagina_inventario.php',   [ROL_JEFE_CLINICA, ROL_VETERINARIO, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Gestión Medicamento', 'pagina_medicamentos.php', [ROL_JEFE_CLINICA, ROL_VETERINARIO, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Gestión Categorias', 'pagina_categorias.php',   [ROL_JEFE_CLINICA, ROL_VETERINARIO, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Proveedores',        'pagina_proveedores.php',  [ROL_JEFE_CLINICA, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Pedidos',            'pagina_pedidos.php',      [ROL_JEFE_CLINICA, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
];
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
    style="height: 70vh">
    <div class="card" style="width: 400px">
      <div class="card-body">
        <h1 class="card-title titulo">INICIO</h1>
        <br>
        <br>

        <?php foreach ($opciones as [$texto, $url, $roles]): ?>
          <?php if (in_array($_SESSION['IDRol'], $roles)): ?>
            <p class="card-text">
              <a href="<?= $url ?>" class="btn boton-primario btn-lg btn-block"><?= $texto ?></a>
            </p>
          <?php endif; ?>
        <?php endforeach; ?>

        <p class="card-text">
          <a href="../../controladores/cerrar_sesion.php" class="btn boton-peligro btn-lg btn-block">Salir</a>
        </p>
      </div>
    </div>
  </div>
</body>

</html>