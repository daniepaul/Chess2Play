app.controller('UserLoginCtrl', function($scope, $http, $window, $location) {
	$scope.username = "";
	$scope.password = "";
	$scope.loggedIn = false;
	$scope.profileUrl = "#/profile";
	
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
				$scope.profileUrl = '#/profile/'+data.user.username;
				$('#myModal').modal('hide');
				$location.path('/profile/'+data.user.username);
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

app.directive('userLogin', function(){
	return{
		restrict : 'E',
		templateUrl : 'templates/useraccess.html',
		controller : 'UserLoginCtrl'
	}
});