<!DOCTYPE html>
<html lang="es">

<?php
require("../encabezados/head.php");
?>

<head>
  <?= generarHead('Medicamentos') ?>
</head>

<header>
  <?php
  require("../encabezados/encabezado_desarrollador.php");
  ?>
  <script src="../../js/app.js"></script>
</header>

<body>
  <?php
  include("../../controladores/manejadorMedicamento.php");
  ?>
  <script>
    function eliminar() {
      var respuesta = confirm("¿Seguro desea eliminar el Medicamento?");
      return respuesta;
    }
  </script>
  <div class="contenedor-titulo">
    <h1 class="titulo titulo-pagina">Medicamentos</h1>
  </div>

  <div class="container">
    <div class="accordion" id="acordeonUsuarios">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
            <?php if ($modo === 'insertar') : ?>
              Agregar medicamento
            <?php else : ?>
              Actualizar medicamento
            <?php endif; ?>
          </button>
        </h2>
        <div id="collapseUsuarios" class="accordion-collapse collapse show">
          <div class="accordion-body contenedor-acordeon">
            <div class="container">
              <div class="row">
                <?php if ($modo === 'insertar') : ?>
                  <h5 class="encabezadoForm">Agrega los datos del medicamento</h5>
                <?php else : ?>
                  <h5 class="encabezadoForm">Modifica los datos que necesites</h5>
                <?php endif; ?>
              </div>
              <?php
              switch ($resultadoConsulta) {
                case 'insert exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Registro agregado correctamente!</div>";
                  break;

                case 'insert fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido agregar el registro :c <br> $error</div>";
                  break;

                case 'update exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Medicamento actualizado correctamente!</div>";
                  break;

                case 'update fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido actualizar el registro :c <br> $error</div>";
                  break;

                case 'delete exitoso':
                  echo "<div class='alert alert-danger' role='alert'>¡Medicamento eliminado exitosamente!</div>";
                  break;

                case 'delete fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido eliminar el registro :c <br> $error</div>";
                  break;

                default:
                  break;
              }
              ?>

              <form action="" name="formAgregarMedicamento" method="post" enctype="multipart/form-data">
                <div class="row">
                  <input type="hidden" name="IDMedicamento" value="<?= $IDMedicamento ?? '' ?>">
                  <input type="hidden" name="imagenMedicamentoActual" value="<?= $imagen ?? '' ?>">
                  <input type="hidden" name="idMedicamentoCategoria" value="<?= $idMedicamentoCategoria ?? '' ?>">
                  <div class="elementoForm col-md-6">
                    <label for="nombreMedicamento">Nombre:</label>
                    <input placeholder="Nombre del medicamento" type="text" class="form-control" name="nombreMedicamento" id="nombreMedicamento" value="<?= $nombreMedicamento ?? '' ?>" required autofocus>
                  </div>
                  <div class="elementoForm col-md-6">
                    <label for="imagenMedicamento">Imagen:</label>
                    <input type="file" class="form-control" accept="image/png, image/jpeg, image/jpg" name="imagenMedicamento" id="imagenMedicamento">
                  </div>
                  <div class="elementoForm">
                    <label for="descripcionMedicamento">Descripción:</label>
                    <textarea placeholder="Descripción del medicamento" class="form-control" name="descripcionMedicamento" id="descripcionMedicamento" rows="5"" ><?= $descripcionMedicamento ?? '' ?></textarea>
                  </div>
                  <div class=" elementoForm align-self-end col-md-6 col-lg-3">
                    <label for="stockTotal">Stock total:</label>
                    <input placeholder="Número de unidades totales"  type="number" class="form-control" name="stockTotal" id="stockTotal" value="<?= $stockTotal ?? '' ?>" required>
                  </div>
                  <div class="elementoForm align-self-end col-md-6 col-lg-3">
                    <label for="stockApartado">Stock apartado:</label>
                    <input placeholder="Número de unidades apartadas" type="number" class="form-control" name="stockApartado" id="stockApartado" value="<?= $stockApartado ?? '' ?>" required>
                  </div>
                  <div class="elementoForm col-md-6 col-lg-3">
                    <label for="cantidadMax">Cantidad máxima por envase:</label>
                    <input  placeholder="Cantidad máxima por envase" type="number" class="form-control" name="cantidadMax" id="cantidadMax" value="<?= $cantidadMaximaPorEnvase ?? '' ?>" required>
                  </div>
                  <div class="elementoForm col-md-6 col-lg-3">
                    <label for="cantidadActual">Cantidad actual por envase:</label>
                    <input placeholder="Cantidad actual por envase" type="number" class="form-control" name="cantidadActual" id="cantidadActual" value="<?= $cantidadActualPorEnvase ?? '' ?>" required>
                  </div>
                  <div class="elementoForm col-md-6">
                    <label for="unidadMedida">Seleccione la unidad de medida:</label>
                    <select class="form-select" name="idUnidadMedida" id="unidadMedida">
                      <?php foreach ($arrayUnidadMedida as $unidad): ?>
                        <option value="<?= $unidad['IDUnidadMedida'] ?>" <?= ($unidad['IDUnidadMedida'] == $idUnidadMedida) ? 'selected' : '' ?>>
                          <?= $unidad['Nombre'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="elementoForm col-md-6">
                    <label for="categoria">Seleccione la categoria:</label>
                    <select class="form-select" name="idCategoria" id="categoria">
                      <?php foreach ($arrayCategoria as $cat): ?>
                        <option value="<?= $cat['IDCategoria'] ?>" <?= ($cat['IDCategoria'] == $idCategoria) ? 'selected' : '' ?>>
                          <?= $cat['Nombre'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <?php if ($modo === 'insertar') : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnInsertarMedicamento">Guardar</button>
                    <?php else : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnActualizarMedicamento">Actualizar</button>
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
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdminMedicamentos" aria-expanded="false" aria-controls="collapseAdminMedicamentos">
            Administrar Medicamentos
          </button>
        </h2>
        <div id="collapseAdminMedicamentos" class="accordion-collapse collapse show">
          <div class="accordion-body container contenedor-acordeon">
            <div class="d-flex justify-content-end">
                <input class="col-sm-5 col-lg-6 col-xl-4 mx-2 input-buscador" type="search" placeholder="Buscar medicamento" aria-label="Search" id="buscador">
                <button onclick="buscar()" class="btn boton-secundario col-sm-3 col-lg-2 col-xl-1 mx-2" type="submit" name="btnBuscarMedicamento">Buscar</button>
                <button onclick="limpiar()" class="btn boton-terciario col-sm-3 col-lg-2 col-xl-1 mx-2" type="submit" name="btnLimpiar">Limpiar</button>
            </div>
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
              <?php
              require("../../controladores/consultarMedicamento.php");
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