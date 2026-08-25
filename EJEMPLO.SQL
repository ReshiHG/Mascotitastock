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
  EP.Descripcion
FROM
  pedido P
  INNER JOIN estado_pedido EP ON EP.IDEstadoPedido = P.EstadoPedido
  INNER JOIN proveedor PROV ON PROV.IDProveedor = P.IDProveedor
WHERE
  P.bitActivo = 1