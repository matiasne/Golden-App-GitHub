<?php 

  
  include '../../dbh.php';
  include '../estadisticas.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

 

  insertarEstadistica($conn,$_POST['usuario'],"detalles-pagos");

  $idDetalle = $_POST['ID_DETALLE'];  


  $query= "SELECT     'Valor' AS Tipo, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.DT_EMISION WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision
                       END AS Emision, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.DT_VENCE WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision
                       END AS Vence, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.ID_VALOR_EXTERNO WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN retenciones.Id_cbte_externo
                       END AS Comprobante, CONCEPTOS.DS_CONCEPTO, NULL AS Tota, CC_RECIBOS_VALORES.VL_IMPORTE,
           CONCEPTOS.ID_IMPUESTO_REGIMEN
FROM         CC_RECIBOS INNER JOIN
                      CBTES ON CC_RECIBOS.ID_CBTE = CBTES.ID_CBTE INNER JOIN
                      CC_RECIBOS_VALORES ON CC_RECIBOS.ID_CC_RECIBO = CC_RECIBOS_VALORES.ID_CC_RECIBO INNER JOIN
                      CONCEPTOS ON CC_RECIBOS_VALORES.ID_CONCEPTO = CONCEPTOS.ID_CONCEPTO LEFT OUTER JOIN
                      RETENCIONES ON CC_RECIBOS_VALORES.ID_VALOR = RETENCIONES.ID_RETENCION LEFT OUTER JOIN
                      CAJA_VALORES ON CC_RECIBOS_VALORES.ID_VALOR = CAJA_VALORES.ID_VALOR
WHERE     (CC_RECIBOS.ID_CC_RECIBO = '$idDetalle')
UNION ALL
SELECT     'Aplicacion' AS Tipo, CC_CBTES.DT_EMISION AS Expr1, CC_CBTES.DT_VENCE, CC_CBTES.ID_CBTE_EXTERNO, CBTES_1.DS_CBTE, CC_CBTES.VL_TOTAL AS Expr2, 
                      CC_RECIBOS_CBTES.VL_APLICA,0 as ID_IMPUESTO_REGIMEN
FROM         CC_RECIBOS AS CC_RECIBOS_1 INNER JOIN 
                      CBTES AS CBTES_2 ON CC_RECIBOS_1.ID_CBTE = CBTES_2.ID_CBTE INNER JOIN
                      CC_RECIBOS_CBTES ON CC_RECIBOS_1.ID_CC_RECIBO = CC_RECIBOS_CBTES.ID_CC_RECIBO INNER JOIN
                      CBTES AS CBTES_1 ON CC_RECIBOS_CBTES.ID_CBTE = CBTES_1.ID_CBTE INNER JOIN
                      CC_CBTES ON CC_RECIBOS_CBTES.ID_CC_APLICA = CC_CBTES.ID_CC_CBTE
WHERE     (CC_RECIBOS_1.ID_CC_RECIBO = '$idDetalle')
ORDER BY Tipo";

$result = sqlsrv_query($conn_pagos, $query);



while($myRow = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)){ 

    $total = number_format($myRow['Tota'], 2, ',', '.');
    $importe = number_format($myRow['VL_IMPORTE'], 2, ',', '.');

	


      echo  " <tr>
                <td class='text-right'>".$myRow['Tipo']."</td>
                <td class='text-right'>".$myRow['Comprobante']."</td>
                <td class='text-right'>".$myRow['DS_CONCEPTO']."</td>
                <td class='text-right'>".$total."</td>
                <td class='text-right'>".$importe."</td>       
                <td class='text-right'>

                  <button id=".$idDetalle." type='button' class='btn btn-primary detalleRecibo' onclick='onclickGenerarPDF(\"".$myRow['ID_IMPUESTO_REGIMEN']."\")''>
                      PDF
                  </button>
                </td>                      
              </tr>
          ";
}

?>