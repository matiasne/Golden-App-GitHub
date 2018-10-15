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

$sumatoriaValores = 0;
$sumatoriaAplicaciones = 0;
$contadorAplicaciones = 0;
$contadorValores = 0;

$query= "SELECT     CC_RECIBOS.ID_CC_RECIBO, 'Valor' AS Tipo, CC_RECIBOS_VALORES.NO_LINEA, CBTES.DS_CBTE, ENTIDADES.DS_RAZON_SOCIAL, ENTIDADES.CD_CUIT, 
                      ENTIDADES_UBICACIONES.DS_DIRECCION + ' ' + ENTIDADES_UBICACIONES.DS_NUMERO + ' ' + ENTIDADES_UBICACIONES.DS_PISO + ' ' + ENTIDADES_UBICACIONES.DS_DPTO
                       AS Direccion, ' (' + ENTIDADES_UBICACIONES.CD_CP + ') ' + LOCALIDADES.DS_LOCALIDAD + ' - ' + PROVINCIAS.DS_PROVINCIA + ' - ' + PAISES.DS_PAIS AS Localidad,
                       CC_RECIBOS.TP_RECIBO + '-' + CC_RECIBOS.NO_EMISOR + '-' + CC_RECIBOS.NO_RECIBO AS RECIBO, CC_RECIBOS.DT_EMISION, 
                      VALOR_TIPOS.DS_VALOR_TIPO, CAJA_VALORES.DT_EMISION AS Emision, CAJA_VALORES.DT_VENCE AS Vence, 
                      CAJA_VALORES.ID_VALOR_EXTERNO AS Comprobante, CONCEPTOS.DS_CONCEPTO, NULL AS TotaL, CC_RECIBOS_VALORES.VL_IMPORTE
FROM         CC_RECIBOS INNER JOIN
                      CBTES ON CC_RECIBOS.ID_CBTE = CBTES.ID_CBTE INNER JOIN
                      CC_RECIBOS_VALORES ON CC_RECIBOS.ID_CC_RECIBO = CC_RECIBOS_VALORES.ID_CC_RECIBO INNER JOIN
                      CONCEPTOS ON CC_RECIBOS_VALORES.ID_CONCEPTO = CONCEPTOS.ID_CONCEPTO INNER JOIN
                      CAJA_VALORES ON CC_RECIBOS_VALORES.ID_VALOR = CAJA_VALORES.ID_VALOR INNER JOIN
                      ENTIDADES ON CC_RECIBOS.ID_ENTIDAD = ENTIDADES.ID_ENTIDAD INNER JOIN
                      ENTIDADES_UBICACIONES ON ENTIDADES.ID_ENTIDAD = ENTIDADES_UBICACIONES.ID_ENTIDAD AND 
                      ENTIDADES_UBICACIONES.ID_UBICACION_TIPO = 1 LEFT OUTER JOIN
                      LOCALIDADES ON ENTIDADES_UBICACIONES.ID_LOCALIDAD = LOCALIDADES.ID_LOCALIDAD LEFT OUTER JOIN
                      PROVINCIAS ON LOCALIDADES.ID_PROVINCIA = PROVINCIAS.ID_PROVINCIA LEFT OUTER JOIN
                      PAISES ON PROVINCIAS.ID_PAIS = PAISES.ID_PAIS INNER JOIN
                      VALOR_TIPOS ON CC_RECIBOS_VALORES.CD_VALOR_TIPO = VALOR_TIPOS.CD_VALOR_TIPO
