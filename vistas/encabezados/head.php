<?php
// Verifica que haya una sesión iniciada, de lo contrario redirige al login
require_once __DIR__ . '/../../controladores/verificar_sesion.php';

// Rerorna el encabezado html con el título de la página
function generarHead($titulo)
{
   return "
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>$titulo</title>
    
    <script src='../../js/bootstrap/bootstrap.bundle.min.js'></script>
    <link rel='stylesheet' type='text/css' href='../../css/bootstrap/bootstrap.min.css' />
    <link rel='stylesheet' type='text/css' href='../../css/estilos.css' />
    
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Cantora+One&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap' rel='stylesheet'>
    ";
}
