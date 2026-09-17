<?php
try {
  $conexion = require_once __DIR__ . '/../conexion.php';
  // echo "Conexión realizada" . '<br><br>';
  $resultado = $conexion->query('
                            SELECT
                              M.IDMedicamento,
                              M.Nombre as nomMedicamento,
                              M.StockApartado,
                              M.StockTotal,
                              M.StockDisponible,
                              M.imagen,
                              UM.IDUnidadMedida,
                              UM.Nombre as nomUnidadMedida,
                              M.CantidadActualPorEnvase,
                              M.CantidadMaximaPorEnvase,
                              MCAT.IDMedicamentoCategoria,
                              CAT.IDCategoria,
                              CAT.Nombre AS nomCategoria
                            FROM
                              medicamento as M
                              INNER JOIN unidad_medida AS UM ON M.IDUnidadMedida = UM.IDUnidadMedida
                              INNER JOIN medicamento_categoria MCAT ON MCAT.IDMedicamento = M.IDMedicamento
                              INNER JOIN categoria CAT ON CAT.IDCategoria = MCAT.IDCategoria
                            WHERE
                              M.BitActivo=1
                          ');

  foreach ($resultado as $res) {
    $idMedicamento = $res['IDMedicamento'];
    $nomMedicamento = $res['nomMedicamento'];
    $stockApartado = $res['StockApartado'];
    $stockTotal = $res['StockTotal'];
    $stockDisponible = $res['StockDisponible'];
    $imagen = $res['imagen'];
    $idUnidadMedida = $res['IDUnidadMedida'];
    $nomUnidadMedida = $res['nomUnidadMedida'];
    $cantidadActualPorEnvase = $res['CantidadActualPorEnvase'];
    $cantidadMaximaPorEnvase = $res['CantidadMaximaPorEnvase'];
    $idMedicamentoCategoria = $res['IDMedicamentoCategoria'];
    $idCategoria = $res['IDCategoria'];
    $nomCategoria = $res['nomCategoria'];
    
    if ((int)$idGET === (int)$idMedicamento) {
      echo "
      <div class='col'>
        <div class='contenedor-tarjeta'>
          <div class='cuerpo-tarjeta'>
            <div class='contenedor-imagen-tarjeta'>
              <img class='imagen imagen-tarjeta' src='../../public/imagenes/$imagen' alt=''>
            </div>
            <form action='' name='formActualizaInventario' method='post'>
              <input type='hidden' name='idMedicamento' id='idMedicamento' value='$idMedicamento'>
              <div class='row'>
                <div class='elementoForm'>
                  <label for='nomMedicamento'>Nombre del medicamento:</label>
                  <input type='text' class='form-control' placeholder='Medicamento' name='nomMedicamento' id='medicamento' value='$nomMedicamento' require>
                </div>
              </div>
              <div class='row'>
                <div class='elementoForm'>
                  <label for='stockApartado'>Apartado:</label>
                  <input type='number' class='form-control' name='stockApartado' id='stockApartado' value='$stockApartado' require>
                </div>
              </div>
              <div class='row'>
                <div class='elementoForm'>
                  <label for='stockDisponible'>Stock disponible:</label>
                  <input type='number' class='form-control' name='stockDisponible' id='stockDisponible' value='$stockDisponible' require>
                </div>
              </div>
              <div class='row'>
                <div class='elementoForm'>
                  <label for='cantidadActualPorEnvase'>Cantidad restante:</label>
                  <input type='number' class='form-control' name='cantidadActualPorEnvase' id='cantidadActualPorEnvase' value='$cantidadActualPorEnvase' require>
                </div>
              </div>
              <p>
                <button type='submit' class='btn btn-primary boton-primario' name='btnActualizarInventario' >Actualizar</button>
              </p>
            </form>
          </div>
        </div>
      </div>
      ";
    } else {
      echo "
        <div class='col'>
          <div class='contenedor-tarjeta'>
            <div class='cuerpo-tarjeta'>
              <div class='container'>
                <div class='contenedor-imagen-tarjeta'>
                  <img class='imagen imagen-tarjeta' src='../../public/imagenes/$imagen' alt='$nomMedicamento'>
                </div>
                <h5 class='titulo-tarjeta'>$nomMedicamento</h5>
                <p>
                <div class='row'>
                  <div class='col '><strong>Apartados:</strong></div>
                  <div class='col'>$stockApartado</div>
                </div>
                </p>
                <p>
                <div class='row'>
                  <div class='col '><strong>Stock:</strong></div>
                  <div class='col'>$stockDisponible</div>
                </div>
                </p>
                <p>
                <div class='row'>
                  <div class='col '><strong>$nomUnidadMedida:</strong></div>
                  <div class='col'>$cantidadActualPorEnvase de $cantidadMaximaPorEnvase</div>
                </div>
                </p>
                <p>
                <div class='row'>
                  <div class='col-12'><strong>Categorias:</strong></div>
                  <div class='col-12'>
                    <ul>
                      <li>$nomCategoria</li>
                    </ul>
                  </div>
                </div>
                </p>
              </div>
              <p>
                <a class='btn boton-primario' href='pagina_inventario.php?idMed=$idMedicamento&modo=actualizar'>Editar</a>
              </p>
            </div>
          </div>
        </div>
                ";
    }
  }

} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
