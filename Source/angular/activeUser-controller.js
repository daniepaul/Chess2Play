var timeoutInterval = 10;
app.controller('ActiveUserCtrl', function($scope, $http, $timeout) {
	$scope.users = [];
	$scope.getData = function(){
	  $http.get('apis/getactiveusers.php').
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				for(i = 0; i < data.activeUsers.length ; i++)
				{
					alreadyAvailable = false;
					for(j = 0; i <$scope.users.length; j++)
					{
						if($scope.users[j].username == data.activeUsers[i].username)
						{
							if($scope.users[j].status != data.activeUsers[i].status)
							{
								$scope.users[j] = data.activeUsers[i];
							}
							alreadyAvailable = true;
							break;
						}
					}
					if(!alreadyAvailable)
						$scope.users.push(data.activeUsers[i]);
				}
				
				for(i = 0; i < $scope.users.length ; i++)
				{
					alreadyAvailable = false;
					for(j = 0; i <data.activeUsers.length; j++)
					{
						if($scope.users[j].username == data.activeUsers[i].username)
						{
							alreadyAvailable = true;
							break;
						}
					}
					if(!alreadyAvailable)
						$scope.users.splice(i,1);
				}
			}
			else
				$scope.users = [];
		}).
		error(function(data, status, headers, config) {
		  // log error
		});
	}

  $scope.intervalFunction = function(){
    $timeout(function() {
      $scope.getData();
	  timeoutInterval = 2000;
      $scope.intervalFunction();
    }, timeoutInterval)
  };

  $scope.intervalFunction();
});