<?php


include '../../dbh.php';

$ret = 'error';

$usuario = $_POST['USUARIO'];

$query = "SELECT * FROM users WHERE username='$usuario'"; 
$result = sqlsrv_query($conn, $query);
$res = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);

echo $res['razon_social'];
exit();