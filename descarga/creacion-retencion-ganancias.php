<?php

include '../../goldenApp/dbh.php';

require('html_table.php');

ini_set('display_errors',1);
error_reporting(E_ALL);

define('FPDF_FONTPATH', 'fpdf181/font/');

function formatearValor(&$valor){
	$valor = number_format($valor, 2, '.', ',');
}


  $idDetalle = $_POST['ID_DETALLE']; 



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

$r = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);


$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$pdf->Rect(10,60,190,20);
$pdf->Rect(10,95,190,25);
$pdf->Rect(10,130,190,95);

$pdf->Line(98,157,118,157);

$pdf->Line(98,212,118,212);

$pdf->Line(18,192,192,192);

$pdf->Line(18,201,192,201);

$html='<table>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="200" height="30">Comprobante de Retención</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="200" height="30">Impuesto a las Ganancias</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td>
	</tr>
	<tr>
		
	</tr>
</table>';


$pdf->WriteHTML($html);

$fechaEmision = $r["DT_EMISION"]->format('d/m/Y');



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
		<td width="100" height="30">Domicilio</td><td width="160" height="30">'.$r["Direccion"].'</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">Ganancias:</td><td>Inscripto</td>
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

$dateEmision = $r["DT_EMISION"]->format('d/m/Y');

$newDate = date("m/Y", strtotime($r["ID_PERIODO"]));



$vlBase = sprintf('%0.2f', $r['VL_BASE']);
$vlBaseAnterior = sprintf('%0.2f', $r['VL_BASE_ANTERIOR']);

$sumaBases = $vlBase + $vlBaseAnterior;
$sumaBases = number_format($sumaBases, 2, '.', '');


formatearValor($r["VL_BASE"]);
formatearValor($r["VL_BASE_ANTERIOR"]);
formatearValor($r["VL_BASE_MINIMO"]);
formatearValor($r["VL_BASE_IMPONIBLE"]);
formatearValor($r["VL_RETENCION"]);
formatearValor($r["VL_RETENCION_ANTERIOR"]);
formatearValor($r["PC_TASA"]);
formatearValor($r["VL_ARETENER"]);

formatearValor($sumaBases);

	

$html = '<table>
	<tr>
		DATOS DE LA RETENCION APLICADA
	</tr>
	<tr>
		<td width="200" height="30" >Concepto de retención: </td><td>'.$r["DS_IMPUESTO_TASA"].'</td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		<td width="200" height="30" >Base Imponible </td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td><td width="200" height="30">Pagos anteriores del mes:</td><td width="100" height="30" align="RIGHT">'.$newDate.'</td><td width="100" height="30" align="RIGHT">'.$r["VL_BASE_ANTERIOR"].'</td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td><td width="200" height="30">Importe a pagar:</td><td width="100" height="30" align="RIGHT">'.$dateEmision.'</td><td width="100" height="30" align="RIGHT">'.$r["VL_BASE"].'</td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td><td width="200" height="30">Subtotal:</td><td width="100" height="30">&nbsp;</td><td  width="100" height="30" align="RIGHT">'.$sumaBases.'</td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td><td width="200" height="30">Importe no sujeto a retención:</td><td width="100" height="30">&nbsp;</td><td width="100" height="30" align="RIGHT">'.$r["VL_BASE_MINIMO"].'</td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td>
		<td width="200" height="30">Base Imponible Total:</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="100" height="30" align="RIGHT">'.$r["VL_BASE_IMPONIBLE"].'</td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		<td width="200" height="30" >Retención aplicada </td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td>
		<td width="200" height="30">&nbsp;</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="100" height="30" align="RIGHT">Retención</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="70" height="30">&nbsp;</td>
		<td width="70" height="30">&nbsp;</td>
		<td width="100" height="30">Base</td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td>
		<td width="200" height="30">Retención sobre base:</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="100" height="30" align="RIGHT">'.$r["VL_RETENCION"].'</td>
		<td width="100" height="30">tasa aplicada:</td>
		<td width="70" height="30">'.$r["PC_TASA"].'</td>
		<td width="70" height="30">sobre:</td>
		<td width="100" height="30">'.$r["VL_BASE_IMPONIBLE"].'</td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td>
		<td width="200" height="30">Monto de la Retención:</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="100" height="30" align="RIGHT">'.$r["VL_RETENCION"].'</td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td>
		<td width="200" height="30">Total retenido del mes:</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="100" height="30" align="RIGHT">'.$r["VL_RETENCION_ANTERIOR"].'</td>
	</tr>
	<tr>
		<td width="30" height="30">&nbsp;</td>
		<td width="200" height="30">Monto a Retener:</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="100" height="30" align="RIGHT">'.$r["VL_ARETENER"].'</td>
	</tr>
</table>';
$pdf->WriteHTML($html);

$pdf->Image('firma_fabian.png',140,230,25,25);
$pdf->SetXY(140,255);
$pdf->Write(5,'Sebastias Testa');
$pdf->SetXY(145,260);
$pdf->Write(5,'Apoderado');

$nombreArchivo = $idDetalle."-RG.pdf";

$pdf->Output('F', $nombreArchivo);

echo "http://www.goldenpeanut.com.ar/descarga/creacion-pdf/".$nombreArchivo;

?>