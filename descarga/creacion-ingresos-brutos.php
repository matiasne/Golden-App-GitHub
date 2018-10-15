<?php

include '../../goldenApp/dbh.php';

require('html_table.php');

ini_set('display_errors',1);
error_reporting(E_ALL);

function formatearValor(&$valor){
	$valor = number_format($valor, 2, '.', ',');
}

define('FPDF_FONTPATH', 'fpdf181/font/');


  $idDetalle = $_POST['ID_DETALLE']; 



	$query= "SELECT     'Valor' AS Tipo, ENTIDADES.DS_RAZON_SOCIAL, ENTIDADES.CD_CUIT, ENTIDADES.NO_IB_INSCRIPCION, 
                      ENTIDADES_UBICACIONES.DS_DIRECCION + ' ' + ENTIDADES_UBICACIONES.DS_NUMERO + ' ' + ENTIDADES_UBICACIONES.DS_PISO + ' ' + ENTIDADES_UBICACIONES.DS_DPTO
                       AS Direccion, ' (' + ENTIDADES_UBICACIONES.CD_CP + ') ' + LOCALIDADES.DS_LOCALIDAD + ' - ' + PROVINCIAS.DS_PROVINCIA + ' - ' + PAISES.DS_PAIS AS Localidad,
                       CC_RECIBOS.TP_RECIBO + '-' + CC_RECIBOS.NO_EMISOR + '-' + CC_RECIBOS.NO_RECIBO AS RECIBO, CC_RECIBOS.DT_EMISION, 
                      VALOR_TIPOS.DS_VALOR_TIPO, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.DT_EMISION WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision
                       END AS Emision, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.DT_VENCE WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision
                       END AS Vence, 
                      CASE WHEN cc_recibos_valores.CD_valor_tipo = 'CH' THEN CAJA_VALORES.ID_VALOR_EXTERNO WHEN cc_recibos_valores.CD_valor_tipo = 'RN' THEN retenciones.Id_cbte_externo
                       END AS Comprobante, CONCEPTOS.DS_CONCEPTO, CC_RECIBOS_VALORES.VL_IMPORTE, IMPUESTOS_TASAS.DS_IMPUESTO_TASA, 
                      RETENCIONES_DETALLE.VL_BASE_IMPONIBLE, RETENCIONES_DETALLE.VL_ARETENER, RETENCIONES_DETALLE.PC_TASA, RETENCIONES.ID_PERIODO, 
                      CC_RECIBOS.ID_CC_RECIBO, PP.DS_PROVINCIA
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
                      IMPUESTOS_TASAS ON RETENCIONES_DETALLE.ID_IMPUESTO_TASA = IMPUESTOS_TASAS.ID_IMPUESTO_TASA LEFT OUTER JOIN
                      PROVINCIAS AS PP ON RETENCIONES.ID_PROVINCIA = PP.ID_PROVINCIA
WHERE     (CC_RECIBOS.NO_RECIBO = '$idDetalle') AND (CONCEPTOS.ID_IMPUESTO_REGIMEN = 31)";

$result = sqlsrv_query($conn_pagos, $query);

$r = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);


$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$pdf->Rect(10,60,190,20);
$pdf->Rect(10,95,190,25);
$pdf->Rect(10,130,190,45);

$html='<table>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="200" height="30">Comprobante de Retención</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="200" height="30">Impuesto sobre los Ingresos Brutos</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td>
	</tr>
	<tr>
		
	</tr>
</table>';


$pdf->WriteHTML($html);

$fechaEmision = $r["Emision"]->format('d/m/Y');



$html = '<table>	
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="100" height="30">Número</td><td width="100" height="30">'.$r["Comprobante"].'</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="100" height="30">Emisión:</td><td width="100" height="30">'.$fechaEmision.'</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="100" height="30">O. Pago</td><td width="100" height="30">'.$r["RECIBO"].'</td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		
	</tr>
	</table>';

$pdf->WriteHTML($html);

$pdf->SetFont('Arial','',9);

$html = '<table>
	<tr>
		AGENTE DE RETENCION
	</tr>
	<tr>
		<td width="100" height="30">Razón Social:</td><td width="160" height="30">GOLDEN PEANUT AND TREE NUTS S.A</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">C.U.I.T.</td><td>30-64225906-3</td>
	</tr>
	<tr>
		<td width="100" height="30">Domicilio</td><td width="160" height="30">Reconquista 609 - Piso 8</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">Provincia:</td><td>Córdoba</td>
	</tr>
	<tr>
		<td width="100" height="30">&nbsp;</td><td width="160" height="30">(1003) Capital Federal - Capital Federal - Argentina</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">Agente Ret.:</td><td>317-007141</td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		
	</tr>
</table>';
$pdf->WriteHTML($html);

$html = '<table>
	<tr>
		DATOS DEL CONTRIBUYENTE SUJETO DE RETENCION
	</tr>
	<tr>
		<td width="100" height="30">Razón Social:</td><td width="160" height="30">'.$r["DS_RAZON_SOCIAL"].'</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">C.U.I.T.</td><td>'.$r["CD_CUIT"].'</td>
	</tr>
	<tr>
		<td width="100" height="30">Domicilio</td><td width="160" height="30">'.$r["Direccion"].'</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">IBB:</td><td>'.$r["NO_IB_INSCRIPCION"].'</td>
	</tr>
	<tr>
		<td>'.$r["Localidad"].'</td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		
	</tr>
</table>';
$pdf->WriteHTML($html);


formatearValor($r["VL_BASE_IMPONIBLE"]);

formatearValor($r["PC_TASA"]);

formatearValor($r["VL_ARETENER"]);

$html = '<table>
	<tr>
		DATOS DE LA RETENCION APLICADA
	</tr>
	<tr>
		<td width="200" height="30" >Concepto de retención: </td><td>'.$r["DS_IMPUESTO_TASA"].'</td>
	</tr>
	<tr>
		<td width="200" height="30" >Provincia</td><td>'.$r["DS_PROVINCIA"].'</td>
	</tr>
	<tr>
		<td width="200" height="30">Monto total sujeto a retención:</td><td align="RIGHT">'.$r["VL_BASE_IMPONIBLE"].'</td>
	</tr>
	<tr>
		<td width="200" height="30">Alicuota:</td><td align="RIGHT">'.$r["PC_TASA"].'%</td>
	</tr>
	<tr>
		<td width="200" height="30" >Monto de la Retención:</td><td align="RIGHT">'.$r["VL_ARETENER"].'</td>
	</tr>
</table>';
$pdf->WriteHTML($html);

$pdf->Image('firma_fabian.png',140,230,25,25);
$pdf->SetXY(140,255);
$pdf->Write(5,'Sebastias Testa');
$pdf->SetXY(145,260);
$pdf->Write(5,'Apoderado');

$nombreArchivo = $idDetalle."-RIB.pdf";

$pdf->Output('F', $nombreArchivo);

echo "http://www.goldenpeanut.com.ar/descarga/creacion-pdf/".$nombreArchivo;

?>