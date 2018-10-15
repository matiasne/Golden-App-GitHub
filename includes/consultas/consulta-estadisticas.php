<?php 


  include '../../dbh.php';
  include '../estadisticas.php';

  
  $fechaDesde = $_POST['fechaDesde'];
  $fechaHasta = $_POST['fechaHasta'];

  $query= "SELECT  users.cuit, users.razon_social, estadisticas.accion, COUNT(estadisticas.accion) AS Expr1
  FROM estadisticas INNER JOIN users ON estadisticas.usuario = users.username WHERE estadisticas.fecha between '".$fechaDesde."' AND '".$fechaHasta."' GROUP BY  users.cuit, users.razon_social, estadisticas.accion
  ORDER BY users.razon_social";

  
   

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


while($myRow = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)){   
    echo  "<tr>			              	
              <td class='text-right' >".$myRow['cuit']."</td>
              <td class='text-left' >".$myRow['razon_social']."</td>
              <td class='text-left'>".$myRow['accion']."</td>
              <td class='text-right'>".$myRow['Expr1']."</td>
            </tr>";
   
}

?>