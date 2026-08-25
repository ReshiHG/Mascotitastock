<?php
try {

  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');

  $resultado = $bdd->query('
                            SELECT
                              M.IDMedicamento,
                              M.Nombre as nomMedicamento,
                              M.Descripcion,
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
    $nombreMedicamento = $res['nomMedicamento'];
    $descripcion = $res['Descripcion'];
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

    echo "
              <div class='col col-tarjeta'>
                <div class='contenedor-tarjeta'>
                  <div class='cuerpo-tarjeta'>
                    <div class='container'>
                      <div class='contenedor-imagen-tarjeta'>
                        <img class='imagen imagen-tarjeta' src='../../public/imagenes/$imagen' alt='$nombreMedicamento'>
                      </div>
                      <h5 class='titulo-tarjeta'>$nombreMedicamento</h5>
                      <p>
                      ";
    if ((int)$stockApartado > 0) {
      echo "
                        <div class='row' style='background-color: #DE2B34; color: white; padding: 0.3rem; border: 1px solid black'>
                            <div class='col'><strong>Apartados:</strong></div>
                            <div class='col'>$stockApartado</div>
                        </div>      
      ";
    } else {
      echo "
                        <div class='row' style='background-color: #2E8B57; color: white; padding: 0.3rem; border: 1px solid black'>
                          <div class='col text-center'><strong>Ninguno apartado</strong></div>
                        </div>
      ";
    }
    echo "
                      </p>
                      <p>
                      <div class='row'>
                        <div class='col '><strong>Stock disponible:</strong></div>
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
                      <p>
                      <div class='row'>
                        <div class='col-12'><strong>Descripción:</strong></div>
                        <div class='col-12'>$descripcion</div>
                      </div>
                      </p>
                    </div>
                    <p>
                      <a class='btn boton-primario' href='pagina_medicamentos.php?idMed=$idMedicamento&modo=actualizar'>Editar</a>
                    </p>
                    <p>
                      <a class='btn boton-peligro' onclick='return eliminar()' href='pagina_medicamentos.php?idMed=$idMedicamento&modo=eliminar'>Eliminar</a>
                    </p>
                  </div>
                </div>
              </div>
    ";
  }


} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
