<?php 
include_once('./lib/SDatabase.inc.php');


function getCurrentUri()
	{
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
		$uri = '/' . trim($uri, '/');
		return $uri;
	}

function runsql($name,$sequel) {
  
  //$sqldb = pg_connect("host=localhost dbname=cendold1_adempiere user=cendold1_test password=2Sz8kSoUnHdM options='--client_encoding=UTF8'") or die(pg_last_error());

  

   $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
    
   // $sqldb->exec('SET search_path TO adempiere');
    $result=pg_query($sqldb,$sequel) or die(pg_last_error());
    $resultArray = pg_fetch_all($result);
    echo json_encode($resultArray);
          

   }

   function page(){

   }

$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
$db = new SDatabase('./lib/model.window.json');
$dbsql = new SDatabase('./lib/model.sql.json');
$_SESSION["favcolor"] = "green";
session_start();

switch($request[0]) {
	case "list" :
	      echo "list al object";
	      break;
	
    case "sql": 
        $name="sql";
        $sql=$request[1];
          runsql("field",$sql);
          break;
    case "m_product_category": 
        $name="sql";
        $sql="select a.name,a.isactive,(select count(name) from m_product where m_product_category_id=a.m_product_category_id) as cn from m_product_category a";
          runsql("field",$sql);
          break;
    
    case "login":
          $name="login";
          $sql="select name,password,isactive from ad_user";
          runsql($name,$sql);
          break;

    case "menu": 
	      $name="menu";
	      $sql="select name,action from ad_menu limit 10";
          runsql("field",$sql);      
          break;
    case "template": 
	      $name="template";
	      $sql="select name,action from ad_menu limit 10";
          echo "<h1>Template</h1>";
          echo "from request";
          echo $request[0];
          echo $request[1];
          echo '<div ng-repeat="item on related">{{item}}</div>';

          break;      
	case  "window":
	      $name="window";
          $sql="select 
          (select name from ad_window where Ad_window_id=a.Ad_window_id) as window,
          (select name from ad_tab where Ad_tab_id=a.Ad_tab_id) as tab,	a.name,
          (select name from ad_column where Ad_column_id=a.Ad_column_id) as column,
          (select tablename from ad_column where Ad_column_id=a.Ad_column_id) as table,
          ad_column_id,name from ad_field_v a
          where Ad_window_id=200006
          limit 100";
          runsql("field",$sql);
          break;
    default : echo "default"  ;
             $filename = $request[0].".php";
             if (file_exists($filename)) {
                echo "The file $filename exists";
             } else {
    echo "The file $filename does not exist";
               copy("directive/default.html",$filename);
              }
           $name="default";
           echo '<meta HTTP-EQUIV="REFRESH" content="0; url=page.php">';  

}

	      $dbsql->data[$name]=$sql;
	      $dbsql->save();
		  
 




?>