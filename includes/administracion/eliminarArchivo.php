<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    
    $nombreUsuario = $_POST["nombreUsuario"];
    $nombreArchivo = $_POST["nombreArchivo"];
    $target_dir = "../uploads/".$nombreUsuario."/";
            
    
    unlink($target_dir.$nombreArchivo);

    $ficheros1  = scandir($target_dir);

    $resultado = array(
        'code' => "200",
        'eliminado'=> $target_dir.$nombreArchivo,
        'archivos' => $ficheros1,
    );    
    echo json_encode($resultado);


?>