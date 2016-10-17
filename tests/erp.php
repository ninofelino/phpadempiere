<!DOCTYPE html>
<html>
<head>
	<title></title>
    <script src="../lib/angular.min.js"></script>
    <script src="../lib/angular-ui-router.js"></script>

    <script>
       var app = angular.module('myApp', ['ui.router']);
       app.config(function($stateProvider,$urlRouterProvider)
        {
        	$urlRouterProvider.otherwise('/home/ad_window/');
    
        	$stateProvider
        	
        	.state('home',{url:"/"})
        	.state('ad_tab',{
                     controller:"adtab",
        		     url:"/ad_tab",
        		     templateUrl:"template.php"})
        		   
        	.state('ad_window',{
        		     url:"/ad_window",
        		     templateUrl:"template.php",
        		     controller:"myCtrl"})

        });
       app.controller('myCtrl', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_window").then(function(response) {
       	$scope.id = $stateParams.id;

        $scope.related = response.data;});});
        app.controller('adtab', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_tab").then(function(response) {
        $scope.id = $stateParams.id;

        $scope.related = response.data;});});


    </script>


</head>
<body ng-app="myApp">
<?php
echo var_dump($_SERVER['PATH_INFO']);
?>
<a ui-sref="ad_tab">Tab</a>
<a ui-sref="ad_window">Window</a>
<a ui-sref="ad_tab">Field</a>
<a ui-sref="ad_tab({id:100})">Tab with parameter</a>
<a ui-sref="ad_tab/:party" ui-sref-active="active">Tab with parameter</a>
<a ui-sref="ad_tab({id:party})">Tab with parameter</a>


<div ui-view></div>






<?php
include '../services/erp.php';
ini_set('memory_limit','16M');
$erp=new erp;
echo "<br> memory";
echo memory_get_peak_usage();
echo "<br>";
//echo var_dump($erp->loadobj());
//$erp->initObj();
// echo var_dump($erp->db);
echo "--------------------------------";
echo "<br>";
//echo $erp->exec('ad_window');
?>
</body>
</html>


