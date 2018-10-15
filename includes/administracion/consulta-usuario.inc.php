<?php


include '../../dbh.php';

$ret = 'error';

$usuario = $_POST['usuario-nombre'];


$query = "SELECT * FROM users WHERE username='$usuario'"; //Verifica si es un usuario ya creado
$result = sqlsrv_query($conn, $query);
$creado = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);

if($creado){
	$ret = 'encontrado';
}
else{
	$ret = 'inexistente';   	
}

echo $ret;
exit();

/*$query = "SELECT * FROM MANI_ENTIDADES WHERE CD_CUIT='$cuit'"; //Verificamos si existe entidad en SOMPROAR 
$result = sqlsrv_query($conn, $query);
$res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);

if(!$res){
	echo 'usuario no encontrado en SOMPROAR';
	die();
}


$query = "SELECT * FROM ENTIDADES WHERE CD_CUIT='$cuit'"; //Verificamos si existe entidad en SOMPROAR 
$result = sqlsrv_query($conn_pagos, $query);
$res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);

if(!$res){
	echo 'usuario no encontrado en CVM_GPA_GES_01';
	die();
}


$query = "SELECT user FROM users WHERE cuit='$cuit'"; //Verifica si es un usuario ya creado
$result = sqlsrv_query($conn, $query);
$creado = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);

if($creado){
	$ret = 'encontrado';
}
else{
	$ret = 'inexistente';   	
}

echo $ret;
exit();*/
