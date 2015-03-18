app.factory('boardRules', function boardRulesFactory() {
	
	var buildArray = function(color,coin,i,j)
	{
		return { "color":color, "coin":coin, "i":i, "j":j };
	};

	//possible movements
	var rulesArray = [buildArray("b","p","0","-1"), buildArray("w","p","0","+1"), buildArray("a","r","0","n"), buildArray("a","r","n","0"), buildArray("a","r","0","-n"), buildArray("a","r","-n","0"), buildArray("a","b","n","n"), buildArray("a","b","-n","-n"), buildArray("a","b","n","-n"), buildArray("a","b","-n","n"), buildArray("a","n","1","2"), buildArray("a","n","1","-2"), buildArray("a","n","-1","2"), buildArray("a","n","-1","-2"), buildArray("a","n","2","1"), buildArray("a","n","2","-1"), buildArray("a","n","-2","1"), buildArray("a","n","-2","-1"), buildArray("a","q","n","0"), buildArray("a","q","0","n"), buildArray("a","q","n","n"), buildArray("a","q","-n","-n"), buildArray("a","q","n","-n"), buildArray("a","q","-n","n"), buildArray("a","q","-n","0"), buildArray("a","q","0","-n"),buildArray("a","k","1","0"), buildArray("a","k","0","1"), buildArray("a","k","1","1"), buildArray("a","k","-1","-1"), buildArray("a","k","1","-1"), buildArray("a","k","-1","1"), buildArray("a","k","-1","0"), buildArray("a","k","0","-1")];
	
	var isOnPath = function(board,i,j)
	{
		var pathContent = board[j-1][i-1].content;
		if(pathContent.hasPiece)
			return true;
		else
			return false;
	}
	
	var isOwnCoin = function(board,i,j,mycolor)
	{
		var pathContent = board[j-1][i-1].content;
		if(pathContent.hasPiece && pathContent.coinColor == mycolor)
			return true;
		else
			return false;
	}
	
	var createLocaObj = function(i,j,isStriking){
		return {
			"i" : i, 
			"j" : j,
			"isStriking" : isStriking
			};
	};
	
	var isToCell = function(allowedLocations, end){
		for(var i = 0; i < allowedLocations.length; i++)
		{
			if(allowedLocations[i].i == end.cell_i && allowedLocations[i].j == end.cell_j)
			{
				return {
					isStriking :allowedLocations[i].isStriking, 
					isCastling : false,
					isCheckMove : false,
					isValid : true
				};
				break;
			}
		}
		return {
			isStriking : false,
			isCastling : false,
			isCheckMove : false,
			isValid : false
		};
	}
	
	return {
		isValidMove : function(coinCell,endCell, board, color)
		{
			mycolor = color;
			var resultLocation = [];
			
			//Castling move check
			if(coinCell.content.coinPiece == "k" && coinCell.content.notMoved == true)
			{
				if((endCell.cell_i == 6 && board[endCell.cell_j-1][7].content.hasPiece == true && board[endCell.cell_j-1][7].content.coinPiece == "r" && board[endCell.cell_j-1][7].content.coinColor == coinCell.content.coinColor && board[endCell.cell_j-1][7].content.notMoved == true))
				{
					return {
						isStriking : false,
						isCastling : true,
						isCheckMove : false,
						isValid : !(isOnPath(board,7,endCell.cell_j) || isOnPath(board,6,endCell.cell_j) || isOnPath(board,5,endCell.cell_j))
					};
				}
				else if((endCell.cell_i == 2 && board[endCell.cell_j-1][0].content.hasPiece == true && board[endCell.cell_j-1][0].content.coinPiece == "r" && board[endCell.cell_j-1][0].content.coinColor == coinCell.content.coinColor && board[endCell.cell_j-1][0].content.notMoved == true))
				{
					return {
						isStriking : false,
						isCastling : true,
						isCheckMove : false,
						isValid : !(isOnPath(board,3,endCell.cell_j) || isOnPath(board,2,endCell.cell_j))
					};
				}
			}
			
			if(coinCell.content.coinPiece != "p")
			{
				for(var i=0; i<rulesArray.length; i++)
				{
					var localRule = rulesArray[i];
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
							if(isOnPath(board,initiali, initialj))
								isCoininPath = true;
							
							if(!isOwnCoin(board,initiali, initialj,color))
								resultLocation.push(createLocaObj(initiali, initialj,isCoininPath));
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
					if(!isOnPath(board,coinCell.cell_i, coinCell.cell_j+(pmd*1)))
					{
						jumpCellFree = true;
						resultLocation.push(createLocaObj(coinCell.cell_i, coinCell.cell_j+(pmd*1), false));
					}
					if(coinCell.cell_i != 8 && isOnPath(board,coinCell.cell_i+1, coinCell.cell_j+(pmd*1)) && !isOwnCoin(board,coinCell.cell_i+1, coinCell.cell_j+(pmd*1),color))
						resultLocation.push(createLocaObj(coinCell.cell_i+1, coinCell.cell_j+(pmd*1), true));
					if(coinCell.cell_i != 1 && isOnPath(board,coinCell.cell_i-1, coinCell.cell_j+(pmd*1)) && !isOwnCoin(board,coinCell.cell_i-1, coinCell.cell_j+(pmd*1),color))
						resultLocation.push(createLocaObj(coinCell.cell_i-1, coinCell.cell_j+(pmd*1), true));
					if(coinCell.cell_j == pil && !isOnPath(board,coinCell.cell_i, coinCell.cell_j+(pmd*2)) && jumpCellFree)
						resultLocation.push(createLocaObj(coinCell.cell_i, coinCell.cell_j+(pmd*2), false));
				}
			}
			return isToCell(resultLocation, endCell);
		}
	};
});