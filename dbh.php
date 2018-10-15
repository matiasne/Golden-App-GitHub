<?php


$serverName = "Roca12\sqlexpress";
$uid = "Golden";
$pwd = "golden";
$connectionInfo = array( "UID"=>$uid,
"PWD"=>$pwd,
"Database"=>"SOMPROAR",
"CharacterSet" => "UTF-8");
 
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
	echo "No es posible conectarse al servidor.</br>";
	die( print_r( sqlsrv_errors(), true));
}

$serverName = "Roca12\sqlexpress";
$uid = "Golden";
$pwd = "golden";
$connectionInfo = array( "UID"=>$uid,
"PWD"=>$pwd,
"Database"=>"CVM_GPA_GES_01",
"CharacterSet" => "UTF-8");
 
$conn_pagos = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn_pagos === false )
{
  echo "No es posible conectarse al servidor.</br>";
  die( print_r( sqlsrv_errors(), true));
}