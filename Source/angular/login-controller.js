app.controller('UserLoginCtrl', function($scope, $http, $window, $location) {
	$scope.username = "";
	$scope.userid = "";
	$scope.password = "";
	$scope.loggedIn = false;
	$scope.profileUrl = "#/profile";
	
	$scope.verifyLogin = function(){
		$http.get('apis/login.php?verifyLogin').
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				$scope.loggedIn = true;
				$scope.userid = data.user.userid;
				$scope.profileUrl = '#/profile/'+data.user.username;
			}
			else
			{
				$scope.loggedIn = false;
			}
		});
	};
	
	$scope.register = function(){
		$http({
			method: 'POST',
			url: 'apis/registerUser.php',
			data: 'username='+$scope.username+'&password='+$scope.password+'&email='+$scope.email+'&country='+$scope.country+'&city='+$scope.city,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				$scope.loggedIn = false;
				$scope.userid = "";
				$('#addProfileModal').modal('hide');
				bootbox.alert("User registered successfully! You can login now."); 
			}
			else
			{
				$scope.loggedIn = false;
				$scope.userid = "";
				bootbox.alert(data.status); 
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	};	
	
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
				$scope.userid = data.user.userid;
				$scope.profileUrl = '#/profile/'+data.user.username;
				$('#myModal').modal('hide');
				$location.path('/profile/'+data.user.username);
			}
			else
			{
				$scope.loggedIn = false;
				$scope.userid = "";
				bootbox.alert(data.status); 
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	};
	
	$scope.logout = function(){
		if($scope.userid != "")
		{
			$http.get('apis/logout.php?userid='+$scope.userid).
			success(function(data, status, headers, config) {
				if(data.code == 200)
				{
					$scope.loggedIn = false;
					$scope.userid = "";
					$scope.profileUrl = '#/profile';
				}
			});
		}
	};
	
	$scope.verifyLogin();
});

app.directive('userLogin', function($timeout){
	return{
		restrict : 'E',
		templateUrl : 'templates/useraccess.html',
		controller : 'UserLoginCtrl'
	}
});
