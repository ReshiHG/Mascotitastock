<!DOCTYPE html>
<html lang="es">

<?php
require("../encabezados/head.php");
?>

<head>
  <?= generarHead('Proveedores') ?>
</head>

<header>
  <?php
  require("../encabezados/encabezado_desarrollador.php");
  ?>
</header>

<body>
  <?php
  include("../../controladores/manejadorProveedor.php");
  ?>
  <script>
    function eliminar() {
      var respuesta = confirm("¿Seguro desea eliminar el usuario?");
      return respuesta;
    }
  </script>
  <div class="contenedor-titulo">
    <h1 class="titulo titulo-pagina">Proveedores</h1>
  </div>

  <div class="container">
    <div class="accordion" id="acordeonUsuarios">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
            <?php if ($modo === 'insertar') : ?>
              Agregar proveedor
            <?php else : ?>
              Actualizar proveedor
            <?php endif; ?>
          </button>
        </h2>
        <div id="collapseUsuarios" class="accordion-collapse collapse show">
          <div class="accordion-body contenedor-acordeon">
            <div class="container">
              <div class="row">
                <?php if ($modo === 'insertar') : ?>
                  <h4>Agrega los datos correspondientes para genear un nuevo proveedor</h4>
                <?php else : ?>
                  <h4>Modifica los datos que necesites</h4>
                <?php endif; ?>
              </div>
              <?php
              switch ($resultadoConsulta) {
                case 'insert exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Proveedor agregado correctamente!</div>";
                  break;

                case 'insert fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido agregar el proveedor :c <br> $error</div>";
                  break;

                case 'update exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Proveedor actualizado correctamente!</div>";
                  break;

                case 'update fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido actualizar el proveedor :c <br> $error</div>";
                  break;

                case 'delete exitoso':
                  echo "<div class='alert alert-danger' role='alert'>¡Proveedor eliminado exitosamente!</div>";
                  break;

                case 'delete fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido eliminar el proveedor :c <br> $error</div>";
                  break;

                default:
                  break;
              }
              ?>

              <form action="" name="formAgregarUsuario" method="post">
                <div class="row">
                  <h5 class="encabezadoForm">Datos generales</h5>
                </div>
                <div class="row">
                  <input type="hidden" name="IDProveedor" value="<?= $IDProveedor ?>">
                  <div class="col-sm-12 col-md-12 col-lg-4 elementoForm">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" value="<?= $Nombre ?>" required>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-4 elementoForm">
                    <label for="apellidoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" placeholder="Apellido Paterno" name="apellidoPaterno" id="apellidoPaterno" value="<?= $ApellidoPaterno ?>">
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-4 elementoForm">
                    <label for="apellidoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" placeholder="Apellido Materno" name="apellidoMaterno" id="apellidoMaterno" value="<?= $ApellidoMaterno ?>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-6 elementoForm">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?= $Email ?>" required>
                  </div>
                  <div class="col-sm-12 col-md-6 elementoForm">
                    <label for="telefono">Telefono</label>
                    <input type="tel" class="form-control" placeholder="Telefono" name="telefono" id="telefono" value="<?= $Telefono ?>" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <?php if ($modo === 'insertar') : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnInsertarProveedor">Enviar</button>
                    <?php else : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnActualizarProveedor">Actualizar</button>
                    <?php endif; ?>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

      </div>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdminUsuarios" aria-expanded="false" aria-controls="collapseAdminUsuarios">
            Administrar proveedores
          </button>
        </h2>
        <div id="collapseAdminUsuarios" class="accordion-collapse collapse show">
          <div class="accordion-body container contenedor-acordeon">
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
              <?php
              require("../../controladores/consultarProveedor.php");
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  </div>
</body>

</html>