WHERE     (CC_RECIBOS_VALORES.CD_VALOR_TIPO = 'CH') AND (CC_RECIBOS.NO_RECIBO = '$idDetalle')
UNION ALL
SELECT     CC_RECIBOS_1.ID_CC_RECIBO, 'Valor' AS Tipo, CC_RECIBOS_VALORES_1.NO_LINEA, CBTES_1.DS_CBTE, ENTIDADES_1.DS_RAZON_SOCIAL, 
                      ENTIDADES_1.CD_CUIT, 
                      ENTIDADES_UBICACIONES_1.DS_DIRECCION + ' ' + ENTIDADES_UBICACIONES_1.DS_NUMERO + ' ' + ENTIDADES_UBICACIONES_1.DS_PISO + ' ' + ENTIDADES_UBICACIONES_1.DS_DPTO
                       AS Direccion, 
                      ' (' + ENTIDADES_UBICACIONES_1.CD_CP + ') ' + LOCALIDADES_1.DS_LOCALIDAD + ' - ' + PROVINCIAS_1.DS_PROVINCIA + ' - ' + PAISES_1.DS_PAIS AS Localidad, 
                      CC_RECIBOS_1.TP_RECIBO + '-' + CC_RECIBOS_1.NO_EMISOR + '-' + CC_RECIBOS_1.NO_RECIBO AS RECIBO, CC_RECIBOS_1.DT_EMISION, 
                      VALOR_TIPOS_1.DS_VALOR_TIPO, 
                      CASE WHEN cc_recibos_valores_1.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision ELSE cc_recibos_valores_1.DT_VALOR END AS Emision, 
                      CASE WHEN cc_recibos_valores_1.CD_valor_tipo = 'RN' THEN Retenciones.dt_emision ELSE cc_recibos_valores_1.DT_VALOR END AS Vence, 
                      CASE WHEN cc_recibos_valores_1.CD_valor_tipo = 'RN' THEN retenciones.Id_cbte_externo END AS Comprobante, 
                      CASE WHEN cc_recibos_valores_1.CD_valor_tipo = 'TB' THEN '' WHEN cc_recibos_valores_1.CD_valor_tipo = 'RN' THEN IMPUESTOS_REGIMEN.ds_impuesto_regimen
                       ELSE CONCEPTOS_1.DS_CONCEPTO END AS DS_CONCEPTO, NULL AS TotaL, CC_RECIBOS_VALORES_1.VL_IMPORTE
FROM         CC_RECIBOS AS CC_RECIBOS_1 INNER JOIN
                      CBTES AS CBTES_1 ON CC_RECIBOS_1.ID_CBTE = CBTES_1.ID_CBTE INNER JOIN
                      CC_RECIBOS_VALORES AS CC_RECIBOS_VALORES_1 ON CC_RECIBOS_1.ID_CC_RECIBO = CC_RECIBOS_VALORES_1.ID_CC_RECIBO INNER JOIN
                      CONCEPTOS AS CONCEPTOS_1 ON CC_RECIBOS_VALORES_1.ID_CONCEPTO = CONCEPTOS_1.ID_CONCEPTO LEFT OUTER JOIN
                      RETENCIONES ON CC_RECIBOS_VALORES_1.ID_VALOR = RETENCIONES.ID_RETENCION INNER JOIN
                      ENTIDADES AS ENTIDADES_1 ON CC_RECIBOS_1.ID_ENTIDAD = ENTIDADES_1.ID_ENTIDAD INNER JOIN
                      ENTIDADES_UBICACIONES AS ENTIDADES_UBICACIONES_1 ON ENTIDADES_1.ID_ENTIDAD = ENTIDADES_UBICACIONES_1.ID_ENTIDAD AND 
                      ENTIDADES_UBICACIONES_1.ID_UBICACION_TIPO = 1 LEFT OUTER JOIN
                      LOCALIDADES AS LOCALIDADES_1 ON ENTIDADES_UBICACIONES_1.ID_LOCALIDAD = LOCALIDADES_1.ID_LOCALIDAD LEFT OUTER JOIN
                      PROVINCIAS AS PROVINCIAS_1 ON LOCALIDADES_1.ID_PROVINCIA = PROVINCIAS_1.ID_PROVINCIA LEFT OUTER JOIN
                      PAISES AS PAISES_1 ON PROVINCIAS_1.ID_PAIS = PAISES_1.ID_PAIS INNER JOIN
                      VALOR_TIPOS AS VALOR_TIPOS_1 ON CC_RECIBOS_VALORES_1.CD_VALOR_TIPO = VALOR_TIPOS_1.CD_VALOR_TIPO LEFT OUTER JOIN
                      RETENCIONES_DETALLE ON RETENCIONES.ID_RETENCION = RETENCIONES_DETALLE.ID_RETENCION LEFT OUTER JOIN
                      IMPUESTOS_TASAS ON RETENCIONES_DETALLE.ID_IMPUESTO_TASA = IMPUESTOS_TASAS.ID_IMPUESTO_TASA LEFT OUTER JOIN
                      IMPUESTOS_REGIMEN ON IMPUESTOS_TASAS.ID_IMPUESTO_REGIMEN = IMPUESTOS_REGIMEN.ID_IMPUESTO_REGIMEN
