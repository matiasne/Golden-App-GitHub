<?php 


    include '../../dbh.php';
    include '../estadisticas.php';
	insertarEstadistica($conn,$_POST['usuario'],"pdf-retencion-ganancia");


  $idDetalle = $_POST['ID_DETALLE']; 

  //Acá falta la seguridad!!!!!!!! Poner despues de probar bien todo!

  $query= "SELECT     'Valor' AS Tipo, ENTIDADES.DS_RAZON_SOCIAL, ENTIDADES.CD_CUIT, 
                      ENTIDADES_UBICACIONES.DS_DIRECCION + ' ' + ENTIDADES_UBICACIONES.DS_NUMERO + ' ' + ENTIDADES_UBICACIONES.DS_PISO + ' ' + ENTIDADES_UBICACIONES.DS_DPTO
                       AS Direccion, ' (' + ENTIDADES_UBICACIONES.CD_CP + ') ' + LOCALIDADES.DS_LOCALIDAD + ' - ' + PROVINCIAS.DS_PROVINCIA + ' - ' + PAISES.DS_PAIS AS Localidad,
                       CC_RECIBOS.TP_RECIBO + '-' + CC_RECIBOS.NO_EMISOR + '-' + CC_RECIBOS.NO_RECIBO AS RECIBO, CC_RECIBOS.DT_EMISION, 
                      VALOR_TIPOS.DS_VALOR_TIPO, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.DT_EMISION WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision
                       END AS Emision, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.DT_VENCE WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision
                       END AS Vence, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.ID_VALOR_EXTERNO WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN retenciones.Id_cbte_externo
                       END AS Comprobante, CONCEPTOS.DS_CONCEPTO, NULL AS TotaL, CC_RECIBOS_VALORES.VL_IMPORTE, IMPUESTOS_TASAS.DS_IMPUESTO_TASA, 
                      RETENCIONES_DETALLE.VL_BASE_ANTERIOR, RETENCIONES_DETALLE.VL_BASE, RETENCIONES_DETALLE.VL_BASE_MINIMO, 
                      RETENCIONES_DETALLE.VL_BASE_IMPONIBLE, RETENCIONES_DETALLE.VL_ARETENER, RETENCIONES_DETALLE.PC_TASA, 
                      RETENCIONES_DETALLE.VL_RETENCION_ANTERIOR, RETENCIONES_DETALLE.VL_RETENCION, RETENCIONES.ID_PERIODO
FROM         CC_RECIBOS INNER JOIN
                      CBTES ON CC_RECIBOS.ID_CBTE = CBTES.ID_CBTE INNER JOIN
                      CC_RECIBOS_VALORES ON CC_RECIBOS.ID_CC_RECIBO = CC_RECIBOS_VALORES.ID_CC_RECIBO INNER JOIN
                      CONCEPTOS ON CC_RECIBOS_VALORES.ID_CONCEPTO = CONCEPTOS.ID_CONCEPTO LEFT OUTER JOIN
                      RETENCIONES ON CC_RECIBOS_VALORES.ID_VALOR = RETENCIONES.ID_RETENCION LEFT OUTER JOIN
                      CAJA_VALORES ON CC_RECIBOS_VALORES.ID_VALOR = CAJA_VALORES.ID_VALOR INNER JOIN
                      ENTIDADES ON CC_RECIBOS.ID_ENTIDAD = ENTIDADES.ID_ENTIDAD INNER JOIN
                      ENTIDADES_UBICACIONES ON ENTIDADES.ID_ENTIDAD = ENTIDADES_UBICACIONES.ID_ENTIDAD AND 
                      ENTIDADES_UBICACIONES.ID_UBICACION_TIPO = 1 LEFT OUTER JOIN
                      LOCALIDADES ON ENTIDADES_UBICACIONES.ID_LOCALIDAD = LOCALIDADES.ID_LOCALIDAD LEFT OUTER JOIN
                      PROVINCIAS ON LOCALIDADES.ID_PROVINCIA = PROVINCIAS.ID_PROVINCIA LEFT OUTER JOIN
                      PAISES ON PROVINCIAS.ID_PAIS = PAISES.ID_PAIS INNER JOIN
                      VALOR_TIPOS ON CC_RECIBOS_VALORES.CD_VALOR_TIPO = VALOR_TIPOS.CD_VALOR_TIPO LEFT OUTER JOIN
                      RETENCIONES_DETALLE ON RETENCIONES.ID_RETENCION = RETENCIONES_DETALLE.ID_RETENCION INNER JOIN
                      IMPUESTOS_TASAS ON RETENCIONES_DETALLE.ID_IMPUESTO_TASA = IMPUESTOS_TASAS.ID_IMPUESTO_TASA
WHERE     (CC_RECIBOS.NO_RECIBO = '$idDetalle') AND (CONCEPTOS.ID_IMPUESTO_REGIMEN = 2)";

$result = sqlsrv_query($conn_pagos, $query);

$rows = array();
while($r = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {    
    $rows[] = $r;
}

echo json_encode($rows);

exit();