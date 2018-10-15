<?php 


  include '../../dbh.php';

  ini_set('display_errors',1);
  error_reporting(E_ALL);


  $fechaDesde = $_POST['fechaDesde'];
  $fechaHasta = $_POST['fechaHasta'];


  

    $query = "SELECT COUNT( DISTINCT ID_ENTIDAD) as PRODUCTORES
    FROM MANI_SOM_MOVIM where ID_COSECHA = 39 AND ID_CBTE_CONCEPTO IN ('LP','CT')";

    $result = sqlsrv_query($conn, $query);
    if(!$result){
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
        die();
    }
    }

    $res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
    $total = $res['PRODUCTORES'];

    $query= "SELECT     COUNT(DISTINCT usuario) AS Accion
    FROM         estadisticas
    WHERE     (accion = 'login') AND (CONVERT(date, fecha) BETWEEN '".$fechaDesde."' AND '".$fechaHasta."')";

    $result = sqlsrv_query($conn, $query);
        if(!$result){
        if( ($errors = sqlsrv_errors() ) != null) {
            foreach( $errors as $error ) {
                echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                echo "code: ".$error[ 'code']."<br />";
                echo "message: ".$error[ 'message']."<br />";
            }
            die();
        }
    }


    $res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
    $logueados = $res['Accion'];

    $query= "SELECT     COUNT(DISTINCT usuario) AS Accion
    FROM         estadisticas
    WHERE     (accion = 'consulta-entrega') AND (CONVERT(date, fecha) BETWEEN '".$fechaDesde."' AND '".$fechaHasta."')";

    $result = sqlsrv_query($conn, $query);
        if(!$result){
        if( ($errors = sqlsrv_errors() ) != null) {
            foreach( $errors as $error ) {
                echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                echo "code: ".$error[ 'code']."<br />";
                echo "message: ".$error[ 'message']."<br />";
            }
            die();
        }
    }

    $res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
    $entregas = $res['Accion'];

    $query= "SELECT     COUNT(DISTINCT usuario) AS Accion
    FROM         estadisticas
    WHERE     (accion = 'consulta-promedios') AND (CONVERT(date, fecha) BETWEEN '".$fechaDesde."' AND '".$fechaHasta."')";

    $result = sqlsrv_query($conn, $query);
        if(!$result){
        if( ($errors = sqlsrv_errors() ) != null) {
            foreach( $errors as $error ) {
                echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                echo "code: ".$error[ 'code']."<br />";
                echo "message: ".$error[ 'message']."<br />";
            }
            die();
        }
    }

    $res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
    $promedios = $res['Accion'];

    $query= "SELECT     COUNT(DISTINCT usuario) AS Accion
    FROM         estadisticas
    WHERE     (accion = 'consulta-pagos') AND (CONVERT(date, fecha) BETWEEN '".$fechaDesde."' AND '".$fechaHasta."')";

    $result = sqlsrv_query($conn, $query);
        if(!$result){
        if( ($errors = sqlsrv_errors() ) != null) {
            foreach( $errors as $error ) {
                echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                echo "code: ".$error[ 'code']."<br />";
                echo "message: ".$error[ 'message']."<br />";
            }
            die();
        }
    }

    $res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
    $pagos = $res['Accion'];

    $rows = array(
        'total' => $total,
        'logueados' => $logueados,
        'entregas' => $entregas,
        'promedios' => $promedios,
        'pagos' => $pagos
    );

    echo json_encode($rows);

?>