<!DOCTYPE html>
<html lang="es">

<?php
date_default_timezone_set('America/Mexico_City');
require("../encabezados/head.php");
?>

<head>
  <?= generarHead('Pedidos') ?>
</head>

<header>
  <?php
  require("../encabezados/encabezado_desarrollador.php");
  ?>
</header>

<body>
  <?php
  include("../../controladores/manejadorPedidos.php");
  ?>
  <script>
    function eliminar() {
      var respuesta = confirm("¿Seguro desea eliminar el pedido?");
      return respuesta;
    }
  </script>
  <div class="contenedor-titulo">
    <h1 class="titulo titulo-pagina">Pedidos</h1>
  </div>

  <div class="container">
    <div class="accordion" id="acordeonPedidos">
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePedidos" aria-expanded="false" aria-controls="collapsePedidos">
            <?php if ($modo === 'insertar') : ?>
              Agregar pedido
            <?php else : ?>
              Actualizar pedido
            <?php endif; ?>
          </button>
        </h2>
        <div id="collapsePedidos" class="accordion-collapse collapse show">
          <div class="accordion-body contenedor-acordeon">
            <div class="container">
              <div class="row">
                <?php if ($modo === 'insertar') : ?>
                  <h4>Agrega los datos correspondientes para genear un nuevo pedido</h4>
                <?php else : ?>
                  <h4>Modifica los datos que necesites</h4>
                <?php endif; ?>
              </div>
              <?php
              switch ($resultadoConsulta) {
                case 'insert exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Pedido agregado correctamente!</div>";
                  break;

                case 'insert fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido agregar el pedido :c <br> $error</div>";
                  break;

                case 'update exitoso':
                  echo "<div class='alert alert-success' role='alert'>¡Pedido actualizado correctamente!</div>";
                  break;

                case 'update fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido actualizar el pedido :c <br> $error</div>";
                  break;

                case 'delete exitoso':
                  echo "<div class='alert alert-danger' role='alert'>¡Pedido eliminado exitosamente!</div>";
                  break;

                case 'delete fallido':
                  echo "<div class='alert alert-danger' role='alert'>No se ha podido eliminar el pedido :c <br> $error</div>";
                  break;

                default:
                  break;
              }
              ?>

              <form action="" name="formAgregarPedido" method="post">
                <div class="row">
                  <h5 class="encabezadoForm">Datos generales</h5>
                </div>
                <div class="row">
                  <input type="hidden" name="IDPedido" value="<?= $IDPedido ?>">
                  <div class="col-sm-12 elementoForm">
                    <label for="descripcionPedido">Descripción:</label>
                    <textarea placeholder="Agrega la solicitud de medicamentos" class="form-control" name="descripcionPedido" id="descripcionPedido" rows="5"" required><?= $descripcionPedido ?? '' ?></textarea>
                  </div>
                  <div class=" elementoForm col-sm-12 col-md-6 col-lg">
                    <label for="proveedor">Proveedor:</label>
                    <select class="form-select" name="IDProveedor" id="IDProveedor">
                      <?php foreach ($arrayProveedor as $proveedor): ?>
                        <option value="<?= $proveedor['IDProveedor'] ?>" <?= ($proveedor['IDProveedor'] == $IDProveedor) ? 'selected' : '' ?>>
                          <?= $proveedor['Nombre'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="elementoForm col-sm-12 col-md-6 col-lg">
                    <label class="form-label" for="fechaEntregaEstimada">Fecha de entrega estimada: </label>
                    <input class="form-control" type="date" name="fechaEntregaEstimada" id="fechaEntregaEstimada" 
                     value="<?= isset($fechaEntregaEstimada) ? date('Y-m-d', strtotime($fechaEntregaEstimada)) : date('Y-m-d', strtotime('+1 day')) ?>">

                  </div>
                  <?php if ($modo === 'actualizar') : ?>
                  <div class="elementoForm col-sm-12 col-md-6 col-lg">
                    <label class="form-label" for="fechaEntregaReal">Fecha de entrega real: </label>
                    <input class="form-control" type="datetime-local" name="fechaEntregaReal" id="fechaEntregaReal" step="1"
                     value="<?= (empty($fechaEntregaReal) OR $fechaEntregaReal === '0000-00-00 00:00:00') ? date('Y-m-d\TH:i:s') : $fechaEntregaReal ?>">
                  </div>
                    <div class=" elementoForm col-sm-12 col-md-6 col-lg-4">
                      <label for="estadoPedido">Estatus del pedido:</label>
                      <select class="form-select" name="estadoPedido" id="estadoPedido">
                        <?php foreach ($arrayEstadoPedido as $estado): ?>
                          <option value="<?= $estado['IDEstadoPedido'] ?>" <?= ($estado['IDEstadoPedido'] == 5) ? 'selected' : '' ?>>
                            <?= $estado['Descripcion'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="row">
                  <div class="col-12">
                    <?php if ($modo === 'insertar') : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnInsertarPedido">Enviar</button>
                    <?php else : ?>
                      <button type="submit" class="btn btn-primary boton-primario" name="btnActualizarPedido">Actualizar</button>
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
          <button class="accordion-button collapsed btnAcordeon" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdminPedidos" aria-expanded="false" aria-controls="collapseAdminPedidos">
            Administrar pedidos
          </button>
        </h2>
        <div id="collapseAdminPedidos" class="accordion-collapse collapse show">
          <div class="accordion-body container contenedor-acordeon">
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
              <?php
              require("../../controladores/consultarPedidos.php");
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