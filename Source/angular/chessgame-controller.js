app.directive('chessGame', function($timeout) {
  return {
    restrict: 'E',
	templateUrl : 'templates/chessBoard.html',
	scope: {
            gameid: "@gameid",
            userid : "@userid",
			opponentid : "@opponentid",
			mycolor : "@mycolor",
			notations : "=notations"
        },
	link : function (scope, element) {
		$("#chessTableStyling").height($("#chessTableStyling").width());
		$(window).resize(function() {
			   $("#chessTableStyling").height($("#chessTableStyling").width());
		});
		$timeout(function(){
			scope.readNotation(true);
		},1000);
	},
	controller : function($scope, $http, $timeout, chessBoard, boardRules) {
	$scope.playerColor = "w";
	$scope.PreviousNotation = "";
	$scope.replySpeed = 100;
	
	$scope.board = chessBoard.getBoard();
	
	$scope.selectedCell = {};
	$scope.second_click = false;
	
	$scope.clickCell = function(cell){
		if($scope.playerColor != $scope.mycolor)
		{
			$scope.warning("<strong>Not your turn!</strong> Please wait for your opponent to complete his play.");
			return;
		}
		if(!$scope.second_click)
		{
			if(cell.content.hasPiece)
			{
				if(cell.content.coinColor != $scope.mycolor)
				{
					$scope.warning("<strong>Invalid selection!</strong> The selection you are trying to make is not valid. Please select a piece of your color.");
					return;
				}
				cell.selectedClass = "active";
				$scope.selectedCell = cell;
				$scope.second_click = true;
			}
		}
		else
		{
			if($scope.selectedCell == cell)
			{
				$scope.selectedCell = {};
				cell.selectedClass = "";
				$scope.second_click = false;
			}
			else
			{
				$scope.moveCoin($scope.selectedCell, cell);
			}
		}
	}
	
	$scope.moveCoin = function(start,end){
		var moveResult = boardRules.isValidMove(start, end, $scope.board, $scope.mycolor);
		var moveApproved = moveResult.isValid;
		if(moveApproved)
		{
			var notation = chessBoard.getNotation(start ,end ,moveResult);
			$scope.swapCoin(start, end, moveResult.isCastling);
			$scope.saveNotation(notation);
			$scope.second_click = false;
		}
		else
			$scope.warning("<strong>Invalid Move!</strong> The move you made is not valid. Please try a different move.");
	};
	
	$scope.swapCoin = function(start, end, isCastling){
		if(start.content.hasPiece == true)
		{
			start.content.notMoved = false;
		}
		$scope.board[end.cell_j-1].splice(end.cell_i-1,1,{
			"style" : end.style,
			"cellid" : end.cellid,
			"cell_i" : end.cell_i,
			"cell_j" : end.cell_j, 
			"content" : start.content
		});
		$scope.board[start.cell_j-1].splice(start.cell_i-1,1,{
			"style" : start.style,
			"cellid" : start.cellid,
			"cell_i" : start.cell_i,
			"cell_j" : start.cell_j,
			"content" : {"hasPiece" : false}
		});
		if(isCastling == true)
		{
			var endi = end.cell_i;
			start = $scope.board[start.cell_j-1][0];
			end = $scope.board[start.cell_j-1][2];
			if(endi == 6)
			{
				start = $scope.board[start.cell_j-1][7];
				end = $scope.board[start.cell_j-1][4];
			}
			$scope.swapCoin(start, end, false);
		}
	};
	
	$scope.warning = function(message) {
		$('.alertsContainer').html('<div class="alert alert-danger alert-dismissable alertsPanel fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
		$timeout(function() {
		  $(".alert").alert('close');
		}, 3000)
    };
	
	$scope.statusMessage = "";
	
	$scope.saveNotation = function(currentNotation)
	{
		$http.get('apis/writenotations.php?gameid='+$scope.gameid+'&notation='+currentNotation).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				if(data.nextPlayer == "w")
				{
					$scope.notations[$scope.notations.length-1].blackNotation = data.savedNotation;
				}
				else
				{
					$scope.notations.push({
						whiteNotation : data.savedNotation,
						blackNotation : ''
					});
				}
				$scope.playerColor = data.nextPlayer;
				$scope.PreviousNotation = data.savedNotation;
			}
		});
	};
	
	$scope.readNotation = function(isInitial)
	{
		$http.get('apis/readnotations.php?gameid='+$scope.gameid+(isInitial ? '&fetchAll' : '')).
		success(function(data, status, headers, config) {
			if(data.code == 200)
			{
				if($scope.PreviousNotation != data.lastNotation)
				{
					if(isInitial)
					{
						$scope.notations = data.notations;
						$scope.timedReply(data,0,false);
					}
					else
					{
						if(data.nextPlayColor == "w")
						{
							$scope.notations[$scope.notations.length-1].blackNotation = data.lastNotation;
						}
						else
						{
							$scope.notations.push({
								whiteNotation : data.lastNotation,
								blackNotation : ''
							});
						}
						var notationMove = chessBoard.convertNotation(data.lastNotation);
						$scope.swapCoin($scope.board[notationMove.start.cell_j-1][notationMove.start.cell_i-1],$scope.board[notationMove.end.cell_j-1][notationMove.end.cell_i-1], notationMove.castling);
					}
					$scope.playerColor = data.nextPlayColor;
					$scope.PreviousNotation = data.lastNotation;
				}
			}
			
			if(isInitial)
				$scope.intervalNotationFunction();
		});
	};
	
	$scope.timedReply = function(data, j, isBlack)
	{
		$timeout(function() {
			if( j < data.notations.length)
			{
				if(!isBlack)
				{
					var notationMove = chessBoard.convertNotation(data.notations[j].whiteNotation);
					$scope.swapCoin($scope.board[notationMove.start.cell_j-1][notationMove.start.cell_i-1],$scope.board[notationMove.end.cell_j-1][notationMove.end.cell_i-1], notationMove.castling);
				}
				else
				{
					if(data.notations[j].blackNotation != "")
					{
						notationMove = chessBoard.convertNotation(data.notations[j].blackNotation);
					$scope.swapCoin($scope.board[notationMove.start.cell_j-1][notationMove.start.cell_i-1],$scope.board[notationMove.end.cell_j-1][notationMove.end.cell_i-1], notationMove.castling);
					}
					j++;
				}
				$scope.timedReply(data, j, !isBlack);
			}
		}, $scope.replySpeed);
	}
	
	 $scope.intervalNotationFunction = function(){
		$timeout(function() {
			$scope.readNotation(false);
			$scope.intervalNotationFunction();
		}, 1000)
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
			$('#statusModal').modal('toggle');
		}
	};
   }
 };
});

app.directive('notationDisplay', function() {
	return {
    restrict: 'E',
	template : '<span>{{displayNotation}}</span>',
	scope: {
            notation: "@notation",
            notationColor : "@notationColor"
        },
	link : function (scope, element) {
		if(scope.notation != "")
		{
			if(scope.notation[3] == 'O' && scope.notation[4] == 'C')
			{
				scope.displayNotation = 'O-O-O';
			}
			else if(scope.notation[3] == 'O' && scope.notation[4] == 'G')
			{
				scope.displayNotation = 'O-O';
			}
			else
			{
				scope.displayNotation = scope.notation;
			}
		}
	},
	controller : function($scope, $http, $timeout, chessBoard, boardRules) {
		displayNotation = "";
	}
  }
});

app.filter('reverse', function() {
  return function(items, color) {
    if(color == "w")
	  return items.slice().reverse();
	else
	  return items;
  };
});