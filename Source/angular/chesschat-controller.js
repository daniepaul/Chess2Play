app.directive("chessChat", function(){
	return {
		restrict : 'E',
		templateUrl : 'templates/chat.html',
		scope: {
            game: "@game",
            userid: "@userid"
        },
		controller : function($scope, $http, $location, $timeout, $anchorScroll) {
			$scope.messages = [];
			$scope.newMessage = "";
			$scope.userid = "";
			$scope.game = "";
			$scope.sendchat = function(){
				url = 'apis/sendchatmessage.php?userid='+$scope.userid+'&gameid='+$scope.game+'&message='+$scope.newMessage;
				$http.get(url).
					success(function(data, status, headers, config) {
						if(data.code == 200)
						{	
							for(i = 0; i < data.messages.length ; i++)
							{
								$scope.messages.push(data.messages[i]);
							}
							$scope.newMessage = "";
							$scope.gotoBottom();
						}
					}).
					error(function(data, status, headers, config) {
					  // log error
					});
			};
			
			$scope.getNewMessages = function(isInitial){
				url = 'apis/getchatmessages.php?userid='+$scope.userid+'&gameid='+$scope.game
				if(isInitial)
					url += "&loadInitial";
				$http.get(url).
					success(function(data, status, headers, config) {
						if(data.code == 200)
						{	
							for(i = 0; i < data.messages.length ; i++)
							{
								$scope.messages.push(data.messages[i]);
							}
							$scope.gotoBottom();
						}
					}).
					error(function(data, status, headers, config) {
					  // log error
					});
			};
			
			$scope.intervalFunction = function(isInitial){
				$timeout(function() {
				  $scope.getNewMessages(isInitial);
				  $scope.intervalFunction(false);
				}, 1000)
			};
			
			$scope.intervalFunction(true);
			
			 $scope.gotoBottom = function() {
				 $timeout(function() {
					$location.hash('chatBottom');
					$anchorScroll();
				}, 1)
			};
		}
	}
});