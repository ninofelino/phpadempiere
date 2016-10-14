<?php 
include_once('./lib/SDatabase.inc.php');
include_once('menu.php');
$sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;

$db = new SDatabase('services/adempiere.json'); // Open database

function state($resu)
{
$hs="";  
$x=0;
foreach ($resu as $hasil) {
        $ar=$hasil->templateurl;
        $x=$x+1;
        $nama=$hasil->templateurl;
        if (is_array($ar)) { $nama="arr".$x;}
        $hs .=".state('".$nama."',{templateUrl:'view/".$ar."',controller: function(@scope,@http,@stateParams,@timeout) {@scope.title=''; @http.get('".$hasil->datasource."').then(function(response){ @scope.related = response.data; });}}) " ;   
          if (is_array($ar)) { $hs.=state($ar);}
        }
return str_replace("@","$", $hs);
}

function getstate()
{

 
$resul = json_decode ($GLOBALS['jsoon']);
$jsoon=preg_replace("/[\n\r]/","",$GLOBALS['jsoon']);
$GLOBALS['db']->data["menu"]=trim($jsoon);
$GLOBALS['db']->save();


$js = "
var app=angular.module('demoApp', ['ngMaterial','ui.router','ngResource','md.data.table'])
.config(function(@mdThemingProvider) {
  @mdThemingProvider.theme('default')
    .primaryPalette('pink')
    .accentPalette('purple');
})
.config(function(@stateProvider,@urlRouterProvider){@stateProvider"
// app.registerCtrl = $controllerProvider.register;
.state($resul)

.""
.
" })
.controller('AppCtrl',
function(@scope,@mdSidenav,@http,@mdDialog){
    
     @scope.toggleSidenav = function () {
     @mdSidenav('nav').toggle();
  };
 @scope.showAlert = function(ev) {
    
    @mdDialog.show(
        @mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('This is an alert title')
        .textContent('You can specify some description text in here.')
        .ariaLabel('Alert Dialog Demo')
        .ok('Got it!')
        .targetEvent(ev)

    )
  };
   
      @http.get('services/adempiere.php/db/menu')
            .then(function(response){ @scope.related = response.data; });
          
     
   });
   
   app.controller('baru',function(@scope){@scope.title='baru'}).@inject = ['@scope', 'notify'];
   app.directive('felmenu', function() {

    return {
    templateUrl: function(elem, attr) {
      return 'directive/ftoolbar.html';
    }
  };});
 
   app.directive('sidenavigator', function() {

    return {
    templateUrl: function(elem, attr) {
      return 'directive/sidenav.html';
    }
  };});

   app.directive('std', function() {

    return {
    templateUrl: function(elem, attr) {
      return 'directive/default.html';
    }
  };});
  
";
//echo state($resul);
return str_replace('@','$',$js);
}

//echo getstate();
function getCurrentUri()
	{
		$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
		$uri = '/' . trim($uri, '/');
		return $uri;
	}

function runsql($name,$sequel) {
    $sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;
    
   // $sqldb->exec('SET search_path TO adempiere');
     $result=pg_query($sqldb,$sequel) or die(pg_last_error());
     $resultArray = pg_fetch_all($result);
     echo json_encode($resultArray);
   }

   

$method = $_SERVER['REQUEST_METHOD'];  //get post delete 
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

switch($request[0]) {
	case "view" :
	       $filename='directive/template/'.$request[1].'.html';
             if (file_exists($filename)) {
             $isifile=file_get_contents($filename, FILE_USE_INCLUDE_PATH);
             $db->data[$request[1]]=$isifile;
             $db->save();
             echo $db->data[$request[1]];
             } else {
             echo "The file $filename does not exist";
             echo '<std></std>'  ;
             copy('directive/default.html',$filename);
             }
	      break;
	  case "core" :
          echo getstate();
          break;
    case "sql": 
        $name="sql";
        $sql=$request[1];
             // $result=pg_query($GLOBALS['sqldb'],$sql) or die(pg_last_error()); 

            runsql("field",$sql);
          break;
    case "images": 
          $dh = opendir('images/24px');
          while ($file = readdir($dh))
          {
            echo '<md-button  class="md-fab md-primary md-hue-2"><img src="images/24px/'.$file.'" alt="l"></img></md-button>';
          }
          closedir($dh);
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
  
    default : 
             $filename = $request[0].".php";
             if (file_exists($filename)) {
              //  echo "The file $filename exists";
             } else {
             //  echo "The file $filename does not exist";
               copy("directive/default.html",$filename);
              }
           $name="default";
          // echo '<meta HTTP-EQUIV="REFRESH" content="0; url=page.php">';  
           $filehtml=file_get_contents('page.php', FILE_USE_INCLUDE_PATH);
           $db->data["page.php"]=$filehtml;
           $db->save();
           echo $db->data["page.php"];


}

	    
 




?>