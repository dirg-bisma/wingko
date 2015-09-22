/**
 * Created by dirg on 07/09/2015.
 */

var app = angular.module('adminApp', ["ngSanitize", "ui.bootstrap"]).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

app.controller('blogCtrl', function($scope, $http) {
    $http.get("/api/paging/data/5")
        .success(function(response) {$scope.names = response.record;});

});



app.controller('blogCreateCtrl', function($scope, $http){
    var jsonPost = {};
    $http.post('/api/blog/create', jsonPost)
        .then(function(response){
            alert(response)
        },function(response){
            alert('error' + response)
        })
});

app.controller('blogUpdateCtrl', function($scope, $http){
    var jsonPost = {};
    $http.put('/api/blog/update', jsonPost)
        .then(function(response){
            alert(response)
        },function(response){
            alert('error' + response)
        })
});

app.controller('blogPagesCtrl', function($scope, $http) {
    $scope.filteredTodos = []
        ,$scope.currentPage = 1
        ,$scope.numPerPage = 5;

    $scope.makeTodos = function(page) {
        $scope.blog = [];
        $http.get("/api/blog/paging/" + (page) + "/" + $scope.numPerPage)
            .success(function(response){
                //$scope.names = response.record;
                $scope.blog = response.record;
                $scope.totals = response.total;
            });
    };
    //$scope.makeTodos($scope.currentPage - 1);
    $scope.numPages = function () {
        return Math.ceil($scope.totals / $scope.numPerPage);
    };
    $scope.$watch('currentPage + numPerPage', function() {
        var page;
        if($scope.currentPage == 1){
            page = $scope.currentPage - 1;
        }else{
            page = ($scope.currentPage - 1) * $scope.numPerPage;
        }
        $scope.filteredTodos = $scope.makeTodos(page);
    });
});

app.controller('blogFormCtrl', function($scope){

});