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
// home -> fronpage
// db   -> database
// util -> utility
// {"name":"application"}
//           -> state       application.state
//             -> controller  application.controller |
//             -> directive   application.directive  | generate ../mvc
//             -> datasource  db/datasource

 echo "create";
	      $home=file_get_contents('erp.php');
	      $home=base64_encode($home);
	      $myfile=fopen("app.php","w");
	      fwrite($myfile,"function home { return'".$home."'}");

	      
	      file($myfile);

switch (request[0]) {
	case 'home':
	     
	      break;
	case 'mvc':
		# code...
		break;
    case 'directive':
		# code...
		break;
	case 'factory':
		# code...
		break;
		

	case 'template':
		# code...
		break;
	case 'savebase64':
		# code...
		break;	
	default:
		# code...
      	echo $erp->exec($request[0],$request[1]);
    break;
}
?>