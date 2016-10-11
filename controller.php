<?php

function state($name,$url,$templateUrl,$controller,$datasource)
{
  $control="
      .state('".$name."',{templateUrl:'".$templateUrl."',controller: function(@scope,@http,@stateParams,@timeout)
          {@scope.title='".$name."';
           @http.get('".$datasource."').then(function(response){ @scope.related = response.data; }); 
        
           var DynamicItems = function() {
          /**
           * @type {!Object<?Array>} Data pages, keyed by page number (0-index).
           */
          this.loadedPages = {};

          /** @type {number} Total number of items. */
          this.numItems = 0;

          /** @const {number} Number of items to fetch per request. */
          this.PAGE_SIZE = 50;

          this.fetchNumItems_();
        };

        // Required.
        DynamicItems.prototype.getItemAtIndex = function(index) {
          var pageNumber = Math.floor(index / this.PAGE_SIZE);
          var page = this.loadedPages[pageNumber];

          if (page) {
            return page[index % this.PAGE_SIZE];
          } else if (page !== null) {
            this.fetchPage_(pageNumber);
          }
        };

        // Required.
        DynamicItems.prototype.getLength = function() {
          return this.numItems;
        };

        DynamicItems.prototype.fetchPage_ = function(pageNumber) {
          // Set the page to null so we know it is already being fetched.
          this.loadedPages[pageNumber] = null;

          // For demo purposes, we simulate loading more items with a timed
          // promise. In real code, this function would likely contain an
          // $http request.
          @timeout(angular.noop, 300).then(angular.bind(this, function() {
            this.loadedPages[pageNumber] = [];
            var pageOffset = pageNumber * this.PAGE_SIZE;
            for (var i = pageOffset; i < pageOffset + this.PAGE_SIZE; i++) {
              this.loadedPages[pageNumber].push(i);
            }
          }));
        };

        DynamicItems.prototype.fetchNumItems_ = function() {
          // For demo purposes, we simulate loading the item count with a timed
          // promise. In real code, this function would likely contain an
          // $http request.
          @timeout(angular.noop, 300).then(angular.bind(this, function() {
            this.numItems = 50000;
          }));
        };

        this.dynamicItems = new DynamicItems();
        
               
          }
    }) ";
  return str_replace('@','$', $control);
}


$js = "
var app=angular.module('demoApp', ['ngMaterial','ui.router','ngResource','md.data.table'])
.config(function(@mdThemingProvider) {
  @mdThemingProvider.theme('default')
    .primaryPalette('pink')
    .accentPalette('purple');
})
.config(function(@stateProvider,@urlRouterProvider){@stateProvider"
// app.registerCtrl = $controllerProvider.register;
.state("org","admin/login.html","view.php/org","controller","index.php/sql/select * from ad_org")
.state("user","admin/login.html","view.php/user","controller","sql/select * from ad_user")
.state("table","admin/login.html","view.php/table","controller","sql/select * from ad_table limit 10")
.state("tab","admin/login.html","view.php/tab","controller","sql/select ad_tab_id as id,name from ad_tab order by ad_window_id")
.state("client","admin/login.html","view.php/client","controller","sql/select * from ad_client")
.state("role","admin/login.html","view.php/role","controller","sql/select * from ad_role")
.state("ad_reference","admin/login.html","view.php/ref","controller","sql/select * from ad_reference limit 10")

.""
.
" })
.controller('AppCtrl',
function(@scope,@mdSidenav,@http,@mdDialog){
    
     @scope.toggleSidenav = function () {
     @mdSidenav('nav').toggle();
  };
 @scope.showAlert = function(ev) {
    // Appending dialog to document.body to cover sidenav in docs app
    // Modal dialogs should fully cover application
    // to prevent interaction outside of dialog
    @mdDialog.show(
        @mdDialog.alert()
        .parent(angular.element(document.querySelector('#popupContainer')))
        .clickOutsideToClose(true)
        .title('This is an alert title')
        .textContent('You can specify some description text in here.')
        .ariaLabel('Alert Dialog Demo')
        .ok('Got it!')
        .targetEvent(ev)

    )
  };
   
      @http.get('models.php')
            .then(function(response){ @scope.related = response.data; });
          
     
   });
   //app.controller('baru',function(@scope){@scope.title='baru'}).@inject = ['@scope', 'notify'];;
   app.controller('baru',function(@scope){@scope.title='baru'}).@inject = ['@scope', 'notify'];
   app.directive('felmenu', function() {

    return {
    templateUrl: function(elem, attr) {
      return 'directive/ftoolbar.html';
    }
  };});
 
   app.directive('sidenavigator', function() {

    return {
    templateUrl: function(elem, attr) {
      return 'directive/sidenav.html';
    }
  };});

   app.directive('std', function() {

    return {
    templateUrl: function(elem, attr) {
      return 'directive/default.html';
    }
  };});
  //  app.registerCtrl = @controllerProvider.register;
   ;
";
echo str_replace("@","$", $js);
?>