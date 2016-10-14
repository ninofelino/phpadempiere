<?php
 // echo $_SERVER['PATH_INFO'];
require_once("services/SDatabase.inc.php");
     $db = new SDatabase('services/adempiere.json'); // Open database
  
  function ui($angular)
  {
  	$template ='<md-content class="md-padding" layout-xs="column" layout="row">';
  	$template .='<div layout="row" layout-wrap>';
  	$template .='<div flex="30" ng-repeat="item in related">';
    $template .='<md-card class="md-primary">';
  	$template .= $angular;
    $template .= '</md-card';
  	$template .='</div>';
  	$template .='</div>';
  	$template .='</md-content>';

  	return $template ;
  }

  function ui_head()
  {
  	$template ='
    
    <link rel="stylesheet" href="lib/angular-material.css">
    <script src="lib/angular.min.js"></script>
    <script src="lib/angular-animate.min.js"></script>
    <script src="lib/angular-aria.min.js"></script>
    <script src="lib/angular-material.min.js"></script>
    <link rel="stylesheet" href="lib/icon.css">
    <link rel="stylesheet" href="lib/angular-material.min.css">
    <script src="lib/angular-ui-router.js"></script>
    <script src="lib/angular-resource.min.js"></script>
    <script src="lib/angular-material-icons.min.js"></script>
    <style>
           .card-media {
  background-color: #999999; }
    </style>
    '
  	;
  	return $template;

  }



  $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
 
  switch($request[0]) {
  case "other":
        break;   
  
        
  case "roley" :
        echo '
        <style>
.virtualRepeatdemoDeferredLoading #vertical-container {
  height: 292px;
  width: 100%;
  max-width: 400px; }

.virtualRepeatdemoDeferredLoading .repeated-item {
  border-bottom: 1px solid #ddd;
  box-sizing: border-box;
  height: 40px;
  padding-top: 10px; }

.virtualRepeatdemoDeferredLoading md-content {
  margin: 16px; }

.virtualRepeatdemoDeferredLoading md-virtual-repeat-container {
  border: solid 1px grey; }

.virtualRepeatdemoDeferredLoading .md-virtual-repeat-container .md-virtual-repeat-offsetter div {
  padding-left: 16px; }

        </style>
        role{{related}}
        <md-virtual-repeat-container id="vertical-container">
      <div md-virtual-repeat="item in related" md-on-demand
          class="repeated-item" flex>
        {{item}}
      </div>
    </md-card>
        ';
        break;
	   
  case "clientkk" :
        echo "kkkk";
        break;

	case "clienit" :
         $js="<script>
            angular.module('demoApp').controller('Ctrl1', ['@scope', '@http', function(@scope, @http){
            @scope.test='hello';
}]);
         </script>";
  echo  ' client <felmenu>jjj</felmenu>
yyyyyyyyyyyyyyyyyyyyyyyy
 <section layout="row" layout-padding="">
        <cl-paging flex cl-pages="paging.total" , cl-steps="6" , cl-page-changed="paging.onPageChanged()" ,
                   cl-align="start start" , cl-current-page="paging.current"></cl-paging>

    </section>
  ';

          echo '
          
  <md-content class="md-padding" layout-xs="column" layout="row">
           
            <div layout="row" layout-wrap>
            <div flex="30" ng-repeat="item in related">
                 {{item.name}}
       
            </div>
            </div>
            </md-content></div>'
           
	      ;
	      break;     
   default : 
             $filename='directive/template/'.$request[0].'.html';
             if (file_exists($filename)) {
             $isifile=file_get_contents($filename, FILE_USE_INCLUDE_PATH);
             $db->data[$request[0]]=$isifile;
             $db->save();
             echo $db->data[$request[0]];
             } else {
             echo "The file $filename does not exist";
             echo '<std></std>'  ;
             copy('directive/default.html',$filename);
             }
            
             break;    
  }	      


