app.controller('UserProfileCtrl', function($scope, $http) {
	$scope.getData = function(){
	  $http.get('apis/getProfile.php?userid='+profileId).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				$scope.profile = data.user;
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	};
	
  	$scope.getData();
});