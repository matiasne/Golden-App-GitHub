<?php

include '../../dbh.php';

$usuario = $_POST['USUARIO'];
$contrasena = $_POST['CONTRASENA'];
$confirmar_contrasena = $_POST['CONF-CONTRASENA'];


if($contrasena != $confirmar_contrasena){
	echo 'error validando contraseña';
	exit();
}

if(empty($usuario)){
	echo 'cuit_vacio';
	exit();
}

if(empty($contrasena)){
	echo 'contrasena vacia';
	exit();
}

if(empty($confirmar_contrasena)){
	echo 'confirmacion contrasena vacia';
	exit();
}
else{

	$query = "UPDATE users SET password='$contrasena' WHERE username='$usuario'";
	
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
	echo 'usuario_actualizado';
	exit();
	
}