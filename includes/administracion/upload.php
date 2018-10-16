<?php
ini_set('display_errors',1);
    error_reporting(E_ALL);
    
$nombreUsuario = $_POST["nombreUsuario"];
$target_dir = "../uploads/".$nombreUsuario."/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {        
        $ficheros1  = scandir($target_dir);
        $resultado = array(
            'code' => "200",
            'archivos' => $ficheros1,
        );    
        echo json_encode($resultado);
    } else {
        $resultado = array(
            'code' => "404",
            'targetFile' => $target_file,
            'archivoTmp' => $_FILES["file"]["tmp_name"],

        );    
        echo json_encode($resultado);
    }
}
?>