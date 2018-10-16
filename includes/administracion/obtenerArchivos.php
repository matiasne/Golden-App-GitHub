<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    
    $nombreUsuario = $_POST["nombreUsuario"];
    $target_dir = "../uploads/".$nombreUsuario."/";
            
    $ficheros1  = scandir($target_dir);

    $resultado = array(
        'code' => "200",
        'archivos' => $ficheros1,
    );    
    echo json_encode($resultado);


?>