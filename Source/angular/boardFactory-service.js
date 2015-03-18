app.factory('chessBoard', function chessBoardFactory() {
	
	var piece_Unicode_white = new Array("♙","♖","♘","♗","♕","♔");
	var piece_Unicode_black = new Array("♟","♜","♞","♝","♛","♚");
	
	var buildArray = function(color,coin,i,j)
	{
		var unicodeContentArray = piece_Unicode_white;
		if(color == "b")
		{
			unicodeContentArray = piece_Unicode_black;	
		}
		var index = 0;
		if(coin == "p")
			index = 0;
		else if(coin == "r")
			index = 1;
		else if(coin == "n")
			index = 2;
		else if(coin == "b")
			index = 3;
		else if(coin == "q")
			index = 4;
		else if(coin == "k")
			index = 5;
		else
			index = 0;
		return { "color":color, "coin":coin, "i":i, "j":j, "unicode" : unicodeContentArray[index] };
	};
	
	//default positions
	var initialLocation = [buildArray("b","r","1","8"),buildArray("b","n","2","8"),buildArray("b","b","3","8"),buildArray("b","q","5","8"),buildArray("b","k","4","8"),buildArray("b","b","6","8"),buildArray("b","n","7","8"),buildArray("b","r","8","8"),buildArray("b","p","1","7"),buildArray("b","p","2","7"),buildArray("b","p","3","7"),buildArray("b","p","4","7"),buildArray("b","p","5","7"),buildArray("b","p","6","7"),buildArray("b","p","7","7"),buildArray("b","p","8","7"),buildArray("w","r","1","1"),buildArray("w","n","2","1"),buildArray("w","b","3","1"),buildArray("w","q","5","1"),buildArray("w","k","4","1"),buildArray("w","b","6","1"),buildArray("w","n","7","1"),buildArray("w","r","8","1"),buildArray("w","p","1","2"),buildArray("w","p","2","2"),buildArray("w","p","3","2"),buildArray("w","p","4","2"),buildArray("w","p","5","2"),buildArray("w","p","6","2"),buildArray("w","p","7","2"),buildArray("w","p","8","2")];
	
	var Name_Array = new Array("a","b","c","d","e","f","g","h");
	
	var convertAlphabetToNumber = function(char)
	{
		for(var i=0; i < Name_Array.length ; i++)
		{
			if(Name_Array[7-i] == char)
			{
				return i+1;
			}
		}
	};
	
	return {
		getBoard : function(){
			var tempBoard = new Array(8);
			for(j=1; j<= 8; j++) {
				var tempRow = new Array(8);
				for(i=1; i<= 8; i++)
				{
					var color_code = (j+i)%2;
	
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
			
			for(var i=0; i<initialLocation.length; i++)
			{
				var initializeCoin = initialLocation[i];
				var name = " ";
				if(initializeCoin.coin == "k")
				{
					name = "name='"+initializeCoin.color+"king'";
				}
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.hasPiece = true;
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.notMoved = true;
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.cellImage = initializeCoin.color+initializeCoin.coin+".png";
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.cellImageName = name;
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.coinColor = initializeCoin.color;
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.coinPiece = initializeCoin.coin;
				tempBoard[parseInt(initializeCoin.j)-1][parseInt(initializeCoin.i)-1].content.unicode = initializeCoin.unicode;
			}
			
			return tempBoard;
		},
		getNotation : function (start ,end ,moveResult)
		{
			var clickedPiece = start.content.coinPiece;
			if(clickedPiece == "p") 
				clickedPiece = "";
			operat = "-";
			if(moveResult.isStriking)
				operat = "X";
			if(moveResult.isCastling)
				operat = "O";
			if(moveResult.isCheckMove)
				operat = "C";
			notation = clickedPiece.toUpperCase()+Name_Array[7-(start.cell_i-1)]+start.cell_j+operat+Name_Array[7-(end.cell_i-1)]+end.cell_j;
			if(start.content.coinColor == "b")
				notation = notation +"~";
			else
				notation = notation +"@";
			return notation;
		},
		convertNotation : function (notation)
		{
			var charArray = notation.toLowerCase().split('');
			var returnVal = {};
			var operator = "";
			
			if(charArray.length == 5)
			{
				returnVal = {
					clickedPiece : "p",
					start : {
						"cell_i" : parseInt(convertAlphabetToNumber(charArray[0])),
						"cell_j" : parseInt(charArray[1])
					},
					end : {
						"cell_i" : parseInt(convertAlphabetToNumber(charArray[3])),
						"cell_j" : parseInt(charArray[4])
					},
					castling : false,
					check : false
				};
				operator = charArray[2];
			}
			else if(charArray.length == 6)
			{
				returnVal = {
					clickedPiece : charArray[0],
					start : {
						"cell_i" : parseInt(convertAlphabetToNumber(charArray[1])),
						"cell_j" : parseInt(charArray[2])
					},
					end : {
						"cell_i" : parseInt(convertAlphabetToNumber(charArray[4])),
						"cell_j" : parseInt(charArray[5])
					},
					castling : false,
					check : false
				};
				operator = charArray[3];
			}
			
			if(operator == "o")
			{
				returnVal.castling = true;
			}
			else if(operator == "c")
			{
				returnVal.check = true;
			}
			
			return returnVal;
		}
	};
});