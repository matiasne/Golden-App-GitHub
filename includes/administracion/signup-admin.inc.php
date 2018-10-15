<?php


include '../../dbh.php';

$usuario = $_POST['USUARIO'];
$cuit = $_POST['CUIT'];

if(empty($usuario)){
	echo 'usuario vacio';
	exit();
}

if(empty($cuit)){
	echo 'cuit vacio';
	exit();
}
else{

	//Cada usuario creado debe tener sociado el id de cada tabla y su cuit

	$query = "SELECT * FROM ENTIDADES WHERE CD_CUIT='$cuit'"; 
	$result = sqlsrv_query($conn_pagos, $query);
	$res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	$id_entidad_sql = $res['ID_ENTIDAD'];

	$query = "SELECT * FROM MANI_ENTIDADES WHERE CD_CUIT='$cuit'"; 
	$result = sqlsrv_query($conn, $query);
	$res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	$id_entidad = $res['ID_ENTIDAD'];

	$razonSocial = $res['DS_RAZON_SOCIAL'];



	if(!$id_entidad){
		echo 'cuit desconocido';
		exit();
	}

	if(!$id_entidad_sql){
		echo 'cuit desconocido';
		exit();
	}

	$query = "INSERT INTO users (username,password,cuit,ID_ENTIDAD,ID_ENTIDADSQL,razon_social) VALUES ('$usuario', 'golden', '$cuit','$id_entidad','$id_entidad_sql','$razonSocial')";
	
	if (!sqlsrv_query($conn, $query))
    {            
        if( ($errors = sqlsrv_errors() ) != null) {
        	foreach( $errors as $error ) {
	            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
	            echo "code: ".$error[ 'code']."<br />";
	            echo "message: ".$error[ 'message']."<br />";
        	}
        	die();
    	}
    }		

	$query = "SELECT * FROM MANI_ENTIDADES WHERE CD_CUIT='$cuit'"; 
	$result = sqlsrv_query($conn, $query);
	$res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	echo 'usuario asociado a: '.$res['DS_RAZON_SOCIAL'];
	exit();
	
}
