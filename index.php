<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>Mascotas y Mascotitas</title>
    <script src='js/bootstrap/bootstrap.bundle.min.js'></script>
    <link rel='stylesheet' type='text/css' href='css/bootstrap/bootstrap.min.css' />
    <link rel='stylesheet' type='text/css' href='css/estilos.css' />
</head>

<header>
  <?php
    require ("vistas/encabezados/encabezado_index.php");
  ?>
</header>

<body>
  <div
    class="d-flex justify-content-center">
    <div class="card" style="width: 30rem; margin-top: 10vh;">
      <img class="card-img-top" src="public/imagenes/Logo MyM Oscuro.png" alt="Card image cap" />
      <div class="card-body">
        <h1 class="card-title">Inicio de sesión</h1>
        <p class="card-text">
        <form name="formLogin" method="post">
          <div class="form-group">
            <label for="email">Correo electronico</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="correo@ejemplo.com" required>
          </div>
          <div class="form-group">
            <label for="contrasenia">Contraseña</label>
            <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="Contraseña" required>
          </div>
          <br>


          <?php
          include("controladores/loginUsuario.php");
          ?>


          <br>
          <button type="submit" class="btn boton-primario" name="btmEntrar">Entrar</button>
        </form>
        </p>
      </div>
    </div>
  </div>
</body>

</html>