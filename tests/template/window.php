 


 <md-content flex layout-padding>

<div ng-repeat="item in related">
<md-card >
        <md-card-title>
          <md-card-title-text>
            <span class="md-headline">{{item.name}}</span>
        
          </md-card-title-text>
          </md-card-title>  
          
          <md-card-title-media layout="row" > 
            <md-grid layout-fill flex
    md-cols-sm="1"
    md-cols-md="2"
    md-cols-gt-md="2"
    md-row-height-sm="100%"
    md-row-height="600px"
    md-gutter="8px">   
                 <div ng-repeat="x in item.field" >
          
               <md-input-container>
                 <label>{{x.name}}<small>{{x.reference}}</small></label>
                 <input ng-model="user.title">
               </md-input-container>
                
                <md-datepicker ng-if="x.reference=='Date'"  ng-model="birthday"></md-datepicker>

                 <md-input-container ng-if="x.reference=='Date'">
                     <md-calendar>{{x.name}}</md-calendar>
                  
                </md-input-container>  

                <md-input-container ng-if="x.reference=='Button'">
                     <md-button class="md-primary">{{x.name}}</md-button>
                  
                </md-input-container>     
              
            <md-input-container ng-if="x.reference=='Yes-No">
                     <md-calendar>{{x.name}}</md-calendar>
                  
                </md-input-container>     
                  </div>
           </md-grid>

          </md-card-title-media>
          
        <md-card-actions layout="row" layout-align="end center">
          <md-button>Action 1</md-button>
          <md-button>Action 2</md-button>
        </md-card-actions>
</md-card>
</div>

</md-content>