WHERE     (CC_RECIBOS_VALORES_1.CD_VALOR_TIPO <> 'CH') AND (CC_RECIBOS_1.NO_RECIBO = '$idDetalle')
UNION ALL
SELECT     CC_RECIBOS_1.ID_CC_RECIBO, 'Aplicacion' AS Tipo, CC_RECIBOS_CBTES.NO_LINEA, CBTES_2.DS_CBTE, ENTIDADES_1.DS_RAZON_SOCIAL, 
                      ENTIDADES_1.CD_CUIT, 
                      ENTIDADES_UBICACIONES_1.DS_DIRECCION + ' ' + ENTIDADES_UBICACIONES_1.DS_NUMERO + ' ' + ENTIDADES_UBICACIONES_1.DS_PISO + ' ' + ENTIDADES_UBICACIONES_1.DS_DPTO
                       AS Direccion, 
                      ' (' + ENTIDADES_UBICACIONES_1.CD_CP + ') ' + LOCALIDADES_1.DS_LOCALIDAD + ' - ' + PROVINCIAS_1.DS_PROVINCIA + ' - ' + PAISES_1.DS_PAIS AS Localidad, 
                      CC_RECIBOS_1.TP_RECIBO + '-' + CC_RECIBOS_1.NO_EMISOR + '-' + CC_RECIBOS_1.NO_RECIBO AS RECIBO, CC_RECIBOS_1.DT_EMISION, 
                      CBTES_CONCEPTOS.DS_CBTE_CONCEPTO, CC_CBTES.DT_EMISION AS Expr1, CC_CBTES.DT_VENCE, CC_CBTES.ID_CBTE_EXTERNO, '' AS Expr3, 
                      CC_CBTES.VL_TOTAL AS Expr2, CC_RECIBOS_CBTES.VL_APLICA
FROM         CC_RECIBOS AS CC_RECIBOS_1 INNER JOIN
                      CBTES AS CBTES_2 ON CC_RECIBOS_1.ID_CBTE = CBTES_2.ID_CBTE INNER JOIN
                      CC_RECIBOS_CBTES ON CC_RECIBOS_1.ID_CC_RECIBO = CC_RECIBOS_CBTES.ID_CC_RECIBO INNER JOIN
                      CBTES AS CBTES_1 ON CC_RECIBOS_CBTES.ID_CBTE = CBTES_1.ID_CBTE INNER JOIN
                      CC_CBTES ON CC_RECIBOS_CBTES.ID_CC_APLICA = CC_CBTES.ID_CC_CBTE INNER JOIN
                      ENTIDADES AS ENTIDADES_1 ON CC_RECIBOS_1.ID_ENTIDAD = ENTIDADES_1.ID_ENTIDAD INNER JOIN
                      ENTIDADES_UBICACIONES AS ENTIDADES_UBICACIONES_1 ON ENTIDADES_1.ID_ENTIDAD = ENTIDADES_UBICACIONES_1.ID_ENTIDAD AND 
                      ENTIDADES_UBICACIONES_1.ID_UBICACION_TIPO = 1 LEFT OUTER JOIN
                      LOCALIDADES AS LOCALIDADES_1 ON ENTIDADES_UBICACIONES_1.ID_LOCALIDAD = LOCALIDADES_1.ID_LOCALIDAD LEFT OUTER JOIN
                      PROVINCIAS AS PROVINCIAS_1 ON LOCALIDADES_1.ID_PROVINCIA = PROVINCIAS_1.ID_PROVINCIA LEFT OUTER JOIN
                      PAISES AS PAISES_1 ON PROVINCIAS_1.ID_PAIS = PAISES_1.ID_PAIS INNER JOIN
                      CBTES_CONCEPTOS ON CBTES_1.CD_CBTE = CBTES_CONCEPTOS.CD_CBTE_CONCEPTO
WHERE     (CC_RECIBOS_1.NO_RECIBO = '$idDetalle')
ORDER BY Tipo, CC_RECIBOS_VALORES.NO_LINEA";

$result = sqlsrv_query($conn_pagos, $query);

$r = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);


$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);

$pdf->SetXY(35,45);
$pdf->Write(5,'GOLDEN PEANUT AND TREE NUTS S.A.');
$pdf->SetXY(0,10);

$pdf->Rect(130,18,70,30);
$pdf->Rect(10,60,190,30);
$pdf->Rect(10,102,190,10);
$pdf->Image('logo_golden_print.png',55,17,25,25);



