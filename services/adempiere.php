<?php 
$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$_SESSION["favcolor"] = "green";


session_start();

$sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;

//echo "Session:".var_dump($_SESSION);
echo "Method".$method;
echo "Request";
echo $request;

if (!isset($username) || !isset($password)) {
header("login.html");
}
//melihat apakah form telah diisi semua atau tidak. Jika tidak, user akan dikembalikan ke
//halaman login.html
elseif (empty($username) || empty($password)) {
header( "login");
}
else{
//mengubah username dan password yang telah dimasukkan menjadi sebuah variabel dan meng-enkripsi password ke md5
$user = addslashes($_POST[‘username’]);
$pass = md5($_POST[‘password’]);
}


switch($request[0]) {
	case "login" :

	      echo "list al object";
	      echo  $method;
	      echo  $_SESSION;
	      break;

}


?>

