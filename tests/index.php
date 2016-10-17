<?php
include '../services/erp.php';
$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));

$erp=new erp;
$erp->initObj();
$debug=5;

//echo $erp->exec($request[0]);
//echo $_SERVER['PATH_INFO'].request[1];
echo $erp->exec(str_replace('/','',$_SERVER['PATH_INFO']));
?>