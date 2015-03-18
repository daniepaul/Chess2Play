<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_SESSION['userid']) && isset($_REQUEST['gameid']))
{
	$gameid1=$_REQUEST['gameid'];
	$usrid=$_SESSION['userid'];
	$chkuserstatus=mysqli_query($con,"select * from game where gameid='".$gameid1."'");
	$chkuserstatusrow=mysqli_fetch_assoc($chkuserstatus);
	$uuiid=$chkuserstatusrow['whitePlayer'];
	$uuiid1=$chkuserstatusrow['blackPlayer'];
	$whitereq1=$chkuserstatusrow['whiteRequest'];
	$blackreq1=$chkuserstatusrow['blackRequest'];
	echo '"code" : 200,';
	if(($usrid==$uuiid) && ($blackreq1=='Q'))
	{
		echo '"status" : "You Won! Your opponent quit the game.",';	
		echo '"stateCode" : "0"';		
	}
	else if(($usrid==$uuiid1) && ($whitereq1=='Q'))
	{
		echo '"status" : "You Won! Your opponent quit the game.",';	
		echo '"stateCode" : "0"';	
	}
	else if(($usrid==$uuiid) && ($blackreq1=='D'))
	{
		if($whitereq1!='D')
		{
			echo '"status" : "Opponent requests to draw this game!",';	
			echo '"stateCode" : "1"';	
		}
		else
		{
			echo '"status" : "Your request to draw the game is accepted. Game Drawn!",';	
			echo '"stateCode" : "2"';	
		}
	}
	else if(($usrid==$uuiid1) && ($whitereq1=='D'))
	{
		if($blackreq1!='D')
		{
			echo '"status" : "Opponent requests to draw this game!",';	
			echo '"stateCode" : "1"';	
		}
		else
		{
			echo '"status" : "Your request to draw the game is accepted. Game Drawn!",';	
			echo '"stateCode" : "2"';	
		}
	}
	else if(($usrid==$uuiid) && ($whitereq1=='K'))
	{
		echo '"status" : "Your request to draw the game is rejected. Continue playing.",';	
		echo '"stateCode" : "3"';	
	}
	else if(($usrid==$uuiid1) && ($blackreq1=='K'))
	{
		echo '"status" : "Your request to draw the game is rejected. Continue playing.",';	
		echo '"stateCode" : "3"';	
	}
	else if(($usrid==$uuiid) && ($whitereq1=='D'))
	{
		echo '"status" : "You requested the game to be drawn. Waiting for your opponent to respond.",';	
		echo '"stateCode" : "D"';	
	}
	else if(($usrid==$uuiid1) && ($blackreq1=='D'))
	{
		echo '"status" : "You requested the game to be drawn. Waiting for your opponent to respond.",';	
		echo '"stateCode" : "D"';	
	}
	else if($chkuserstatusrow['gameStatus'] == "I")
	{
		echo '"status" : "Waiting for the game to begin. Please stand by for your opponent to arrive.",';	
		echo '"stateCode" : "I"';
	}
	else if($chkuserstatusrow['gameStatus'] == "A")
	{
		echo '"status" : "Start your game.",';	
		echo '"stateCode" : "A"';
	}
	else if($chkuserstatusrow['gameStatus'] == "F")
	{
		echo '"status" : "Congratulations! You won the game.",';	
		echo '"stateCode" : "F"';
	}
	else 
	{
		echo '"status" : "Unknown state.",';	
		echo '"stateCode" : "4"';	
	}
}
else
{
	echo '"code" : 502,';
	echo '"status" : "Invalid Request. Please check the details."';	
}
?>
<?php
echo '}';
include_once("dbclose.php");
?>