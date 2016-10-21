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
         app.controller('ctrl',function($scope)

         {
         	<?php
         	   include "php/erp.php";
     $erp = new erp;
     $json=json_decode($erp->exec('window','window'),true);
               foreach ($json as $key => $value){
               	        foreach($value['field'] as $keye => $values)
               	        {
                           switch($values['refid']) {
                          	case '19':
                          	 echo '$scope'.'.'.$values['columnname'].' = [';
                        
                          	      foreach($values['select'] as $keyeee=>$valuess)
                                 {
                                 	echo '{name:"'.$valuess['name'].'"},';
                                 };  
                                 echo'{name:"eof"}';
               	       	     echo ']; ';
                          	break;
                                                    };
                        } ;                       
                          
               };
         	//  echo '$scope.adorg=[{name:"*"},{name:"store1"}];'
         	?>
         });
       
     </script>
</head>
<body ng-app="myApp" ng-controller="ctrl">
 
 <md-toolbar>

    <div class="md-toolbar-tools">
      <span>Adempiere Klonengan</span>



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
            <md-icon md-svg-src="../images/24px/ic_menu_black_36px.svg"></md-icon>
          </md-button>
        </md-fab-trigger>

        <md-fab-actions>
          <md-button aria-label="undo" class="md-fab md-raised md-mini">
            <md-icon md-svg-src="../images/24px/ic_undo_black_24px.svg" aria-label="undo"></md-icon>
            <md-tooltip md-direction="bottom">Undo</md-tooltip>

          </md-button>
          <md-button aria-label="Help" class="md-fab md-raised md-mini">
          <md-tooltip md-direction="bottom">Help</md-tooltip>

            <md-icon md-svg-src="../images/24px/ic_help_outline_black_36px.svg" aria-label="help"></md-icon>
          </md-button>

        <md-button aria-label="New" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_create_new_folder_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">new</md-tooltip>
        </md-button>
         
         <md-button aria-label="delete" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_delete_forever_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">delete</md-tooltip>
        </md-button>

         <md-button aria-label="refreh" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_refresh_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">refresh</md-tooltip>
        </md-button>

         <md-button aria-label="Search" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_search_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">search</md-tooltip>
        </md-button>

         <md-button aria-label="Attachment" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_attachment_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">Attachment</md-tooltip>
        </md-button>
        
          <md-button aria-label="Chat" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_chat_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">chat</md-tooltip>
        </md-button>

          <md-button aria-label="grid" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_grid_on_black_36px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">Grid</md-tooltip>
        </md-button>

          <md-button aria-label="history" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_history_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">History</md-tooltip>
        </md-button>
           <md-button aria-label="home" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_home_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">home</md-tooltip>
        </md-button>

              <md-button aria-label="prev" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_keyboard_arrow_left_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">prev</md-tooltip>
        </md-button>

              <md-button aria-label="home" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_keyboard_arrow_right_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">home</md-tooltip>
        </md-button>

                <md-button aria-label="home" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_keyboard_arrow_up_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">home</md-tooltip>
        </md-button>

                <md-button aria-label="home" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_keyboard_arrow_down_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">home</md-tooltip>
        </md-button>

                <md-button aria-label="home" class="md-fab md-raised md-mini">
        <md-icon md-svg-src="../images/24px/ic_print_black_24px.svg" aria-label="Google Hangout"></md-icon>
            <md-tooltip md-direction="bottom">print</md-tooltip>
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
           	        	     echo'<md-tooltip md-direction="top">'.$reference
                             .$values['refid']
                             ."column:"
                             .$values['columnname']
           	        	     .'</md-tooltip>';
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
           	        	     	case 'Table Direct':
           	        	     	        echo '
           	        	     	       <label>'.$values['name'].'</label>
           	        	     	       
            <md-select ng-model="'.$values['columnname'].'">
              <md-option ng-repeat="state in '.$values['columnname'].'" value="{{'.$values['columnname'].'.value}}">
                {{state.name}}
              </md-option>
            </md-select>';
           	        	     	      echo '
           	        	     	      <a href="/index.php/tabledirect/">'
           	        	     	      .$values['name']
           	        	     	      .
           	        	     	      '</a>';
           	        	     	      echo $values['select'];
                                      
           	        	     	      
           	        	     	      break;     
           	        	     	default:
           	        	     	    
           	                // echo "<label>".$values['name']."</label>";
           	                 echo "<label>".$values['name']."</label>";
           	                  echo "<input></>";
           	                
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