<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
$gameInitialized = false;
if(isset($_REQUEST['gameid']) && isset($_SESSION['userid']))
{
	$gameid = $_REQUEST['gameid'];
	$userid = $_SESSION['userid'];
	$gameResult=mysqli_query($con,"select a.*,(select username from userprofile where userid=a.whitePlayer) as whiteUsername ,(select username from userprofile where userid=a.blackPlayer) as blackUsername from game as a where a.gameid='".$gameid."'");
	if(mysqli_num_rows($gameResult)>0)
	{
		$getid=mysqli_fetch_assoc($gameResult);
		if($getid["whitePlayer"]==$userid || $getid["blackPlayer"]==$userid)
		{
			$inid = $getid['gameid'];
			$chatRoom = "room".$getid['gameid'];
			$myColor = "w";
			$opponentId = "";
			$opponentUsername = "";
			$gameuserid = "";
			$username = "";
			$addPlayedGame = false;
			if($getid["whitePlayer"]==$userid)
			{
				$myColor = "w";
				$opponentId = $getid["blackPlayer"];
				$opponentUsername = $getid["blackUsername"];
				$gameuserid = $getid["whitePlayer"];
				$username = $getid["whiteUsername"];
				if($getid["whiteRequest"]=='N')
				{
					$addPlayedGame = true;
					mysqli_query($con,"update game set whiteRequest='X' where gameid='".$inid."'");
				}
			}
			else
			{
				$myColor = "b";
				$opponentId = $getid["whitePlayer"];
				$opponentUsername = $getid["whiteUsername"];
				$gameuserid = $getid["blackPlayer"];
				$username = $getid["blackUsername"];
				if($getid["blackRequest"]=='N')
				{
					$addPlayedGame = true;
					mysqli_query($con,"update game set blackRequest='X' where gameid='".$inid."'");
				}				
			}
			
			if($getid['gameStatus'] == "I")
			{
				mysqli_query($con,"update game set gameStatus='A' where whiteRequest='X' and blackRequest='X' and gameid='".$inid."'");
			}
			
			if($addPlayedGame)
			{
				$checkplayedgame=mysqli_query($con,"select playedgame from userpoints where userid='".$userid."'");
				if(mysqli_num_rows($checkplayedgame)==0)
				{
					$insertgame=mysqli_query($con,"insert into userpoints(userid,playedgame) values('".$userid."','1')");
				}
				else
				{
					$updategame=mysqli_query($con,"update userpoints set playedgame=playedgame+1 where userid='".$userid."'");
				}
			}

			echo '"code" : 200,';
			echo '"status" : "Game created successfully.",';					
			echo '"gameid" : "'.$inid.'",';
			echo '"userid" : "'.$gameuserid.'",';	
			echo '"username" : "'.$username.'",';
			echo '"chatRoom" : "'.$chatRoom.'",';	
			echo '"yourColor" : "'.$myColor.'",';	
			echo '"opponentUsername" : "'.$opponentUsername.'",';				
			echo '"opponentUserid" : "'.$opponentId.'"';							
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "You are not a player for this game. Invalid Request"';	
		}
	}
	else
	{
		echo '"code" : 404,';
		echo '"status" : "No game available."';	
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