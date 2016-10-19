<!DOCTYPE html>
<html lang="en" >
<head>
	<title></title>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
   
   <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
   <script src="js/angular-material.min.js"></script>
 <script src="js/angular-material.min.js"></script>
  <!-- Angular Material Library -->
    <script src="../lib/angular-ui-router.js"></script>
    <script src="../lib/dirPagination.js"></script>
    <script type="text/ng-template" id="/te.php">
            <h4>Inline Template</h4>
            <ul>
            <?php
                 echo "from php";
                 echo "<br> memory";
echo memory_get_peak_usage();
echo "<br>";
//echo var_dump($erp->loadobj());
//$erp->initObj();
// echo var_dump($erp->db);
echo "--------------------------------";
echo "<br>";
            ?>
            <li ng-repeat="value in related">
                {{value.name}}
        
            </li>
            
            </ul>
    </script>

    <script type="text/ng-template" id="/ad_window.php">
            <h4>Inline Template</h4>
            <ul>
            <?php
                 echo "Ad_Window";
            ?>
            <pre>
            Window merupakan Container Untuk Tab , didalam
            tab terdapat field didalan field
            dibagi dengan reference yang salahsatunya adalah column
             terdapat column
            </pre>
            <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Go!</button>
      </span>
    </div>
            <li ng-repeat="value in related | limitTo:10">
                <a href="">{{value.name}}</a>
        
            </li>
            
            </ul>
    </script>

    <script type="text/ng-template" id="/ad_field.php">
            <h4>Inline Template</h4>
            <ul>
            <?php
                 echo "ad_field";
            ?>
            <pre>
             Field merupkan container untul table-direc
            </pre>
            <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Go!</button>
      </span>
    </div>
            <li ng-repeat="value in related | limitTo:10">
                <a href="">{{value.name}}</a>
        
            </li>
            
            </ul>
    </script>
    
     <script type="text/ng-template" id="template.php">
            <h4>Inline Template</h4>
            <ul>
            <?php
                 echo "from php";
            ?>
            {{title}}
state parameter  {{id}}
<ul class="tree" ng-repeat="item in related | limitTo:6 " id="tree">
         
    <li>
    {{item.name}}
    <a ui-sref="ad_tab({id:89})">{{item.name}}</a></li>
            <table>
            <ul class="last" ng-repeat="x in item.field">
                    
                 <li class="file"> {{x.name}} {{x.columnname}}</li>
                 
            </ul>
             </table>
</li>
            
            </ul>
    </script>
    <script>
       var app = angular.module('myApp', ['ngMaterial','ui.router']);
       app.config(function($stateProvider,$urlRouterProvider)
        {
        	$urlRouterProvider.otherwise('/tab/dash');
    
        	$stateProvider
        	
        	.state('home',{url:"/"})
        	.state('ad_tab',{
                     controller:"adtab",
        		     url:"/ad_tab/:id",
        		     templateUrl:"template.php"})
        	.state('ad_table',{
                     controller:"adtable",
                     url:"/ad_table/:id",
                     templateUrl:"template/ad_table.php"})    
            .state('ad_field',{
                     controller:"adfield",
                     url:"/ad_field/:id",
                     templateUrl:"/ad_field.php"}) 
            .state('ad_reference',{
                     controller:"adreference",
                     url:"/ad_reference/:id",
                     templateUrl:"template/ad_reference.php"})   

        	.state('ad_window',{
        		     url:"/ad_window",
        		     templateUrl:"/ad_window.php",
        		     controller:"myCtrl"})
            .state('window',{
                     url:"/window",
                     templateUrl:"template/window.php",
                     controller:"window"})

        });
       app.controller('myCtrl', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_window").then(function(response) {
       	$scope.id = $stateParams.id;

        $scope.related = response.data;});});
         app.controller('adtab', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_tab/"+$stateParams.id).then(function(response) {
        $scope.id = $stateParams.id;
        $scope.title ='tab';
        $scope.related = response.data;});});

         app.controller('adreference', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_reference/"+$stateParams.id).then(function(response) {
        $scope.id = $stateParams.id;
        $scope.title ='Reference';
        $scope.related = response.data;});}); 
       
          app.controller('window', function($scope, $http,$stateParams) 
       {$http.get("index.php/window/"+$stateParams.id).then(function(response) {
        $scope.id = $stateParams.id;
        $scope.title ='Reference';
        $scope.related = response.data;});}); 
        
        app.controller('adtable', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_table/"+$stateParams.id).then(function(response) {
        $scope.id = $stateParams.id;
        $scope.title ='tab';
        $scope.related = response.data;});});

        
        
        
          
    </script>
   
</head>
<body ng-app="myApp">
<?php
echo var_dump($_SERVER['PATH_INFO']);
?>
<a ng-click="currentTpl='templateUrl.html'" id="tpl-link">Load inlined template</a>
<div id="tpl-content" ng-include src="currentTpl"></div>




<ol class="breadcrumb">
<a class="breadcrumb-item" ui-sref="ad_window">Window</a>
<a class="breadcrumb-item" ui-sref="ad_tab">Tab</a>
<a class="breadcrumb-item" ui-sref="ad_field">Field</a>
<a class="breadcrumb-item" ui-sref="ad_table" ui-sref-active="active">Table</a>
<a class="breadcrumb-item" ui-sref="ad_reference">Reference</a>
<a class="breadcrumb-item" ui-sref="window"  ui-sref-active="active">window</a>

<a class="breadcrumb-item" href="php/adminer.php" ui-sref-active="active">Adminer</a>
<a class="breadcrumb-item" ui-sref="ad_tab({id:100})">Tab with parameter</a>

<a class="breadcrumb-item" ui-sref="ad_tab/:party" ui-sref-active="active">Tab with parameter</a>
<a class="breadcrumb-item" ui-sref="ad_tab({id:'party'})">Tab with parameter</a>
</ol>

<div ui-view></div>






<?php
include '../services/erp.php';
ini_set('memory_limit','16M');
$erp=new erp;

//echo $erp->exec('ad_window');
?>
</body>
</html>


