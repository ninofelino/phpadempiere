<?php
include '../services/erp.php';
$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

$erp=new erp;
$erp->initObj();
$debug=5;

//echo $erp->exec($request[0]);
//echo $_SERVER['PATH_INFO'].request[1];
error_log("PATH INFO".$_SERVER['PATH_INFO']);
error_log("Request 0: ".$request[0]);
error_log("Request 1: ".$request[1]);

echo $erp->exec($request[0],$request[1]);
?>