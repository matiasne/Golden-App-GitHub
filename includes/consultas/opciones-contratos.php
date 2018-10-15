<?php

	include '../../dbh.php';
	
	
	$idEntidad = $_POST['ID_ENTIDAD'];
	
	$query = "SELECT CD_CONTRATO, ID_COSECHA FROM MANI_CONTRATOS WHERE ID_ENTIDAD = '$idEntidad' ORDER BY CD_CONTRATO";

	$result = sqlsrv_query($conn, $query);

	if( ($errors = sqlsrv_errors() ) != null) {
    	foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
    	}
    	die();
	}



	$rows = array();
	while($r = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {		
	    $rows[] = $r;
	}
	

	if($_POST['usuario'] == 1)
	{
		echo json_encode($rows[3]);
	}
	else{
		echo json_encode($rows);
	}
	
?>