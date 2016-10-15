<?php 
include_once('./lib/SDatabase.inc.php');
include_once('menu.php');
$sqldb = pg_connect("host=localhost dbname=adempiere user=adempiere password=adempiere") or die(pg_last_error()) ;

$db = new SDatabase('adempiere.json'); // Open database

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

 
//$resul = json_decode ($GLOBALS['jsoon']);
$resul = json_decode($GLOBALS['db']->data['menu']);
$jsoon=preg_replace("/[\n\r]/","",$GLOBALS['jsoon']);
$GLOBALS['db']->data["menu"]=trim($jsoon);
$GLOBALS['db']->save();


$js = "
var app=angular.module('demoApp', ['ngMaterial','ui.router','ngResource','angularUtils.directives.dirPagination'])
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
    case  "libs":
           $isi=file_get_contents('lib/'.$request[1]);
           $nama=str_replace('-.', '_',$request[1]);
           $db->data[$nama]=$isi;
           $db->save();
           echo $isi;
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

	    
 




?>function page_php(){ return"PCFET0NUWVBFIGh0bWw+DQoNCjxodG1sPg0KPGhlYWQ+DQo8dGl0bGU+bmlub2ZlbGlubzwvdGl0bGU+DQo8bGluayByZWw9InN0eWxlc2hlZXQiIGhyZWY9ImxpYi9hbmd1bGFyLW1hdGVyaWFsLmNzcyI+DQo8c2NyaXB0IHNyYz0ibGliL2FuZ3VsYXIubWluLmpzIj48L3NjcmlwdD4NCjxzY3JpcHQgc3JjPSJsaWIvYW5ndWxhci1hbmltYXRlLm1pbi5qcyI+PC9zY3JpcHQ+DQo8c2NyaXB0IHNyYz0ibGliL2FuZ3VsYXItYXJpYS5taW4uanMiPjwvc2NyaXB0Pg0KPHNjcmlwdCBzcmM9ImxpYi9hbmd1bGFyLW1hdGVyaWFsLm1pbi5qcyI+PC9zY3JpcHQ+DQo8bGluayByZWw9InN0eWxlc2hlZXQiIGhyZWY9ImxpYi9pY29uLmNzcyI+DQo8bGluayByZWw9InN0eWxlc2hlZXQiIGhyZWY9ImxpYi9hbmd1bGFyLW1hdGVyaWFsLm1pbi5jc3MiPg0KPHNjcmlwdCBzcmM9ImxpYi9hbmd1bGFyLXVpLXJvdXRlci5qcyI+PC9zY3JpcHQ+DQo8c2NyaXB0IHNyYz0ibGliL2FuZ3VsYXItcmVzb3VyY2UubWluLmpzIj48L3NjcmlwdD4NCjxzY3JpcHQgc3JjPSJsaWIvYW5ndWxhci1tYXRlcmlhbC1pY29ucy5taW4uanMiPjwvc2NyaXB0Pg0KPHNjcmlwdCBzcmM9ImxpYi9kaXJQYWdpbmF0aW9uLmpzIj48L3NjcmlwdD4NCg0KPHNjcmlwdCBzcmM9ImxpYi9kaXN0Lm1pbi5qcyI+PC9zY3JpcHQ+DQo8c2NyaXB0IHNyYz0iY29yZSI+PC9zY3JpcHQ+DQoNCjxzY3JpcHQgc3JjPSJsaWIvaG9sZGVyLmpzIj48L3NjcmlwdD4NCjxzY3JpcHQgc3JjPSJsaWIvYWhvbGRlci5qcyI+PC9zY3JpcHQ+DQo8c2NyaXB0IHNyYz0ibGliL2FuZ3VsYXItbWF0ZXJpYWwtcGFnaW5nLmpzIj48L3NjcmlwdD4NCjxsaW5rIHJlbD0ic3R5bGVzaGVldCIgaHJlZj0ibGliL2FuZ3VsYXItbWF0ZXJpYWwtcGFnaW5nLmNzcyI+DQoNCjxsaW5rIGhyZWY9ImxpYi9tZC1kYXRhLXRhYmxlLmNzcyIgcmVsPSJzdHlsZXNoZWV0IiB0eXBlPSJ0ZXh0L2NzcyIvPg0KPCEtLSBtb2R1bGUgLS0+DQo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSJsaWIvbWQtZGF0YS10YWJsZS5qcyI+PC9zY3JpcHQ+DQoNCg0KPC9oZWFkPg0KDQoNCg0KDQo8Ym9keT4NCg0KPGRpdiBuZy1hcHA9ImRlbW9BcHAiPg0KDQo8ZGl2IG5nLWNvbnRyb2xsZXI9IkFwcEN0cmwiPg0KICAgIDxkaXYgbmctYXBwPSJhcHAiIG5nLWNvbnRyb2xsZXI9IkFwcEN0cmwiPg0KICA8ZGl2IGxheW91dD0icm93Ij4NCg0KICA8c2lkZW5hdmlnYXRvcj48L3NpZGVuYXZpZ2F0b3I+DQoNCiAgDQogICAgICAgIA0KPCEtLSBjb250ZW50IHRlbXBsYXRlIC0tPiAgICANCiAgICAgICANCiAgICANCiAgICAgICA8ZGl2IGlkPSJjb250ZW50IiB1aS12aWV3Pg0KICAgICAgIA0KICAgICAgIDxmZWxtZW51PjwvZmVsbWVudT4NCiAgICAgDQogICAgICA8bWQtcHJvZ3Jlc3MtbGluZWFyIG1kLW1vZGU9ImluZGV0ZXJtaW5hdGUiPjwvbWQtcHJvZ3Jlc3MtbGluZWFyPg0KDQogICAgICA8bWQtcHJvZ3Jlc3MtY2lyY3VsYXIgbWQtbW9kZT0iaW5kZXRlcm1pbmF0ZSI+PC9tZC1wcm9ncmVzcy1jaXJjdWxhcj4NCiAgICANCg0KICAgICAgIDwvZGl2Pg0KICAgICAgIA0KICAgIA0KICA8L2Rpdj4NCjwvZGl2Pg0KPC9kaXY+DQoNCjwvYm9keT4NCjwvaHRtbD4NCg==";}  function menu(){ return"WyAgeyJ1cmwiOiJBZG1pbmlzdHJhdGlvbiIsImljb24iOiJ4LnN2ZyIsImRhdGFTb3VyY2UiOiJzZWxlY3QgKiBmcm9tIGFkX21lbnUiLCJ0ZW1wbGF0ZXVybCI6WyAgeyJ1cmwiOiJPcmdhbml6YXRpb24iLCJpY29uIjoib3JnLnN2ZyIsInRlbXBsYXRldXJsIjoib3JnIiwiZGF0YXNvdXJjZSI6InNlcnZpY2VzL2FkZW1waWVyZS5waHAvYWRfb3JnIn0sICB7InVybCI6IkNsaWVudCIsImljb24iOiJjbGllbnQuc3ZnIiwidGVtcGxhdGV1cmwiOiJjbGllbnQiLCJkYXRhc291cmNlIjoiaW5kZXgucGhwL3NxbC9zZWxlY3QgKiBmcm9tIGFkX2NsaWVudCJ9LCAgeyJ1cmwiOiJSb2xlcyIsImljb24iOiJ1c2VyLnN2ZyIsInRlbXBsYXRldXJsIjoicm9sZSIsImRhdGFzb3VyY2UiOiJpbmRleC5waHAvc3FsL3NlbGVjdCAqIGZyb20gYWRfcm9sZSJ9LCAgeyJ1cmwiOiJVc2VyIiwiaWNvbiI6InVzZXIuc3ZnIiwidGVtcGxhdGV1cmwiOiJ1c2VyIiwiZGF0YXNvdXJjZSI6InNlcnZpY2VzL2FkZW1waWVyZS5waHAvYWRfdXNlciJ9ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBdfSwgICAgICAgICAgICAgICAgICAgICB7InVybCI6IldpbmRvdyIsImljb24iOiJ3aW5kb3cuc3ZnIiwidGVtcGxhdGV1cmwiOlsgICAgICB7InVybCI6InRhYiIsImljb24iOiJ3aW5kb3cuc3ZnIiwidGVtcGxhdGV1cmwiOiJ0YWIiLCJkYXRhc291cmNlIjoic2VydmljZXMvYWRlbXBpZXJlLnBocC90YWIifSwgICAgICAgICAgICAgICAgICAgICAgIHsidXJsIjoidGFibGUiLCJpY29uIjoidGFibGUuc3ZnIiwidGVtcGxhdGV1cmwiOiJ0YWJsZSJ9LCAgICAgICAgICAgICAgICAgICAgICAgeyJ1cmwiOiJSZWZlcmVuY2UiLCJpY29uIjoid2luZG93LnN2ZyIsInRlbXBsYXRldXJsIjoiYWRfcmVmZXJlbmNlIn0sICAgICAgICAgICAgICAgICAgICAgICB7InVybCI6InZpZXciLCJpY29uIjoidmlldy5zdmciLCJ0ZW1wbGF0ZXVybCI6InZpZXcifSwgICAgICAgICAgICAgICAgICAgICAgIHsidXJsIjoid2luZG93IiwiaWNvbiI6IndpbmRvdy5zdmciLCJ0ZW1wbGF0ZXVybCI6IndpbmRvdyJ9ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBdfSwgICAgICAgICB7InVybCI6IlNxbCIsImljb24iOiJzcWwuc3ZnIiwidGVtcGxhdGV1cmwiOlsgICAgICAgICAgICAgICAgICAgICB7InVybCI6InByb2R1Y3QyIiwiaWNvbiI6InByb2R1Y3Quc3ZnIiwidGVtcGxhdGV1cmwiOiJwcm9kdWN0MSJ9LCAgICAgICAgICAgICAgICAgICAgIHsidXJsIjoiQnVzc2luZXNzIiwiaWNvbiI6ImJwYXJ0bmVyLnN2ZyIsInRlbXBsYXRldXJsIjoicHJvZHVjNXQifSwgICAgICAgICAgICAgICAgICAgICB7InVybCI6InByb2R1Y3QiLCJ0ZW1wbGF0ZXVybCI6InByb2R1Y3QifSwgICAgICAgICAgICAgICAgICAgICB7InVybCI6Imljb24iLCJ0ZW1wbGF0ZXVybCI6Imljb24ifSAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgXX0gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIF0=";}  function org(){ return"c2VsZWN0IHJvd190b19qc29uKHMpIGZyb20NCiAgICAgICAgICAgICgNCiAgICAgICAgICAgIHNlbGVjdCAgdC5vcmcsdC5kZXNjcmlwdGlvbixhcnJheV90b19qc29uKGFycmF5X2FnZyhyb3dfdG9fanNvbih0KSkpIGFzIGNsaWVudA0KICAgICAgICAgICAgICAgICAgIGZyb20gDQogICAgICAgICAgICAgICAgICAgKHNlbGVjdCBhLm5hbWUgYXMgb3JnLHIubmFtZSxhLmRlc2NyaXB0aW9uICBmcm9tIGFkX29yZyBhDQogICAgICAgICAgICAgICAgICAgIGxlZnQgb3V0ZXIgam9pbiBhZF9jbGllbnQgciBvbiBhLmFkX29yZ19pZD1yLmFkX29yZ19pZA0KICAgICAgICAgICAgICAgICAgICAgICApIHQgICANCiAgICAgICAgICAgICAgICAgICAgICBncm91cCBieSAxLDINCiAgICAgICAgICAgICApIHM=";}  function info(){ return"YWRlbXBpZXJl";}  function user(){ return"PGZlbG1lbnU+PC9mZWxtZW51Pg0KDQo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCI+DQogICAgIDxsaW5rIHJlbD0ic3R5bGVzaGVldCIgaHJlZj0iLy9uZXRkbmEuYm9vdHN0cmFwY2RuLmNvbS90d2l0dGVyLWJvb3RzdHJhcC8yLjMuMi9jc3MvYm9vdHN0cmFwLWNvbWJpbmVkLm1pbi5jc3MiPg0KDQoNCjwvc2NyaXB0Pg0KPGRpdj4NCiAgPG1kLXZpcnR1YWwtcmVwZWF0LWNvbnRhaW5lciBpZD0idmVydGljYWwtY29udGFpbmVyIj4NCiAgICAgIDxkaXYgbWQtdmlydHVhbC1yZXBlYXQ9Iml0ZW0gaW4gcmVsYXRlZC5keW5hbWljSXRlbXMiIG1kLW9uLWRlbWFuZA0KICAgICAgICAgIGNsYXNzPSJyZXBlYXRlZC1pdGVtIiA+DQogICAgICAgIHt7aXRlbX19DQogICAgICA8L2Rpdj4NCiAgICA8L21kLXZpcnR1YWwtcmVwZWF0LWNvbnRhaW5lcj4gDQoNCg0KICA8ZGl2IGNsYXNzPSJtZC1wYWRkaW5nIiBsYXlvdXQ9InJvdyIgbGF5b3V0LXdyYXA+DQogICAgPGRpdiBsYXlvdXQ9InJvdyIgbGF5b3V0LXdyYXA+DQogICAgICA8ZGl2IGNsYXNzPSJwYXJlbnQiIGxheW91dD0iY29sdW1uIiBuZy1yZXBlYXQ9InVzZXIgaW4gcmVsYXRlZCIgZmxleD4NCiAgICAgICAgPG1kLWNhcmQ+DQogICAgICAgICAgPGltZyBzcmM9Imh0dHA6Ly9wbGFjZWhvbGQuaXQvMTUweDUwIiBjbGFzcz0ibWQtY2FyZC1pbWFnZSIgYWx0PSJ1c2VyIGF2YXRhciI+DQogICAgICAgICAgPG1kLWNhcmQtY29udGVudD4NCiAgICAgICAgICAgIDxoMj57e3VzZXIubmFtZX19PC9oMj4NCiAgICAgICAgICAgIDxwPg0KICAgICAgICAgICAgICANCiAgICAgICAgICAgICAgIDxsaT57e3VzZXIuZW1haWx9fTwvbGk+DQogICAgICAgICAgICAgICA8bGk+ZW1haWw6IHt7dXNlci5waG9uZX19PC9saT4NCg0KICAgICAgICAgICAgPC9wPg0KICAgICAgICAgIDwvbWQtY2FyZC1jb250ZW50Pg0KICAgICAgICAgIDxkaXYgY2xhc3M9Im1kLWFjdGlvbnMiIGxheW91dD0icm93IiBsYXlvdXQtYWxpZ249ImVuZCBjZW50ZXIiPg0KICAgICAgICAgICAgPG1kLWJ1dHRvbj5TYXZlPC9tZC1idXR0b24+DQogICAgICAgICAgICA8bWQtYnV0dG9uPlZpZXc8L21kLWJ1dHRvbj4NCiAgICAgICAgICA8L2Rpdj4NCiAgICAgICAgPC9tZC1jYXJkPg0KICAgICAgPC9kaXY+DQogICAgPC9kaXY+DQogIDwvZGl2Pg0KPC9kaXY+DQoNCg0KDQogICA=";}  function client(){ return"PGZlbG1lbnU+PC9mZWxtZW51Pg0KPG1kLWNhcmQ+DQo8bWQtY2FyZCBtZC10aGVtZT0iZGFyay1wdXJwbGUiPg0KICA8IS0tb2JqZWN0LS0+DQogIDxkaXYgY2xhc3M9Im1kLXRvb2xiYXItdG9vbHMiPg0KICAgIDxzcGFuPnt7dGl0bGV9fTwvc3Bhbj4NCiAgICB7e3JlbGF0ZWQuY291bnR9fQ0KICAgIA0KICA8L2Rpdj4NCjxtZC10YWJsZS1jb250YWluZXI+DQogIDx0YWJsZSBtZC10YWJsZSBtZC1yb3ctc2VsZWN0IG11bHRpcGxlIG5nLW1vZGVsPSJzZWxlY3RlZCIgbWQtcHJvZ3Jlc3M9InByb21pc2UiPg0KICAgIDx0aGVhZCBtZC1oZWFkIG1kLW9yZGVyPSJxdWVyeS5vcmRlciIgbWQtb24tcmVvcmRlcj0iZ2V0RGVzc2VydHMiPg0KICAgICAgPHRyIG1kLXJvdz4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1vcmRlci1ieT0ibmFtZVRvTG93ZXIiPjxzcGFuPmlkPC9zcGFuPjwvdGg+DQogICAgICAgIDx0aCBtZC1jb2x1bW4gbWQtbnVtZXJpYyBtZC1vcmRlci1ieT0iY2Fsb3JpZXMudmFsdWUiPjxzcGFuPm5hbWU8L3NwYW4+PC90aD4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1udW1lcmljPlZhbHVlPC90aD4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1udW1lcmljPkNsYXNzPC90aD4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1udW1lcmljPlByb3RlaW4gKGcpPC90aD4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1udW1lcmljPlNvZGl1bSAobWcpPC90aD4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1udW1lcmljPkNhbGNpdW0gKCUpPC90aD4NCiAgICAgICAgPHRoIG1kLWNvbHVtbiBtZC1udW1lcmljPklyb24gKCUpPC90aD4NCiAgICAgIDwvdHI+DQogICAgPC90aGVhZD4NCiAgICA8dGJvZHkgbWQtYm9keT4NCg0KICAgICAgPHRyIG1kLXJvdyBtZC1zZWxlY3Q9ImRlc3NlcnQiIG1kLXNlbGVjdC1pZD0ibmFtZSIgbWQtYXV0by1zZWxlY3QgbmctcmVwZWF0PSJkZXNzZXJ0IGluIHJlbGF0ZWQiPg0KICAgICAgICA8dGQgbWQtY2VsbD57e2Rlc3NlcnQuaWR9fTwvdGQ+DQogICAgICAgIDx0ZCBtZC1jZWxsPnt7ZGVzc2VydC5uYW1lfX08L3RkPg0KICAgICAgICA8dGQgbWQtY2VsbD57e2Rlc3NlcnQudmFsdWV9fTwvdGQ+DQogICAgICAgIDx0ZCBtZC1jZWxsPnt7ZGVzc2VydH19PC90ZD4NCiAgICAgICAgPHRkIG1kLWNlbGw+e3tkZXNzZXJ0LnByb3RlaW4udmFsdWUgfCBudW1iZXI6IDF9fTwvdGQ+DQogICAgICAgIDx0ZCBtZC1jZWxsPnt7ZGVzc2VydC5zb2RpdW0udmFsdWV9fTwvdGQ+DQogICAgICAgIDx0ZCBtZC1jZWxsPnt7ZGVzc2VydC5jYWxjaXVtLnZhbHVlfX17e2Rlc3NlcnQuY2FsY2l1bS51bml0fX08L3RkPg0KICAgICAgICA8dGQgbWQtY2VsbD57e2Rlc3NlcnQuaXJvbi52YWx1ZX19e3tkZXNzZXJ0Lmlyb24udW5pdH19PC90ZD4NCiAgICAgIDwvdHI+DQogICAgPC90Ym9keT4NCiAgPC90YWJsZT4NCjwvbWQtdGFibGUtY29udGFpbmVyPg0KDQo8bWQtdGFibGUtcGFnaW5hdGlvbiBtZC1saW1pdD0iNCIgbWQtbGltaXQtb3B0aW9ucz0iWzUsIDEwLCAxNV0iIG1kLXBhZ2U9IjQiIG1kLXRvdGFsPSJ7ezEwfX0iIG1kLW9uLXBhZ2luYXRlPSJnZXREZXNzZXJ0cyIgbWQtcGFnZS1zZWxlY3Q+PC9tZC10YWJsZS1wYWdpbmF0aW9uPg0KDQoNCiAgIDxtZC1jYXJkLWNvbnRlbnQ+DQoNCg0KPC9tZC1jYXJkPg0KDQoNCiAgIA==";}  function role(){ return"PGZlbG1lbnU+PC9mZWxtZW51Pg0Ke3t0aXRsZX19DQo8ZGl2Pg0KICA8ZGl2IGNsYXNzPSdtZC1wYWRkaW5nJyBsYXlvdXQ9InJvdyIgbGF5b3V0LXdyYXA+DQogICAgPGRpdiBsYXlvdXQ9InJvdyIgbGF5b3V0LXdyYXA+DQogICAgICA8ZGl2IGNsYXNzPSJwYXJlbnQiIGxheW91dD0iY29sdW1uIiBuZy1yZXBlYXQ9Iml0ZW0gaW4gcmVsYXRlZCIgZmxleD4NCiAgICAgICAgPG1kLWNhcmQ+DQogICAgICAgICAgPGltZyBzcmM9Imh0dHA6Ly9wbGFjZWhvbGQuaXQvMTUweDUwIiBjbGFzcz0ibWQtY2FyZC1pbWFnZSIgYWx0PSJ1c2VyIGF2YXRhciI+DQogICAgICAgICAgPG1kLWNhcmQtY29udGVudD4NCiAgICAgICAgICAgIDxoMj57e2l0ZW0ubmFtZX19PC9oMj4NCiAgICAgICAgICAgIDxwPkxvcmVtIGlwc3VtIGRvbG9yIHNpdCBhbWV0LCBjb25zZWN0ZXR1ciBhZGlwaXNjaW5nIGVsaXQsIHNlZCBkbyBlaXVzbW9kIHRlbXBvciBpbmNpZGlkdW50IHV0IGxhYm9yZSBldCBkb2xvcmUgbWFnbmEgYWxpcXVhDQogICAgICAgICAgICAgDQogICAgICAgICAgICA8L3A+DQogICAgICAgICAgPC9tZC1jYXJkLWNvbnRlbnQ+DQogICAgICAgICAgPGRpdiBjbGFzcz0ibWQtYWN0aW9ucyIgbGF5b3V0PSJyb3ciIGxheW91dC1hbGlnbj0iZW5kIGNlbnRlciI+DQogICAgICAgICAgICA8bWQtYnV0dG9uPlNhdmU8L21kLWJ1dHRvbj4NCiAgICAgICAgICAgIDxtZC1idXR0b24+VmlldzwvbWQtYnV0dG9uPg0KICAgICAgICAgIDwvZGl2Pg0KICAgICAgICA8L21kLWNhcmQ+DQogICAgICA8L2Rpdj4NCiAgICA8L2Rpdj4NCiAgPC9kaXY+DQo8L2Rpdj4NCg0KDQoNCiAgIA==";}  