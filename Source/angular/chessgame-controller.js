app.directive('chessGame', function() {
  return {
    restrict: 'E',
	templateUrl : 'templates/chessBoard.html',
	scope: {
            gameid: "@gameid",
            userid : "@userid",
			opponentid : "@opponentid"
        },
	controller : function($scope, $http, $window, $timeout) {
	$scope.MyColor = "b"; //set during init
	$scope.filename = "match1.txt";  //set during init
	$scope.playerColor = "w";
	$scope.PreviousNotation = "";
	
	$scope.buildArray = function(color,coin,i,j)
	{
		return { "color":color, "coin":coin, "i":i, "j":j };
	};
	
	//possible movements
	$scope.rulesArray = [$scope.buildArray("b","p","0","-1"), $scope.buildArray("w","p","0","+1"), $scope.buildArray("a","r","0","n"), $scope.buildArray("a","r","n","0"), $scope.buildArray("a","r","0","-n"), $scope.buildArray("a","r","-n","0"), $scope.buildArray("a","b","n","n"), $scope.buildArray("a","b","-n","-n"), $scope.buildArray("a","b","n","-n"), $scope.buildArray("a","b","-n","n"), $scope.buildArray("a","n","1","2"), $scope.buildArray("a","n","1","-2"), $scope.buildArray("a","n","-1","2"), $scope.buildArray("a","n","-1","-2"), $scope.buildArray("a","n","2","1"), $scope.buildArray("a","n","2","-1"), $scope.buildArray("a","n","-2","1"), $scope.buildArray("a","n","-2","-1"), $scope.buildArray("a","q","n","0"), $scope.buildArray("a","q","0","n"), $scope.buildArray("a","q","n","n"), $scope.buildArray("a","q","-n","-n"), $scope.buildArray("a","q","n","-n"), $scope.buildArray("a","q","-n","n"), $scope.buildArray("a","q","-n","0"), $scope.buildArray("a","q","0","-n"),$scope.buildArray("a","k","1","0"), $scope.buildArray("a","k","0","1"), $scope.buildArray("a","k","1","1"), $scope.buildArray("a","k","-1","-1"), $scope.buildArray("a","k","1","-1"), $scope.buildArray("a","k","-1","1"), $scope.buildArray("a","k","-1","0"), $scope.buildArray("a","k","0","-1")];
	
	//default positions
	$scope.initialLocation = [$scope.buildArray("b","r","1","8"),$scope.buildArray("b","n","2","8"),$scope.buildArray("b","b","3","8"),$scope.buildArray("b","q","5","8"),$scope.buildArray("b","k","4","8"),$scope.buildArray("b","b","6","8"),$scope.buildArray("b","n","7","8"),$scope.buildArray("b","r","8","8"),$scope.buildArray("b","p","1","7"),$scope.buildArray("b","p","2","7"),$scope.buildArray("b","p","3","7"),$scope.buildArray("b","p","4","7"),$scope.buildArray("b","p","5","7"),$scope.buildArray("b","p","6","7"),$scope.buildArray("b","p","7","7"),$scope.buildArray("b","p","8","7"),$scope.buildArray("w","r","1","1"),$scope.buildArray("w","n","2","1"),$scope.buildArray("w","b","3","1"),$scope.buildArray("w","q","5","1"),$scope.buildArray("w","k","4","1"),$scope.buildArray("w","b","6","1"),$scope.buildArray("w","n","7","1"),$scope.buildArray("w","r","8","1"),$scope.buildArray("w","p","1","2"),$scope.buildArray("w","p","2","2"),$scope.buildArray("w","p","3","2"),$scope.buildArray("w","p","4","2"),$scope.buildArray("w","p","5","2"),$scope.buildArray("w","p","6","2"),$scope.buildArray("w","p","7","2"),$scope.buildArray("w","p","8","2")];
	
	$scope.board = [];
	
	$scope.init = function(){
		tempBoard = new Array(8);
		for(j=1; j<= 8; j++) {
			tempRow = new Array(8);
			for(i=1; i<= 8; i++)
			{
				color_code = (j+i)%2;

				tempRow[i-1] = {
					"style" : "chessCell"+color_code,
					"selectedClass" : " ",
					"cellid" : "cell"+i+j,
					"cell_i" : i,
					"cell_j" : j, 
					"content" : {"hasPiece" : false}
				};
			}
			tempBoard[j-1] = tempRow;
		}
		
		for(var i=0; i<$scope.initialLocation.length; i++)
		{
			initializeCoin = $scope.initialLocation[i];
			name = " ";
			if(initializeCoin.coin == "k")
			{
				name = "name='"+initializeCoin.color+"king'";
			}
			tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.hasPiece = true;
			tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.cellImage = initializeCoin.color+initializeCoin.coin+".gif";
			tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.cellImageName = name;
			tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.coinColor = initializeCoin.color;
			tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.coinPiece = initializeCoin.coin;
		}
		
		$scope.board = tempBoard;
	};
	
	$scope.selectedCell = {};
	$scope.second_click = false;
	
	$scope.clickCell = function(cell){
		if(!$scope.second_click)
		{
			if(cell.content.hasPiece)
			{
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
		moveApproved = false;
		$scope.findLocation(start);
		for(var i = 0; i < $scope.allowedLocations.length; i++)
		{
			//alert($scope.allowedLocations[i].i+", "+$scope.allowedLocations[i].j);
			if($scope.allowedLocations[i].i == end.cell_i && $scope.allowedLocations[i].j == end.cell_j)
			{
				moveApproved = true;
//				if($scope.allowedLocations[i].isStriking)
//					alert("striking");
				break;
			}
		}
		if(moveApproved)
		{
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
			$scope.second_click = false;
		}
		else
			$scope.warning("<strong>Invalid Move!</strong> The move you made is not valid. Please try a different move.");
	};
	
	$scope.warning = function(message) {
		$('.alertsContainer').html('<div class="alert alert-danger alert-dismissable alertsPanel fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+message+'</span></div>');
		$timeout(function() {
		  $(".alert").alert('close');
		}, 3000)
    };
	
	$scope.isOnPath = function(i,j)
	{
		pathContent = $scope.board[j-1][i-1].content;
		if(pathContent.hasPiece)
			return true;
		else
			return false;
	}
	
	$scope.isOwnCoin = function(i,j)
	{
		pathContent = $scope.board[j-1][i-1].content;
		if(pathContent.hasPiece && pathContent.coinColor == $scope.MyColor)
			return true;
		else
			return false;
	}
	
	$scope.allowedLocations = [];
	
	$scope.findLocation = function(coinCell)
	{
		var resultLocation = [];
		if(coinCell.content.coinPiece != "p")
		{
			for(var i=0; i<$scope.rulesArray.length; i++)
			{
				var localRule = $scope.rulesArray[i];
				/* Check if the supplied colour and coin match in the array */
				if(localRule.coin == coinCell.content.coinPiece)
				{
					var initiali = coinCell.cell_i;
					var initialj = coinCell.cell_j;
					var iInc = 1;
					var jInc = 1;
					var iMax = 1;
					var jMax = 1;
					
					if(localRule.i != "n" && localRule.i != "-n")
					{
						initiali = initiali + parseInt(localRule.i);
						iInc = 0;
						iMax = initiali;
					}
					else if(localRule.i == "n")
					{
						initiali = initiali + 1;
						iInc = 1;
						iMax = 8;
					}
					else if(localRule.i == "-n")
					{
						initiali = initiali - 1;
						iInc = -1;
						iMax = 1;
					}
					
					if(localRule.j != "n" && localRule.j != "-n")
					{
						initialj = initialj + parseInt(localRule.j);
						jInc = 0;
						jMax = initialj;
					}
					else if(localRule.j == "n")
					{
						initialj = initialj + 1;
						jInc = 1;
						jMax = 8;
					}
					else if(localRule.j == "-n")
					{
						initialj = initialj - 1;
						jInc = -1;
						jMax = 1;
					}
	
					while(true)
					{
						if(initiali > 8 || initiali < 1 || initialj > 8 || initialj < 1)
							break;
						var isCoininPath = false;
						if($scope.isOnPath(initiali, initialj))
							isCoininPath = true;
						
						if(!$scope.isOwnCoin(initiali, initialj))
							resultLocation.push($scope.createLocaObj(initiali, initialj,isCoininPath));
						if(isCoininPath)
						{
							break;
						}
						if((initiali - iMax == 0) && (initialj - jMax == 0))
							break;
						else
						{
							initiali = initiali+iInc;
							initialj = initialj+jInc;
						}
					}
				}
			}
		}
		else
		{
			//pawn movements
			var pmd = 1; //pawn movement direction
			var pil = 2; //pawn initial location
			if(coinCell.content.coinColor == "b")
			{
				pmd = -1;
				pil = 7;
			}
			if(coinCell.cell_j+(pmd*1) <= 8 && coinCell.cell_j+(pmd*1) >= 1)
			{
				jumpCellFree = false;
				//alert(coinCell.cell_j+(pmd*1));
				if(!$scope.isOnPath(coinCell.cell_i, coinCell.cell_j+(pmd*1)))
				{
					jumpCellFree = true;
					resultLocation.push($scope.createLocaObj(coinCell.cell_i, coinCell.cell_j+(pmd*1), false));
				}
				if(coinCell.cell_i != 8 && $scope.isOnPath(coinCell.cell_i+1, coinCell.cell_j+(pmd*1)) && !$scope.isOwnCoin(coinCell.cell_i+1, coinCell.cell_j+(pmd*1)))
					resultLocation.push($scope.createLocaObj(coinCell.cell_i+1, coinCell.cell_j+(pmd*1), true));
				if(coinCell.cell_i != 1 && $scope.isOnPath(coinCell.cell_i-1, coinCell.cell_j+(pmd*1)) && !$scope.isOwnCoin(coinCell.cell_i-1, coinCell.cell_j+(pmd*1)))
					resultLocation.push($scope.createLocaObj(coinCell.cell_i-1, coinCell.cell_j+(pmd*1), true));
				if(coinCell.cell_j == pil && !$scope.isOnPath(coinCell.cell_i, coinCell.cell_j+(pmd*2)) && jumpCellFree)
					resultLocation.push($scope.createLocaObj(coinCell.cell_i, coinCell.cell_j+(pmd*2), false));
			}
		}
		$scope.allowedLocations = resultLocation;
	};
	
	$scope.createLocaObj = function(i,j,isStriking){
		return {
			"i" : i, 
			"j" : j,
			"isStriking" : isStriking
			};
	};	
   }
 };
});

app.filter('reverse', function() {
  return function(items, color) {
    if(color == "w")
	  return items.slice().reverse();
	else
	  return items;
  };
});