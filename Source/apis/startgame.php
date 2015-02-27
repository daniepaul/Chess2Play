<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
$gameInitialized = false;
if(isset($_REQUEST['userid']) && isset($_REQUEST['oppuid']))
{
	$userid1 = $_REQUEST['userid'];
	$oppuid1 = $_REQUEST['oppuid'];
	$checkplayerplay=mysqli_query($con,"select * from game where (whitePlayer='".$oppuid1."' or blackPlayer='".$oppuid1."') and gameStatus='A'");
	if(mysqli_num_rows($checkplayerplay)==0)
	{
		$displayinvite=mysqli_query($con,"SELECT gameid,gameStatus FROM game WHERE ((whitePlayer = '".$oppuid1."' and blackPlayer = '".$userid1."') or (whitePlayer = '".$userid1."' and blackPlayer = '".$oppuid1."')) and (gameStatus='I' or gameStatus='A')");	
		$countdisplay=mysqli_num_rows($displayinvite);
		$getid=mysqli_fetch_assoc($displayinvite);
		if($countdisplay==1)
		{
			$inid = $getid['gameid'];
			$fname = "match".$inid.".txt";
			$fn = "../logs/".$fname;
			$handle = fopen($fn, 'w+');
			if($getid['gameStatus'] == "A")
			{
			}
			else
			{
				$acceptinvite=mysqli_query($con,"update game set gameStatus='A' where gameid='".$getid['gameid']."'");
				$deleteinvites=mysqli_query($con,"delete from game where (whitePlayer='".$userid1."' or blackPlayer='".$userid1."') and gameStatus='I'");	
				$checkplayedgame=mysqli_query($con,"select playedgame from userpoints where userid='".$userid1."'");
				if(mysqli_num_rows($checkplayedgame)==0)
				{
					$insertgame=mysqli_query($con,"insert into userpoints(userid,playedgame) values('".$userid1."','1')");
				}
				else
				{
					$updategame=mysqli_query($con,"update userpoints set playedgame=playedgame+1 where userid='".$userid1."'");
				}
			}
			$gameInitialized = true;
			echo '"code" : 200,';
			echo '"status" : "Game created successfully.",';	
			echo '"nextUrl" : "game.php",';	
			echo '"logFile" : "'.$fname.'",';				
			echo '"gameid" : "'.$inid.'",';
			echo '"userid" : "'.$userid1.'",';								
			fclose($handle);
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Game not initialized. Cannot start game."';	
		}
	}
	else
	{
		echo '"code" : 504,';
		echo '"status" : "Opponent already playing a different game. Try later."';	
	}
	
	if($gameInitialized)
	{
		$display=mysqli_query($con,"select gameid,whitePlayer,blackPlayer,whiteRequest,blackRequest from game where (whitePlayer='$userid1' or blackPlayer='$userid1') and gameStatus='A'");
		$diplayrow=mysqli_fetch_assoc($display);
		$uid=$diplayrow['whitePlayer'];
		$uid1=$diplayrow['blackPlayer'];
		$inviteid=$diplayrow['gameid'];
		$whitereg=$diplayrow['whiteRequest'];
		$blackreg=$diplayrow['blackRequest'];
		$_SESSION['gameid']=$inviteid;
		$fname = "match".$inviteid.".txt";
		$playercolor = "b";
		if($uid != $userid1)
		{
			$displayopp=mysqli_query($con,"select userid,username from userprofile where userid='$uid'");
			$playercolor = "w";
		}
		else
		{
			$displayopp=mysqli_query($con,"select userid,username from userprofile where userid='$uid1'");
			$playercolor = "b";
		}
		$diplayrowopp=mysqli_fetch_assoc($displayopp);
		$chatterid=$diplayrowopp['userid'];
		$room1 = "";
		if($userid1>$chatterid)
		{
			$room1=$chatterid.'_'.$userid1;
		}
		else
		{
			$room1=$userid1.'_'.$chatterid;
		}
		
		echo '"chatRoom" : "'.$room1.'",';	
		echo '"yourColor" : "'.$playercolor.'",';	
		echo '"opponentUsername" : "'.$diplayrowopp['username'].'",';				
		echo '"opponentUserid" : "'.$diplayrowopp['userid'].'"';	
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