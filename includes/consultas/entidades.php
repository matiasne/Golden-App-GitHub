<?php

	include '../../dbh.php';

	$contrato = $_POST['contrato'];	
	
	//echo $contrato;

	$query = "SELECT id_entidad,ds_razon_social FROM Mani_Entidades WHERE Id_Entidad IN (SELECT id_entidad FROM Mani_Contratos WHERE tp_contrato = 'E' AND id_cosecha = 39)";

	$result = sqlsrv_query($conn, $query);	

	$rows = array();
	while($r = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {		
	    $rows[] = $r;
	}

	echo json_encode($rows);