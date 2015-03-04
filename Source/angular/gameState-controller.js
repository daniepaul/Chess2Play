app.controller('GameStateCtrl', function($scope, $http, $timeout, $routeParams, $location) {
	$scope.waitAjax = false;
	$scope.userid = "";
	$scope.gameid = "";
	$scope.users = [];
	$scope.game = {};
	$scope.displaynotations = [];
	$scope.status = "";
	$scope.opponentuserid = "2";
	$scope.gameStarted = false;
	
	$scope.resign = function() {
		$scope.showStatus("You requested the game to be drawn. Waiting for your opponent to response.", false);
	};
	
	$scope.requestDraw = function() {
		$scope.showStatus("You requested the game to be drawn. Waiting for your opponent to response.", true);
	};
	
	$scope.init = function() {
		$http.get('apis/startgame.php?gameid='+$routeParams.gameId).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				$scope.userid = data.userid;
				$scope.gameid = data.gameid;
				$scope.users = [];
				$scope.game = {
						"whitePlayer" :  (data.yourColor == 'b') ? data.opponentUsername : data.username,
						"blackPlayer" : (data.yourColor == 'w') ? data.opponentUsername : data.username,
						"myColor" : (data.yourColor == 'w') ? 'White' : 'Black',
						"myColorCode" : data.yourColor
					};
				$scope.opponentuserid = data.opponentUserid;
			}
		});
	};
	
	$scope.getData = function(){
	  $http.get('apis/checkgamestate.php?gameid='+$scope.gameid).
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
						$scope.navigate('/profile/'+$scope.userId);
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
							$scope.updateRequest('apis/drawgame.php?action=draw','/profile/'+$scope.userId);
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
						$scope.navigate('/profile/'+$scope.userId);
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
					  $scope.navigate('/profile/'+$scope.userId);
					});
				}
				else if(data.stateCode == "I")
				{
					//Waiting for game to begin
					$scope.waitAjax = false;
					$scope.showStatus(data.status, true);
					$scope.gameStarted = false;
				}
				else if(data.stateCode == "A")
				{
					//Begin Game
					//Waiting for game to begin
					$scope.waitAjax = false;
					if(!$scope.gameStarted)
					{
						$scope.hideStatus(true);
						$scope.timedShowStatus(data.status, false);
						$scope.gameStarted = true;
					}
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
						$scope.navigate(next);
					});
			}
			else
				$scope.navigate(next);
		});
  };
  
  $scope.navigate = function(url)
  {
	  if(url != "")
	  	$location.path(url);
  };
  
  	$scope.timedShowStatus = function(message, blockPage) {
		$scope.showStatus(message,blockPage);
		$timeout(function() {
			$scope.hideStatus(blockPage);
		}, 3000)
	};
  
	$scope.showStatus = function(message, blockPage) {
		$scope.statusMessage = message;
		if(blockPage)
		{
			$('#statusModal').modal({
			  keyboard: false,
			  backdrop : 'static'
			});
		}
		else
		{
			$('#statusNonModal').modal('toggle');
		}
	};
	
	$scope.hideStatus = function(blockPage) {
		$scope.statusMessage = "";
		if(blockPage)
		{
			$('#statusModal').modal('hide');
		}
		else
		{
			$('#statusNonModal').modal('hide');
		}
	};

  $scope.intervalFunction();
});