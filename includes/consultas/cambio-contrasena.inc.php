<?php


include '../../dbh.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena-nueva'];
$confirmar_contrasena = $_POST['conf-contrasena-nueva'];


if($contrasena != $confirmar_contrasena){
	echo 'error validando contraseña';
	exit();
}

if(empty($contrasena)){
	echo 'contrasena_vacio';
	exit();
}

if(empty($confirmar_contrasena)){
	echo 'confirmar_contrasena_vacio';
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
	echo 'ok';
	exit();	
}