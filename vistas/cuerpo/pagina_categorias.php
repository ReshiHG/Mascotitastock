<!DOCTYPE html>
<html lang="es">

<?php
require("../encabezados/head.php");
?>

<head>
  <?= generarHead('Categorías') ?>
</head>

<header>
  <?php
  require("../encabezados/encabezado_desarrollador.php");
  ?>
</header>

<body>
  <?php
  include("../../controladores/manejadorCategoria.php");
  ?>
  <script>
    function eliminar() {
      var respuesta = confirm("¿Seguro desea eliminar la categoría?");
      return respuesta;
    }
  </script>
  <div class="contenedor-titulo">
    <h1 class="titulo titulo-pagina">Categorías</h1>
  </div>

  <div class="container">
    <div class="accordion" id="acordeonCategorias">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategorias" aria-expanded="false" aria-controls="collapseCategorias">
            <?php if ($modo === 'insertar') : ?>
              Agregar categoría
            <?php else : ?>
              Actualizar categoría
            <?php endif; ?>
          </button>
        </h2>
        <div id="collapseCategorias" class="accordion-collapse collapse show">
          <div class="accordion-body contenedor-acordeon">
            <div class="container">
              <?php
              switch ($resultadoConsulta) {
                case 'insert exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Registro agregado correctamente!</div>";
                  break;

                case 'insert fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido agregar el registro :c <br> $error</div>";
                  break;

                case 'update exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Categoría actualizada correctamente!</div>";
                  break;

                case 'update fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido actualizar el registro :c <br> $error</div>";
                  break;

                case 'delete exitoso':
                  echo "<div class='alert alert-danger' role='alert'>¡Categoría eliminada exitosamente!</div>";
                  break;

                case 'delete fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido eliminar el registro :c <br> $error</div>";
                  break;

                default:
                  break;
              }
              ?>

              <form action="" name="formAgregarCategoria" method="post">
                <div class="row">
                  <input type="hidden" name="IDCategoria" value="<?= $IDCategoria ?? '' ?>">
                  <div class="elementoForm">
                    <label for="nombreMedicamento">Nombre:</label>
                    <input type="text" class="form-control" name="nombreCategoria" id="nombreCategoria" value="<?= $nombreCategoria ?? '' ?>" required autofocus>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <?php if ($modo === 'insertar') : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnInsertarCategoria">Enviar</button>
                    <?php else : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnActualizarCategoria">Actualizar</button>
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
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdminCategorias" aria-expanded="false" aria-controls="collapseAdminCategorias">
            Administrar categorías
          </button>
        </h2>
        <div id="collapseAdminCategorias" class="accordion-collapse collapse show">
          <div class="accordion-body container contenedor-acordeon">
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
              <?php
              require("../../controladores/consultarCategoria.php");
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