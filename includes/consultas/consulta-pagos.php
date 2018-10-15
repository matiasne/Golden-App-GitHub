<?php 



  include '../../dbh.php';
  include '../estadisticas.php';

  
  insertarEstadistica($conn,$_POST['usuario'],"consulta-pagos");

  $fechaDesde = $_POST['fechaDesde'];
  $fechaHasta = $_POST['fechaHasta'];
  $EntidadSQL = $_POST['ID_ENTIDADSQL'];

  $dateDesde = new DateTime($fechaDesde);
  $dateHasta = new DateTime($fechaHasta);

	


	$query= "SELECT     CC_RECIBOS.DT_EMISION, CBTES.DS_CBTE AS Comprobante, 
                      CC_RECIBOS.TP_RECIBO + ' ' + CC_RECIBOS.NO_EMISOR + '-' + CC_RECIBOS.NO_RECIBO AS Numero, CC_RECIBOS.VL_TOTAL, CC_RECIBOS.ID_CC_RECIBO, CC_RECIBOS.NO_RECIBO
  FROM         CC_RECIBOS INNER JOIN
                        CBTES ON CC_RECIBOS.ID_CBTE = CBTES.ID_CBTE
  WHERE     (CC_RECIBOS.ID_ENTIDAD = '$EntidadSQL') ORDER BY  CC_RECIBOS.DT_EMISION
";

$result = sqlsrv_query($conn_pagos, $query);


while($myRow = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)){ 


  $total = number_format($myRow['VL_TOTAL'], 2, ',', '.');

   

  if ($dateDesde < $myRow['DT_EMISION'] ){
    if($dateHasta > $myRow['DT_EMISION']){
    	echo  "	<tr>
          			    <td >".$myRow['DT_EMISION']->format("d-m-Y")."</td>					              	
          	      	<td class='text-right' >".$myRow['Comprobante']."</td>
          	      	<td class='text-right' >".$myRow['Numero']."</td>
          	      	<td class='text-right'>".$total."</td>
                    <td>	 
                    <button type='button' class='btn btn-primary detalleRecibo' onclick='solicitarDetalle(\"".$myRow['ID_CC_RECIBO']."\",\"".$myRow['NO_RECIBO']."\")''>
                      ...
                    </button>      	
                    </td>
                    <td>   
                    <button type='button' class='btn btn-primary detalleRecibo' onclick='mostrarMenuPDF(\"".$myRow['NO_RECIBO']."\")''>
                      PDF
                    </button>       
                    </td>
          	  </tr>
          	  ";
    }
  }
}

?>