$html='<table>
	<tr>
		<td width="700" height="30">&nbsp;</td><td width="100" height="30">Orden de Pago</td>
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
	<tr></tr>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="100" height="30">C.U.I.T:</td><td width="100" height="30">'.$r["CD_CUIT"].'</td>
	</tr>
	<tr>
		<td width="500" height="30">&nbsp;</td><td width="100" height="30">Recibo</td><td width="100" height="30">'.$r["RECIBO"].'</td>
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
		Pagamos a:
	</tr>
	<tr></tr>
	<tr>
		<td width="100" height="30">Razón Social:</td><td width="160" height="30">'.$r["DS_RAZON_SOCIAL"].'</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">C.U.I.T.</td><td>'.$r["CD_CUIT"].'</td>
	</tr>
	<tr>
		<td width="100" height="30">Domicilio</td><td width="160" height="30">'.$r["Direccion"].'</td><td width="240" height="30">&nbsp;</td><td width="100" height="30">Ganancias:</td><td>Inscripto</td>
	</tr>
	<tr>
		<td width="100" height="30">&nbsp;</td><td>'.$r["Localidad"].'</td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		
	</tr>
</table>';
$pdf->WriteHTML($html);


//Dibujar la primera columna
$htmlAplicacion ='<table><tr></tr>';
$htmlValor = '<table><tr></tr>';

if($r["DS_VALOR_TIPO"] == ""){
	$r["DS_VALOR_TIPO"] = '&nbsp;';
}

if($r["DS_CONCEPTO"] == ""){
	$r["DS_CONCEPTO"] = '&nbsp;';
}
if($r["Comprobante"] == ""){
	$r["Comprobante"] = '&nbsp;';
}

if($r["VL_IMPORTE"] == ""){
	$r["VL_IMPORTE"] = '&nbsp;';
}

$dateEmision = $r["Emision"]->format('d/m/Y');



if($r["Tipo"]== "Valor"){

	$importeValor = sprintf('%0.2f', $r['VL_IMPORTE']);
	$sumatoriaValores += $importeValor;
	$contadorValores++;

	formatearValor($r["VL_IMPORTE"]);

	$htmlValor .= '<tr>
			<td width="10" height="30">&nbsp;</td>
			<td width="200" height="30">'.$r["DS_VALOR_TIPO"].'</td>
			<td width="200" height="30">'.$r["DS_CONCEPTO"].'</td>
			<td width="170" height="30">'.$r["Comprobante"].'</td>
			<td width="100" height="30">'.$dateEmision.'</td>
			<td width="70" height="30" align="RIGHT">'.$r["VL_IMPORTE"].'</td>
		</tr>';

	
}

if($r["Tipo"]== "Aplicacion"){

	$importeAplicacion = sprintf('%0.2f', $r['VL_IMPORTE']);
	$sumatoriaAplicaciones += $importeAplicacion;
	$contadorAplicaciones++;
	formatearValor($r["VL_IMPORTE"]);
	$htmlAplicacion .= '<tr>
			<td width="10" height="30">&nbsp;</td>
			<td width="200" height="30">'.$r["DS_VALOR_TIPO"].'</td>
			<td width="200" height="30">'.$r["DS_CONCEPTO"].'</td>
			<td width="170" height="30">'.$r["Comprobante"].'</td>
			<td width="100" height="30">'.$dateEmision.'</td>
			<td width="70" height="30" align="RIGHT">'.$r["VL_IMPORTE"].'</td>
		</tr>';
	
	
}

