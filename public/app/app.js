/**
 * Created by dirg on 02/09/2015.
 */
var app = angular.module('blogApp', ["ngSanitize"]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

app.controller('blogCtrl', function($scope, $http) {
    $http.get("api/blog/data/5")
        .success(function(response) {$scope.names = response.record;});

});

app.controller('blogDetailCtrl', function($scope, $http) {
    $http.get("/api/blog/detail/" + document.getElementById('title').value)
        .success(function(response) {$scope.names = response.record;});

});

app.controller('portfolioCtrl', function($scope, $http) {
    $http.get("api/portfolio/data/5")
        .success(function(response) {$scope.names = response.record;});

});

app.controller('portfolioDetailCtrl', function($scope, $http) {
    $http.get("/api/portfolio/detail/" + document.getElementById('title').value)
        .success(function(response) {$scope.names = response.record;});

});

app.filter('spaceless',function() {
    return function(input) {
        if (input) {
            return input.replace(/\s+/g, '-');
        }
    }
});