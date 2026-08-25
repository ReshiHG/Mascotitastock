<?php
try {
  $bdd = new PDO('mysql:host=localhost;dbname=macotitastock', 'root', '');

  date_default_timezone_set('America/Mexico_City');
  setlocale(LC_TIME, 'es_ES.UTF-8'); // Cambiar configuración regional a español
  $meses = [
    1 => 'enero',
    'febrero',
    'marzo',
    'abril',
    'mayo',
    'junio',
    'julio',
    'agosto',
    'septiembre',
    'octubre',
    'noviembre',
    'diciembre'
  ];

  function formatearFecha($fecha, $meses)
  {
    if (isset($fecha) AND $fecha <> "0000-00-00 00:00:00") {
      $date = new DateTime($fecha);
      $anio = $date->format('Y');
      $mes = $meses[(int)$date->format('n')]; // nombre del mes en español
      $dia = $date->format('j'); // sin ceros iniciales
      $hora = $date->format('H:i'); // hora y minutos en formato 24h
      return "$dia de $mes del $anio a las $hora";
    } else {
      return '----------------------------';
    }
  }


  $resultado = $bdd->query('
    SELECT
      P.IDPedido,
      P.IDProveedor,
      PROV.Nombre,
      PROV.ApellidoPaterno,
      PROV.ApellidoMaterno,
      P.Descripcion,
      P.FechaSolicitud,
      P.FechaModifica,
      P.FechaEntregaEstimada,
      P.FechaEntregaReal,
      EP.IDEstadoPedido,
      EP.Descripcion descripcionPedido
    FROM
      pedido P
      INNER JOIN estado_pedido EP ON EP.IDEstadoPedido = P.EstadoPedido
      INNER JOIN proveedor PROV ON PROV.IDProveedor = P.IDProveedor
    WHERE
      P.bitActivo = 1
    ORDER BY
      P.FechaEntregaEstimada DESC
  ');
  foreach ($resultado as $res) {
    $IDPedido = $res['IDPedido'];
    $IDProveedor = $res['IDProveedor'];
    $Nombre = $res['Nombre'];
    $ApellidoPaterno = $res['ApellidoPaterno'];
    $ApellidoMaterno = $res['ApellidoMaterno'];
    $Descripcion = $res['Descripcion'];
    $FechaSolicitud = formatearFecha($res['FechaSolicitud'], $meses);
    $FechaEntregaEstimada = formatearFecha($res['FechaEntregaEstimada'], $meses);
    $FechaEntregaReal = formatearFecha($res['FechaEntregaReal'], $meses);
    $IDEstadoPedido = $res['IDEstadoPedido'];
    $descripcionPedido = $res['descripcionPedido'];

    echo "
              <div class='col'>
                <div class='contenedor-tarjeta'>
                  <div class='cuerpo-tarjeta'>
                    <h5>Identificador del pedido:</h5>
                    <p>$IDPedido</p>
                    <h5>Estado:</h5>
                    <p>$descripcionPedido</p>
                    <h5>Proveedor:</h5>
                    <p>$Nombre $ApellidoPaterno $ApellidoMaterno</p>
                    <h5>Descripcion:</h5>
                    <p>$Descripcion</p>
                    <br>
                    <h5>Fecha de solicitud:</h5>
                    <p>$FechaSolicitud</p>
                    <h5>Fecha de entrega estimada:</h5>
                    <p>$FechaEntregaEstimada</p>
                    <h5>Fecha de entrega real:</h5>
                    <p>$FechaEntregaReal</p>
                    <br>
                    <p>
                      <a class='btn boton-primario' href='pagina_pedidos.php?id=$IDPedido&modo=actualizar'>Editar</a>
                    </p>
                    <p>
                      <a class='btn boton-peligro' onclick='return eliminar()' href='pagina_pedidos.php?id=$IDPedido&modo=eliminar'>Eliminar</a>
                    </p>
                  </div>
                </div>
              </div>
              ";
  }
} catch (PDOException $e) { //Mostrar error
  echo "Error: " . $e->getMessage();
}
