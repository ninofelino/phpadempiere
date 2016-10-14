<!DOCTYPE html>

<html>
<head>
<title>ninofelino</title>
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
<script src="lib/dist.min.js"></script>
<script src="core"></script>

<script src="lib/holder.js"></script>
<script src="lib/aholder.js"></script>
<script src="lib/angular-material-paging.js"></script>
<link rel="stylesheet" href="lib/angular-material-paging.css">

<link href="lib/md-data-table.css" rel="stylesheet" type="text/css"/>
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
