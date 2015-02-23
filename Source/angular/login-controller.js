app.controller('UserLoginCtrl', function($scope, $http, $window) {
	$scope.username = "";
	$scope.password = "";
	$scope.loggedIn = false;
	
	$scope.login = function(){
	  $http({
			method: 'POST',
			url: 'apis/login.php',
			data: 'username='+$scope.username+'&password='+$scope.password,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				$scope.loggedIn = true;
				$window.location.href = 'profile.php';
			}
			else
			{
				bootbox.alert(data.status); 
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	};
});