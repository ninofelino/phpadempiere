<!DOCTYPE html>
<html>
<head>
	<title>Entry From</title>
	 <link rel="stylesheet" href="css/angular-material.min.css">
	 <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.csrs">
     <script src="js/angular.min.js"></script>
     <script src="js/angular-animate.min.js"></script>
     <script src="js/angular-aria.min.js"></script>
     <script src="js/angular-material.min.js"></script>
     
  <!-- Angular Material Library -->
     <script src="js/angular-ui-router.js"></script>
     <script src="js/dirPagination.js"></script>
     <script>
            var app = angular.module('myApp', ['ngMaterial','ui.router']);
       app.config(function($stateProvider,$urlRouterProvider)
        {
        	$urlRouterProvider.otherwise('/tab/dash');
	     }	);
     <?php
     // create angular controller;
     // get model
     // ini_set("allow_url_fopen", 1);
    // $json=file_get_contents("index.php/window")
 include "php/erp.php";
     $erp = new erp;
     $json=json_decode($erp->exec('window','window'),true);
     ?>
        
     </script>
</head>
<body ng-app="myApp">
 
 <md-toolbar>

    <div class="md-toolbar-tools">
      <span>Adempiere Klonengan</span>
<md-button class="md-fab-toolbar" aria-label="undo">
     <img class="png-icon" src="../images/24px/Undo24.png"></img>
     <md-tooltip md-direction="bottom">Undo</md-tooltip>
</md-button>
      <md-button href="../services/adminer.php" class="md-fab-toolbar" aria-label="Help"><img class="png-icon" src="../images/24px/help24.png"></md-button>
      <md-button aria-label="New"><img src="../images/24px/new24.png"></md-button>
<md-button class="md-fab-toolbar" aria-label="Delete">
    <md-icon md-svg-src="../images/24px/delete24.svg"></md-icon>

</md-button>
<md-button aria-label="D multiple"><img src="../images/24px/help24.png"></md-button>
<md-button aria-label="Refresh"><img src="../images/24px/refresh24.png"></md-button>
<md-button aria-label="Search"><img src="../images/24px/Zoom24.png"></md-button>
<md-button aria-label="Attachment"><img src="../images/24px/Attachment24.png"></md-button>



      <!-- fill up the space between left and right area -->
      <span flex></span>

      <md-button>
        Right Bar Button
      </md-button>
    </div>

  </md-toolbar>
<div class="lock-size" layout="row" layout-align="left center">
      <md-fab-speed-dial md-open="true" md-direction="{{demo.selectedDirection}}"
                         ng-class="demo.selectedMode">
        <md-fab-trigger>
          <md-button aria-label="menu" class="md-fab md-warn">
            <md-icon md-svg-src="img/icons/menu.svg"></md-icon>
          </md-button>
        </md-fab-trigger>

        <md-fab-actions>
          <md-button aria-label="undo" class="md-fab md-raised md-mini">
            <md-icon md-svg-src="../images/24px/undo24.svg" aria-label="undo"></md-icon>
            <md-tooltip md-direction="bottom">Undo</md-tooltip>

          </md-button>
          <md-button aria-label="Help" class="md-fab md-raised md-mini">
          <md-tooltip md-direction="bottom">Help</md-tooltip>

            <md-icon md-svg-src="../images/24px/help24.svg" aria-label="help"></md-icon>
          </md-button>

        <md-button aria-label="New" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="img/icons/hangout.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">new</md-tooltip>
        </md-button>
         
         <md-button aria-label="delete" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="img/icons/hangout.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">delete</md-tooltip>
        </md-button>

         <md-button aria-label="refreh" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="img/icons/hangout.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">refresh</md-tooltip>
        </md-button>

         <md-button aria-label="Search" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="img/icons/hangout.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">search</md-tooltip>
        </md-button>

         <md-button aria-label="New" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="img/icons/hangout.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">new</md-tooltip>
        </md-button>


        </md-fab-actions>
      </md-fab-speed-dial>
    </div>


 <md-content>
     
    <md-tabs md-dynamic-height md-border-bottom>
      
              <?php 
    
    //echo "2".$json[0]['window'];
           foreach ($json as $key => $value) {
           	        echo "<md-tab label='".$value['name']."'/>";
           	        echo '<md-content>';
           	        foreach ($value['field'] as $keye => $values) {
           	        	     $reference=$values['reference'];
           	        	     echo '<md-input-container style="width:30%">';
           	        	     echo'<md-tooltip>'.$reference.'</md-tooltip>';
           	        	     switch ($reference) {
           	        	     	case 'Date':
           	        	     	 echo "<label>".$values['name']."</label>";
           	                
           	        	     	      echo '<md-datepicker ng-model="birthday"></md-datepicker>';
           	        	     		# code...
           	        	     		break;
           	        	        case 'Yes-No':
           	  echo '<md-checkbox ng-model="isChecked" aria-label="Finished?">';
              echo $values['name'];
              echo '</md-checkbox>';
           	        	            break; 	
           	        	        case "List" :
                                  echo  '<label>'.$values['name'].'</label>
  <md-select ng-model="someModel">
    <md-option ng-value="opt" ng-repeat="opt in neighborhoods2">{{ opt }}</md-option>
  </md-select>';

           	        	              break;    	
           	        	     	case 'Button':
           	        	     	      echo '<md-button>'.$values['name'].'</md-button>';
           	        	     	     break;
           	        	     	default:
           	        	     	    
           	                // echo "<label>".$values['name']."</label>";
           	                 echo "<labe l>".$values['name']."</label>";
           	                  echo "<input value='".$values['reference']."'></>";
           	                
           	        	     		# code...
           	        	     		break;
           	        	     }
           	        	    echo "</md-input-container>";
           	        }
           	        echo "<md-content>";
           	        echo "</md-tab>";
           }
     ?>
       
      </md-tab>
      
     
    </md-tabs>
  </md-content>


   
</body>
</html>