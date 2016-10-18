<!DOCTYPE html>
<html ng-app="myApp">
<head>
	<title></title>
    <script src="../lib/angular.min.js"></script>
    <script src="../lib/angular-ui-router.js"></script>
    <script src="../lib/dirPagination.js"></script>
    <script type="text/ng-template" id="/te.php">
            <h4>Inline Template</h4>
            <ul>
            <?php
                 echo "from php";
            ?>
            <li ng-repeat="value in related">
                {{value.name}}
        
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
       var app = angular.module('myApp', ['ui.router','angularUtils.directives.dirPagination']);
       app.config(function($stateProvider,$urlRouterProvider)
        {
        	$urlRouterProvider.otherwise('/home/ad_window/');
    
        	$stateProvider
        	
        	.state('home',{url:"/"})
        	.state('ad_tab',{
                     controller:"adtab",
        		     url:"/ad_tab/:id",
        		     templateUrl:"template.php"})
        	.state('ad_table',{
                     controller:"adtable",
        		     url:"/ad_table/:id",
        		     templateUrl:"/te.php"})	   
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
       {$http.get("index.php/ad_tab/"+$stateParams.id).then(function(response) {
        $scope.id = $stateParams.id;
        $scope.title ='tab';
        $scope.related = response.data;});});
        
        app.controller('adtable', function($scope, $http,$stateParams) 
       {$http.get("index.php/ad_table/"+$stateParams.id).then(function(response) {
        $scope.id = $stateParams.id;
        $scope.title ='tab';
        $scope.related = response.data;});});

    </script>
    <style type="text/css">
ul.tree, ul.tree ul {
     list-style-type: none;
   }

   ul.tree, ul.tree ul {
     list-style-type: none;
     background: url(vline.png) repeat-y;
     margin: 0;
     padding: 0;
   }
   
   ul.tree ul {
     margin-left: 10px;
   }

   ul.tree li {
     margin: 0;
     padding: 0 12px;
   }
   ul.tree, ul.tree ul {
     list-style-type: none;
     background: url(vline.png) repeat-y;
     margin: 0;
     padding: 0;
   }
   
   ul.tree ul {
     margin-left: 10px;
   }

   ul.tree li {
     margin: 0;
     padding: 0 12px;
     line-height: 20px;
     background: url(node.png) no-repeat;
     color: #369;
     font-weight: bold;

   ul.tree, ul.tree ul {
     list-style-type: none;
     background: url(vline.png) repeat-y;
     margin: 0;
     padding: 0;
   }
   
   ul.tree ul {
     margin-left: 10px;
   }

   ul.tree li {
     margin: 0;
     padding: 0 12px;
     line-height: 20px;
     background: url(node.png) no-repeat;
     color: #369;
     font-weight: bold;
   }

   ul.tree li.last {
     background: #fff url(lastnode.png) no-repeat;
   }

   }
</style>

</head>
<body ng-app="myApp">
<?php
echo var_dump($_SERVER['PATH_INFO']);
?>
<a ng-click="currentTpl='templateUrl.html'" id="tpl-link">Load inlined template</a>
<div id="tpl-content" ng-include src="currentTpl"></div>
<a ui-sref="ad_tab">Tab</a>
<a ui-sref="ad_window">Window</a>
<a ui-sref="ad_tab">Field</a>
<a ui-sref="ad_table" ui-sref-active="active">Table</a>
<a ui-sref="ad_tab({id:100})">Tab with parameter</a>
<a ui-sref="ad_tab/:party" ui-sref-active="active">Tab with parameter</a>
<a ui-sref="ad_tab({id:'party'})">Tab with parameter</a>


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


