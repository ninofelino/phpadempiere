<felmenu></felmenu>
{{title}}
<div>
  <div class='md-padding' layout="row" layout-wrap>
    <div layout="row" layout-wrap>
      <div class="parent" layout="column" ng-repeat="item in related" flex>
        <md-card>
          <img src="http://placehold.it/150x50" class="md-card-image" alt="user avatar">
          <md-card-content>
            <h2>{{item.name}}</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
             
            </p>
          </md-card-content>
          <div class="md-actions" layout="row" layout-align="end center">
            <md-button>Save</md-button>
            <md-button>View</md-button>
          </div>
        </md-card>
      </div>
    </div>
  </div>
</div>



   