while($r = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { //Por cada vuelta voy a tener una fila   
    
    

    if($r["DS_VALOR_TIPO"] == ""){
		$r["DS_VALOR_TIPO"] = '&nbsp;';
	}

	if($r["DS_CONCEPTO"] == ""){
		$r["DS_CONCEPTO"] = '&nbsp;';
	}
	if($r["Comprobante"] == ""){
		$r["Comprobante"] = '&nbsp;';
	}

	if($r["VL_IMPORTE"] == ""){
		$r["VL_IMPORTE"] = '&nbsp;';
	}

	$dateEmision = $r["Emision"]->format('d/m/Y');


    if($r["Tipo"]== "Valor"){
	$importeValor =sprintf('%0.2f', $r['VL_IMPORTE']);
    	$sumatoriaValores += $importeValor;
    	$contadorValores++;
	formatearValor($r["VL_IMPORTE"]);
    	$htmlValor .= '<tr>
				<td width="10" height="30">&nbsp;</td>
				<td width="200" height="30">'.$r["DS_VALOR_TIPO"].'</td>
				<td width="200" height="30">'.$r["DS_CONCEPTO"].'</td>
				<td width="170" height="30">'.$r["Comprobante"].'</td>
				<td width="100" height="30">'.$dateEmision.'</td>
				<td width="70" height="30" align="RIGHT">'.$r["VL_IMPORTE"].'</td>
			</tr>';

    	
    }

    if($r["Tipo"]== "Aplicacion"){
	$importeAplicacion = sprintf('%0.2f', $r['VL_IMPORTE']);
    	$sumatoriaAplicaciones += $importeAplicacion;
		$contadorAplicaciones++;
	formatearValor($r["VL_IMPORTE"]);
    	$htmlAplicacion .= '<tr>
				<td width="10" height="30">&nbsp;</td>
				<td width="200" height="30">'.$r["DS_VALOR_TIPO"].'</td>
				<td width="200" height="30">'.$r["DS_CONCEPTO"].'</td>
				<td width="170" height="30">'.$r["Comprobante"].'</td>
				<td width="100" height="30">'.$dateEmision.'</td>
				<td width="70" height="30" align="RIGHT">'.$r["VL_IMPORTE"].'</td>
			</tr>';
    	
	
    }
}

$pdf->Rect(10,133 +(5*$contadorAplicaciones),190,10);

$pdf->Line(177,115+(5*$contadorAplicaciones),200,115+(5*$contadorAplicaciones));

$pdf->Line(177,145+(5*$contadorAplicaciones)+(5*$contadorValores),200,145+(5*$contadorAplicaciones)+(5*$contadorValores));

$sumatoriaAplicaciones = number_format($sumatoriaAplicaciones, 2, '.', ',');
$htmlAplicacion .='
	<tr>
		<td width="10" height="30">&nbsp;</td>
		<td width="200" height="30">&nbsp;</td>
		<td width="200" height="30">&nbsp;</td>
		<td width="170" height="30">&nbsp;</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="70" height="30" align="RIGHT">'.$sumatoriaAplicaciones.'</td>
	</tr>
	<tr>
	</tr>
</table>';

$sumatoriaValores = number_format($sumatoriaValores, 2, '.', ',');
$htmlValor .= '
	<tr>
		<td width="10" height="30">&nbsp;</td>
		<td width="200" height="30">&nbsp;</td>
		<td width="200" height="30">&nbsp;</td>
		<td width="170" height="30">&nbsp;</td>
		<td width="100" height="30">&nbsp;</td>
		<td width="70" height="30" align="RIGHT">'.$sumatoriaValores.'</td>
	</tr>
	<tr>
	</tr>
</table>';



$html = '<table>
	
	<tr>
		Aplicacion
	</tr>
	<tr></tr>
	<tr>
		<td width="10" height="30">&nbsp;</td>
		<td width="200" height="30">Tipo</td>
		<td width="200" height="30">Descripción</td>
		<td width="170" height="30">Número</td>
		<td width="100" height="30">Fecha</td>
		<td width="70" height="30" align="RIGHT">Importe</td>
	</tr>
	</table>';
$pdf->WriteHTML($html);
$pdf->WriteHTML($htmlAplicacion);


$html = '<table>
	
	<tr>
		Valores
	</tr>
	<tr></tr>
	<tr>
		<td width="10" height="30">&nbsp;</td>
		<td width="200" height="30">Tipo</td>
		<td width="200" height="30">Descripción</td>
		<td width="170" height="30">Número</td>
		<td width="100" height="30">Fecha</td>
		<td width="70" height="30" align="RIGHT">Importe</td>
	</tr>
	</table>';
$pdf->WriteHTML($html);
$pdf->WriteHTML($htmlValor);

$html = '
	<table>
	<tr>
		<td>Observaciones:</td>
	</tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr>
		<td width="50" height="30">&nbsp;</td>
		<td width="200" height="30">Firma:</td>
		<td width="200" height="30">Aclaracion:</td>
		<td width="200" height="30">D.N.I:</td>
		<td width="200" height="30">Fecha:</td>
	</tr>
	</table>

';

$pdf->WriteHTML($html);

$nombreArchivo = $idDetalle."-OP.pdf";

$pdf->Output('F', $nombreArchivo);

echo "http://www.goldenpeanut.com.ar/descarga/creacion-pdf/".$nombreArchivo;

?>