<?php
require_once __DIR__ . '/../conexion.php';
try {
  $conexion = getConexion();
  // echo "Conexión realizada" . '<br><br>';
  $resultado = $conexion->query('SELECT U.IDUsuario,ROL.nomRol,U.Nombre,U.ApellidoPaterno,U.ApellidoMaterno,U.Email,U.Contrasenia,U.Telefono,U.BitActivo FROM usuario AS U INNER JOIN rolusuario AS ROL ON ROL.IDRol = U.IDRol WHERE U.BitActivo=1');
  foreach ($resultado as $res) {
    $IDUsuario = $res['IDUsuario'];
    $nomRol = $res['nomRol'];
    $Nombre = $res['Nombre'];
    $ApellidoPaterno = $res['ApellidoPaterno'];
    $ApellidoMaterno = $res['ApellidoMaterno'];
    $Email = $res['Email'];
    $Contrasenia = $res['Contrasenia'];
    $Telefono = $res['Telefono'];
    $BitActivo = $res['BitActivo'];
    echo"     <div class='col'>
                <div class='contenedor-tarjeta'>
                  <div class='cuerpo-tarjeta'>
                    <h5>Nombre:</h5>
                    <p>$Nombre $ApellidoPaterno $ApellidoMaterno</p>
                    <h5>Correo:</h5>
                    <p>$Email</p>
                    <h5>Telefono:</h5>
                    <p>$Telefono</p>
                    <h5>Rol:</h5>
                    <p>$nomRol</p>
                    <br>
                    <p>
                      <a class='btn boton-primario' href='pagina_usuarios.php?id=$IDUsuario&modo=actualizar'><img src='public/imagenes/edit.png' alt='Editar' style='height: 25px;'></a>
                    </p>
                    <p>
                      <a class='btn boton-peligro' onclick='return eliminar()' href='pagina_usuarios.php?id=$IDUsuario&modo=eliminar'><img src='public/imagenes/delete.png' alt='Eliminar' style='height: 25px;'></a>
                    </p>
                  </div>
                </div>
              </div>
              ";
  }
                      // <a class='btn boton-primario' href='modificar_usuario.php?id=$IDUsuario'><img src='public/imagenes/edit.png' alt='Editar' style='height: 25px;'></a>
  
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
