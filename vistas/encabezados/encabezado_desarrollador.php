<?php
// Array del menú. Titulo | Página | Roles autorizados
$navItems = [
  ['Usuarios',           'pagina_usuarios.php',     [ROL_JEFE_CLINICA, ROL_DESARROLLADOR]],
  ['Inventario',         'pagina_inventario.php',   [ROL_JEFE_CLINICA, ROL_VETERINARIO, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Gestión Medicamento', 'pagina_medicamentos.php', [ROL_JEFE_CLINICA, ROL_VETERINARIO, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Gestión Categorias', 'pagina_categorias.php',   [ROL_JEFE_CLINICA, ROL_VETERINARIO, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Proveedores',        'pagina_proveedores.php',  [ROL_JEFE_CLINICA, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
  ['Pedidos',            'pagina_pedidos.php',      [ROL_JEFE_CLINICA, ROL_GERENTE_INVENTARIO, ROL_DESARROLLADOR]],
];
?>
<nav class="navbar navbar-expand-lg barra-navegacion">
  <div class="container-fluid">
    <a class="navbar-brand" href="../cuerpo/pagina_inicio.php"><img
        src="../../public/imagenes/Logo MyM favicon.png"
        alt="Mascotas y Mascotitas"
        height="50px" /></a>
    <a class="navbar-brand enlace-nav logo" href="../cuerpo/pagina_inicio.php">Mascotas y Mascotitas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <img src="../../public/imagenes/hamburger-claro.svg" alt="" srcset="">
    </button>
    <div
      class="collapse navbar-collapse justify-content-lg-end"
      id="navbarSupportedContent">
      <div class="navbar-nav">
        <a class="nav-link enlace enlace-nav" href="pagina_inicio.php">Inicio</a>
      </div>
      <?php foreach ($navItems as [$texto, $url, $roles]): ?>
        <?php if (in_array($_SESSION['IDRol'], $roles)): ?>

          <div class="navbar-nav">
            <a class="nav-link enlace enlace-nav" href="<?= $url ?>"><?= $texto ?></a>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
      <div class="navbar-nav">
        <a class="nav-link enlace enlace-nav" href="../../controladores/cerrar_sesion.php">Salir</a>
      </div>
    </div>
  </div>
</nav>