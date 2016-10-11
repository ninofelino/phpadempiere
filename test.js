var app = angular.module('demoApp', ['ngMaterial', 'ui.router', 'ngResource', 'md.data.table'])
    .config(function($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('pink')
            .accentPalette('purple');
    })
    .config(function($stateProvider, $urlRouterProvider) {
        $stateProvider.state('Administration', {
            templateUrl: 'Array',
            controller: function($scope, $http, $stateParams, $timeout) {
                $scope.title = '';
                $http.get('').then(function(response) {
                    $scope.related = response.data;
                });
            }
        }).state('Organization', {
            templateUrl: '',
            controller: function($scope, $http, $stateParams, $timeout) {
                $scope.title = '';
                $http.get('').then(function(response) {
                    $scope.related = response.data;
                });
            }
        })
    })
    .controller('AppCtrl',
        function($scope, $mdSidenav, $http, $mdDialog) {

            $scope.toggleSidenav = function() {
                $mdSidenav('nav').toggle();
            };
            $scope.showAlert = function(ev) {

                $mdDialog.show(
                    $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('This is an alert title')
                    .textContent('You can specify some description text in here.')
                    .ariaLabel('Alert Dialog Demo')
                    .ok('Got it!')
                    .targetEvent(ev)

                )
            };

            $http.get('models.php')
                .then(function(response) {
                    $scope.related = response.data;
                });

        });

app.controller('baru', function($scope) {
    $scope.title = 'baru'
}).$inject = ['$scope', 'notify'];
app.directive('felmenu', function() {

    return {
        templateUrl: function(elem, attr) {
            return 'directive/ftoolbar.html';
        }
    };
});

app.directive('sidenavigator', function() {

    return {
        templateUrl: function(elem, attr) {
            return 'directive/sidenav.html';
        }
    };
});

app.directive('std', function() {

    return {
        templateUrl: function(elem, attr) {
            return 'directive/default.html';
        }
    };
});