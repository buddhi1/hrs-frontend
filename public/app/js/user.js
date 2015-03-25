var myApp = angular.module("myApp", ['ngRoute']).config(['$routeProvider', function($routeProvider){
		$routeProvider.when('/admin/user/create', {
		templateUrl: 'admin/user/create.html',
		controller: 'CreateController'

	});


	$routeProvider.otherwise({ redirectTo: '/home' });

}]);

myApp.controller('CreateController', function($scope, $location, $http){
	
	window.scope = $scope;
	$scope.credentials = { name: "", password: "", permission: "" };

	$scope.create = function(credentials) {
	return $http.post("admin/user/create",$scope.credentials);
	};
	
});