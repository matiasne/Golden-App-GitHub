<?php

	include '../../dbh.php';	
	include '../estadisticas.php';
	insertarEstadistica($conn,$_POST['usuario'],"consulta-entrega");
	
	//echo $contrato;
	$fechaDesde = $_POST['fechaDesde'];
	$fechaHasta = $_POST['fechaHasta'];
	$contrato = $_POST['contrato'];	
	$Entidad = $_POST['ID_ENTIDAD'];
	$cosecha = $_POST['cosecha'];

	$dateDesde = new DateTime($fechaDesde);
	$dateHasta = new DateTime($fechaHasta);

	$stringDesde = $dateDesde->format('Y/m/d');
	$stringHasta = $dateHasta->format('Y/m/d');

	

	
		
	if($cosecha == "15/16"){
		$cosecha = "37";		
	}
	if($cosecha == "16/17"){
		$cosecha = "38";
		
	}

	if($cosecha == "17/18"){
		$cosecha = "39";
		
	}

	//echo $contrato;

	$query = "SELECT * FROM MANI_CONTRATOS WHERE CD_CONTRATO = '$contrato'";

	$result = sqlsrv_query($conn, $query);	

	$row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	$idContrato = (int)$row['ID_CONTRATO'];	


	$query = "SELECT     MANI_ENTIDADES.ID_ENTIDAD, MANI_ENTIDADES.DS_RAZON_SOCIAL, MANI_CONTRATOS.CD_CONTRATO, 'MANI EN CAJA' AS ESPECIE, 
                      MANI_SOM_MOVIM.DT_BRUTO, MANI_SOM_MOVIM.NO_CBTE, MANI_SOM_MOVIM.ID_SOM_MOVIM_EXTERNO, MANI_SOM_MOVIM.QT_DESTINO_NETO, 
                      MANI_SOM_ANALISIS.PC_HUMEDAD, MANI_CALIDADES.PC_MERMA_HUMEDAD + 0.25 AS PC_MERMA_HUMEDAD, MANI_SOM_ANALISIS.PC_TIERRA, 
                      MANI_SOM_ANALISIS.PC_CPOS_EXT, MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100) 
                      - (MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100)) 
                      * (MANI_SOM_ANALISIS.PC_TIERRA + MANI_SOM_ANALISIS.PC_CPOS_EXT) / 100 AS SecoLimpio, 
                      ROUND((MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100) * MANI_SOM_ANALISIS.PC_SUELTOS / 100) 
                      / (MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100) 
                      - (MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100)) 
                      * (MANI_SOM_ANALISIS.PC_TIERRA + MANI_SOM_ANALISIS.PC_CPOS_EXT) / 100) * 100, 2) AS PC_SUELTOS, 
                      ROUND((MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100) * MANI_SOM_ANALISIS.PC_MANI_COMERCIAL / 100)
                       / (MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100) 
                      - (MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100)) 
                      * (MANI_SOM_ANALISIS.PC_TIERRA + MANI_SOM_ANALISIS.PC_CPOS_EXT) / 100) * 100, 2) AS PC_MANI_COMERCIAL, 
                      ROUND(MANI_SOM_ANALISIS.PC_ZA8 + MANI_SOM_ANALISIS.PC_ZA75 + MANI_SOM_ANALISIS.PC_ZA725, 2) AS Confiteria, MANI_SOM_ANALISIS.IC_OK_CG, 
                      MANI_SOM_MOVIM.TP_EMISOR, MANI_SOM_C1116A.NO_CAC, 
                      ROUND(MANI_SOM_MOVIM.QT_DESTINO_NETO * ((100 - MANI_CALIDADES.PC_MERMA_HUMEDAD - 0.25) / 100), 0) AS KGSECOS, MANI_LUGARES.DS_LUGAR, 
                      MANI_LUGARES_CAMPOS.DS_CAMPO
                  FROM         MANI_SOM_MOVIM INNER JOIN
                      MANI_ENTIDADES ON MANI_SOM_MOVIM.ID_ENTIDAD = MANI_ENTIDADES.ID_ENTIDAD INNER JOIN
                      MANI_SOM_ANALISIS ON MANI_SOM_MOVIM.ID_SOM_MOVIM = MANI_SOM_ANALISIS.ID_SOM_MOVIM INNER JOIN
                      MANI_SOM_MOVIM_DETALLE ON MANI_SOM_MOVIM.ID_SOM_MOVIM = MANI_SOM_MOVIM_DETALLE.ID_SOM_MOVIM INNER JOIN
                      MANI_CONTRATOS ON MANI_SOM_MOVIM_DETALLE.ID_CONTRATO = MANI_CONTRATOS.ID_CONTRATO INNER JOIN
                      MANI_CALIDADES ON MANI_SOM_ANALISIS.PC_HUMEDAD = MANI_CALIDADES.PC_HUMEDAD LEFT OUTER JOIN
                      MANI_SOM_C1116A_DETALLE ON MANI_SOM_MOVIM.ID_SOM_MOVIM = MANI_SOM_C1116A_DETALLE.ID_SOM_MOVIM LEFT OUTER JOIN
                      MANI_SOM_C1116A ON MANI_SOM_C1116A_DETALLE.ID_C1116A = MANI_SOM_C1116A.ID_C1116A LEFT OUTER JOIN
                      MANI_LUGARES ON MANI_SOM_MOVIM.CD_ORIGEN_LUGAR = MANI_LUGARES.CD_LUGAR LEFT OUTER JOIN
                      MANI_LUGARES_CAMPOS ON MANI_SOM_MOVIM.CD_ORIGEN_CAMPO = MANI_LUGARES_CAMPOS.CD_CAMPO			
                  WHERE     (MANI_SOM_MOVIM.ID_ENTIDAD = '$Entidad') AND (MANI_SOM_MOVIM_DETALLE.ID_CONTRATO = '$idContrato') AND (MANI_CONTRATOS.ID_COSECHA = '$cosecha')
		      /*AND (MANI_SOM_MOVIM.DT_BRUTO BETWEEN '$stringDesde' AND '$stringHasta')*/
                  
                  ORDER BY 5,21,6";


			  	//$result = odbc_exec($conexion, $query);	
			  	$result = sqlsrv_query($conn, $query);

			  	while($myRow = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){ 

			  		//Formateo a 2 dígitos
			  		$pcHumedad = sprintf('%0.2f', $myRow['PC_HUMEDAD']);  
			  		$pcMermaHumedad = sprintf('%0.2f', $myRow['PC_MERMA_HUMEDAD']);
			  		$pcTierra = sprintf('%0.2f', $myRow['PC_TIERRA']);
			  		$pcPosExt = sprintf('%0.2f', $myRow['PC_CPOS_EXT']);
			  		//$kgSecoLimpio = sprintf('%0.0f', $myRow['SecoLimpio']);
			  		$pcSueltos = sprintf('%0.2f', $myRow['PC_SUELTOS']);
			  		$pcManiComercial = sprintf('%0.2f', $myRow['PC_MANI_COMERCIAL']);  
			  		$confiteria = sprintf('%0.2f', $myRow['Confiteria']);

			  		$kg_format = number_format((int)$myRow['QT_DESTINO_NETO'], 0, ',', '.');
			  		$kgSecoLimpio = number_format($myRow['SecoLimpio'], 0, ',', '');
			  		

			  		$pcHumedad = number_format($pcHumedad, 2, ',', '.');
			  		$pcMermaHumedad = number_format($pcMermaHumedad, 2, ',', '.');
			  		$pcTierra = number_format($pcTierra, 2, ',', '.');
			  		$pcPosExt = number_format($pcPosExt, 2, ',', '.');
			  		$pcSueltos = number_format($pcSueltos, 2, ',', '.');
			  		$pcManiComercial = number_format($pcManiComercial, 2, ',', '.');
			  		$confiteria = number_format($confiteria, 2, ',', '.');

			  		$nroCertificado = (string) $myRow['NO_CAC']."_";

			  		//Si el analisis no ha sido realizdo no mostrar los últimos tres valores
			  		if($myRow['IC_OK_CG'] != "1"){
			  			$pcSueltos = "";
			  			$pcManiComercial = "";
			  			$confiteria = "";
			  		}

			  		$kilosSecos = $myRow['KGSECOS'];
			  		if($myRow['NO_CAC'] == ""){
			  			$kilosSecos = "";
			  		}

			  		if ($dateDesde <= $myRow['DT_BRUTO'] ){
			  			if($dateHasta >= $myRow['DT_BRUTO']){
						echo  "	<tr>
									<th class='headcol'>".$myRow['DT_BRUTO']->format("d-m-Y")."</th>
									<td class='text-right'>".$myRow['TP_EMISOR']."</td>            	
					              	<td class='text-right'>".$myRow['ID_SOM_MOVIM_EXTERNO']."</td>
					              	<td class='text-right'>".$kg_format."</td>
					              	<td class='text-right'>".$pcHumedad."</td>
					              	<td class='text-right'>".$pcMermaHumedad."</td>
					              	<td class='text-right'>".$pcTierra."</td>
					              	<td class='text-right'>".$pcPosExt."</td>
					              	<td class='text-right'>".$kgSecoLimpio."</td>
					              	<td class='text-right'>".$pcSueltos."</td>
					              	<td class='text-right'>".$pcManiComercial."</td>
					              	<td class='text-right'>".$confiteria."</td>
					              	<td class='text-right'>".$nroCertificado."</td>  
					              	<td class='text-right'>".$kilosSecos."</td>  
					              	<td class='text-right'>".$myRow['DS_CAMPO']."</td>  
					          </tr>
					          ";
					      }
					  }
				}




//echo $result;