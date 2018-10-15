<?php 


  include '../../dbh.php';
  include '../estadisticas.php';

  
  $fechaDesde = $_POST['fechaDesde'];
  $fechaHasta = $_POST['fechaHasta'];

  $fechaD =  date("Y-m-d",strtotime($fechaDesde));
  $fechaH =  date("Y-m-d",strtotime($fechaHasta));

  $query= "SELECT     CONVERT(varchar(10), fecha, 111) AS Expr1, COUNT(id) AS Expr2
  FROM         estadisticas
  WHERE     (accion = 'login') AND (CONVERT(varchar(10), fecha, 111) >= '".$fechaD."') AND (CONVERT(varchar(10), fecha, 111) <= '".$fechaH."')
  GROUP BY CONVERT(varchar(10), fecha, 111)
  ORDER BY 1";
  

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

    

	$rows = array();
	while($r = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {	
        
	    $rows[] = $r;
    }    
    
    echo json_encode($rows);

?>