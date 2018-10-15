<?php

include '../../dbh.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['password'];
$id_entidad = $_POST['id_entidad'];


if(empty($usuario)){
	header("Location: ../adminPanel.html?error=empty");
	exit();
}

if(empty($contrasena)){
	header("Location: ../adminPanel.html?error=empty");
	exit();
}
else{

	//$sql = "SELECT user FROM users WHERE username='$usuario'";
	//$result = mysqli_query($conn,$sql);

	//$result  = $conn->Execute("SELECT user FROM users WHERE username='$usuario'");
	//if ($result === false) die("Error al consultar por usuario"); 

	$query = "SELECT user FROM users WHERE username='$usuario'";
	$result = sqlsrv_query($conn, $query);
	//$usuarioCheck = mysqli_num_rows($result);
	

	//if($usuarioCheck > 0){
	
	if(!$result){
		header("Location: ../adminPanel.html?error=username");
		exit();
	}
	else{


		//$encrypted_password = password_hash($password,PASSWORD_BCRYPT);

		//$sql = "INSERT INTO users (username,password) VALUES ('$usuario', '$contrasena')";
		//$result = mysqli_query($conn,$sql);


		//$conn->Execute("INSERT INTO users (username,password,ID_ENTIDAD) VALUES ('$usuario', '$contrasena', '$id_entidad')");

		$query = "INSERT INTO users (username,password,ID_ENTIDAD) VALUES ('$usuario', '$contrasena', '$id_entidad')";

		//$var = array ($usuario,$contrasena,$id_entidad); 


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
		header("Location: ../adminPanel.html?msj=asignado");
		exit();
	}
}

