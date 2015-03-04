app.controller('UserProfileCtrl', function($scope, $http, $routeParams, $location) {
	$scope.getData = function(){
	  $http.get('apis/getProfile.php?userid='+$routeParams.userId).
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
	
	$scope.inviteForGame = function(userId, opponentId) {
		//alert(userId+" - op : "+opponentId);
		$http.get('apis/inviteplayers.php?userid='+userId+'&opid='+opponentId).
		success(function(data, status, headers, config) {
			if(data.code == 200 || data.code == 201)
			{
				$location.path('/game/'+data.gameid);
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	};
	
	$scope.acceptGame = function(gameId) {
		$location.path('/game/'+gameId);
	};
	
  	$scope.getData();
});