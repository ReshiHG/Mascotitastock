<?php
try {
  require("conexion.php");

  $resultado = $bdd->query('
                            SELECT
                              IDCategoria,
                              Nombre
                            FROM
                              categoria
                            WHERE
                              bitActivo=1
                            ORDER BY Nombre
                          ');


  foreach ($resultado as $res) {
    $IDCategoria = $res['IDCategoria'];
    $nombreCategoria = $res['Nombre'];

    echo "
              <div class='col'>
                <div class='contenedor-tarjeta'>
                  <div class='cuerpo-tarjeta'>
                    <div class='container'>
                      <div class='row'>
                        <div class='col-12'>
                          <h5 class='titulo-tarjeta'>$nombreCategoria</h5>
                        </div>
                        <div class='col-6'>
                          <a class='btn boton-primario' href='pagina_categorias.php?id=$IDCategoria&modo=actualizar'>Editar</a>
                        </div>
                        <div class='col-6'>
                          <a class='btn boton-peligro' onclick='return eliminar()' href='pagina_categorias.php?id=$IDCategoria&modo=eliminar'>Eliminar</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
    ";

  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
