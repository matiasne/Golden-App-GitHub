<?php

function insertarEstadistica($conn,$usuario,$accion){

    $hoy = date("Y-m-d H:i:s");
    $query = "INSERT INTO estadisticas (usuario,accion,fecha) VALUES ('$usuario','$accion','$hoy')";

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
}
