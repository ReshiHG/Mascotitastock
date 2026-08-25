<?php
try { //Código
  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');
  // echo "Conexión realizada" . '<br><br>';
  $resultado = $bdd->query('
                            SELECT
                              IDProveedor,
                              Nombre,
                              ApellidoPaterno,
                              ApellidoMaterno,
                              Email,
                              Telefono
                            FROM
                              proveedor
                            WHERE
                              bitActivo = 1
  ');
  foreach ($resultado as $res) {
    $IDProveedor = $res['IDProveedor'];
    $Nombre = $res['Nombre'];
    $ApellidoPaterno = $res['ApellidoPaterno'];
    $ApellidoMaterno = $res['ApellidoMaterno'];
    $Email = $res['Email'];
    $Telefono = $res['Telefono'];
    echo"     <div class='col'>
                <div class='contenedor-tarjeta'>
                  <div class='cuerpo-tarjeta'>
                    <h5>Nombre:</h5>
                    <p>$Nombre $ApellidoPaterno $ApellidoMaterno</p>
                    <h5>Correo:</h5>
                    <p>$Email</p>
                    <h5>Telefono:</h5>
                    <p>$Telefono</p>
                    <br>
                    <p>
                      <a class='btn boton-primario' href='pagina_proveedores.php?id=$IDProveedor&modo=actualizar'>Editar</a>
                    </p>
                    <p>
                      <a class='btn boton-peligro' onclick='return eliminar()' href='pagina_proveedores.php?id=$IDProveedor&modo=eliminar'>Eliminar</a>
                    </p>
                  </div>
                </div>
              </div>
              ";
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
