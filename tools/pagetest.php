<!DOCTYPE html>

<html>
<head>
<title>ninofelino</title>
<link rel="stylesheet" href="index.php/style/angular-material.css">
<script src="index.php/libs/angular.min.js"></script>
<script src="index.php/libs/angular-animate.min.js"></script>
<script src="index.php/libs/angular-aria.min.js"></script>
<script src="index.php/libs/angular-material.min.js"></script>
<link rel="stylesheet" href="index.php/style/icon.css">
<link rel="stylesheet" href="index.php/style/angular-material.min.css">
<script src="index.php/libs/angular-ui-router.js"></script>
<script src="index.php/libs/angular-resource.min.js"></script>
<script src="index.php/libs/angular-material-icons.min.js"></script>
<script src="index.php/libs/dirPagination.js"></script>

<script src="index.php/libs/dist.min.js"></script>
<script src="index.php/core"></script>

<script src="index.php/libs/holder.js"></script>
<script src="index.php/libs/aholder.js"></script>
<script src="index.php/libs/angular-material-paging.js"></script>
<link rel="stylesheet" href="index.php/libs/angular-material-paging.css">

<link href="index.php/style/md-data-table.css" rel="stylesheet" type="text/css"/>
<!-- module -->
<script type="text/javascript" src="lib/md-data-table.js"></script>


</head>




<body>

<div ng-app="demoApp">

<div ng-controller="AppCtrl">
    <div ng-app="app" ng-controller="AppCtrl">
  <div layout="row">

  <sidenavigator></sidenavigator>

  
        
<!-- content template -->    
       
    
       <div id="content" ui-view>
       
       <felmenu></felmenu>
     
      <md-progress-linear md-mode="indeterminate"></md-progress-linear>

      <md-progress-circular md-mode="indeterminate"></md-progress-circular>
    

       </div>
       
    
  </div>
</div>
</div>

</body>
</html>
