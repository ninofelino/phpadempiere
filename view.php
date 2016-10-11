<?php
 // echo $_SERVER['PATH_INFO'];
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
  case "table":
        
        //printf ("--[ Current Memory Limit: %s\n\n", ini_get('memory_limit'));
 

        echo
        '
        <md-grid-list
        md-cols-xs="1" md-cols-sm="2" md-cols-md="4" md-cols-gt-md="6"
        md-row-height-gt-md="1:1" md-row-height="2:2"
        md-gutter="12px" md-gutter-gt-sm="8px" >
             <md-grid-tile class="gray"
        md-rowspan="3" md-colspan="4" md-colspan-sm="1" md-colspan-xs="1">
      <md-grid-tile-footer>
        <h3>#1: (3r x 2c)</h3>
      </md-grid-tile-footer>
    </md-grid-tile>
            
         <md-content><felmenu></felmenu></md-content>
        <md-card  class="md-warn" style="border-radius: 3px 3px 0 0">
                      
            <md-card-content layout-padding>
                  <div ng-repeat="item in related | limitTo: 25 ">
                  <a sf-ref="sql/select * from {{item.tablename}} limit 25" >{{item.name}}</a>
            </div> 
            </md-card-content>
                  <cl-paging flex cl-pages="paging.total" cl-steps="6" cl-page-changed="paging.onPageChanged()" cl-align="start start" cl-current-page="paging.current"></cl-paging>
            <div>
                <md-button><md-svg-icon="lib/next.svg"></md-svg-icon>P</md-button>
                <md-button>Prev</md-button>
         <md-button>Prev</md-button>
         <md-button>Prev</md-button>
         </div>
        
           
         
         </md-card>
        
        ';

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
	case "user" :
	      echo '<h4>{{title}}</h4>
                <wan-material-paging wmp-total="total" goto-page="gotoPage()" position="center" current-page="currentPage" step="step">
    </wan-material-paging>
            <md-content class="md-padding" layout-xs="column" layout="row">
           
            <div layout="row" layout-wrap>
            <div flex="30" ng-repeat="item in related">
                 {{item.name}}
       
            </div>
            </div>
            </md-content>'
	      ;
	      break;     
  case "clientkk" :
        echo "kkkk";
        break;

	case "client" :
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
    
    echo file_get_contents($filename, FILE_USE_INCLUDE_PATH);
} else {
    echo "The file $filename does not exist";
    echo '<std></std>'  ;
     copy('directive/default.html',$filename);
}
            
             break;    
  }	      


