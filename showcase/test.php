<?php
// https://www.functions-online.com/json_decode.html
require_once("services/SDatabase.inc.php");

// url harus uniq
$jsoon = '[
  {"url":"Administration","icon":"x.svg","dataSource":"select * from ad_menu","templateurl":[
  {"url":"Organization","icon":"org.svg","templateurl":"org","datasource":"services/adempiere.php/ad_org"},
  {"url":"Client","icon":"client.svg","templateurl":"client","datasource":"index.php/sql/select * from ad_client"},
  {"url":"Roles","icon":"user.svg","templateurl":"role","datasource":"index.php/sql/select * from ad_role"},
  {"url":"User","icon":"user.svg","templateurl":"user","datasource":"services/adempiere.php/ad_user"}
                                                                  
                                   ]},
                     {"url":"Window","icon":"window.svg","templateurl":[
      {"url":"tab","icon":"window.svg","templateurl":"tab","datasource":"services/adempiere.php/tab"},
                       {"url":"table","icon":"table.svg","templateurl":"table"},
                       {"url":"Reference","icon":"window.svg","templateurl":"ad_reference"},
                       {"url":"view","icon":"view.svg","templateurl":"view"},
                       {"url":"window","icon":"window.svg","templateurl":"window"}
                       
                       

                      ]},
         {"url":"Sql","icon":"sql.svg","templateurl":[
                     {"url":"prodict","icon":"product.svg","templateurl":"product1"},
                     {"url":"Bussiness","icon":"bpartner.svg","templateurl":"produc5t"},
                     {"url":"product","templateurl":"product"}
                                   ]}
   
                   

                      
                     ]

';


$json=file_get_contents('menu.json', FILE_USE_INCLUDE_PATH);
$resul = json_decode ($jsoon);
 $db = new SDatabase('services/adempiere.json'); // Open database
  $db->data["menu"]=preg_replace('/(\v|\s)+/', ' ', trim($jsoon));
// $json=file_get_contents('services/adempiere.php/db/menu');
 // echo $jsoon;

// echo var_dump($resul);

function state($resu)
{
$hs="";  
$x=0;
foreach ($resu as $hasil) {
      //    echo "<br>";
        $ar=$hasil->templateurl;
        $x=$x+1;
        // $hs .=$hasil->url;
        // ---------------------
        $nama=$hasil->templateurl;
        if (is_array($ar)) { $nama="arr".$x;}
        $hs .=".state('".$nama."',{templateUrl:'view.php/".$ar."',controller: function(@scope,@http,@stateParams,@timeout) {@scope.title=''; @http.get('".$hasil->datasource."').then(function(response){ @scope.related = response.data; });}}) " ;
   //     $hs .="<br>";      
   
         if (is_array($ar)) { $hs.=state($ar);}
        }
return str_replace("@","$", $hs);
}


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
echo str_replace('@','$',$js);
?>



