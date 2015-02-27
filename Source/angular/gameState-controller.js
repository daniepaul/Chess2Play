app.controller('GameStateCtrl', function($scope, $http, $timeout, $window) {
	$scope.waitAjax = false;
	$scope.users = [];
	$scope.getData = function(){
	  $http.get('apis/checkgamestate.php?gameid='+gameId).
		success(function(data, status, headers, config) {
			if($scope.waitAjax)
				return;
				
			if(data.code == 200)
			{
				if(data.stateCode == "0")
				{
					//Game won
					$scope.waitAjax = true;
					bootbox.alert(data.status, function() {
					  $window.location.href = 'profile.php';
					});
				}
				else if(data.stateCode == "1")
				{
					//Draw request
					$scope.waitAjax = true;
					bootbox.confirm(data.status, function(result) {
						if(result)
						{
							//accept draw
							$scope.updateRequest('apis/drawgame.php?action=draw','profile.php');
						}
						else
						{
							$scope.updateRequest('apis/drawgame.php?action=cancel','');
							$scope.waitAjax = false;
							$scope.intervalFunction();
						}
					});
				}
				else if(data.stateCode == "2")
				{
					//Game drawn
					$scope.waitAjax = true;
					bootbox.alert(data.status, function() {
					  $window.location.href = 'profile.php';
					});					
				}
				else if(data.stateCode == "3")
				{
					//Rejected drawn
					$scope.waitAjax = true;
					bootbox.alert(data.status, function() {
						$scope.updateRequest('apis/drawgame.php?action=clear','');
						$scope.waitAjax = false;
						$scope.intervalFunction();
					});
				}
				else if(data.stateCode == "F")
				{
					//Game drawn
					$scope.waitAjax = true;
					bootbox.alert(data.status, function() {
					  $window.location.href = 'profile.php';
					});
				}
			}
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	}

  $scope.intervalFunction = function(){
    $timeout(function() {
	  if(!$scope.waitAjax)
	  {
			$scope.getData();
			$scope.intervalFunction();
	  }
    }, 1000)
  };
  
  $scope.updateRequest = function(url, next){
	  $http.get(url).
		success(function(data, status, headers, config) {
			if(data.code != 200)
			{
				bootbox.alert(data.status, function() {
						$window.location.href = next;
					});
			}
			else
				$window.location.href = next;
		});
  };

  $scope.intervalFunction();
});