<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_SESSION['userid']) && isset($_SESSION['gameid']))
{
	$userid = $_SESSION['userid'];
	$gameid=$_SESSION['gameid'];
	$usergamestatus=mysqli_query($con,"select * from game where gameid='$gameid'");
	$usergamestatusrow=mysqli_fetch_assoc($usergamestatus);
	$uuid=$usergamestatusrow['whitePlayer'];
	$uuid1=$usergamestatusrow['blackPlayer'];
	$whitereg=$usergamestatusrow['whiteRequest'];
	$blackreg=$usergamestatusrow['blackRequest'];
	
	//draw the game
	if ($_REQUEST['game']=="draw") 
	{
		$requestdraw="update game set ";
		if($uuid != $userid)
		{
			$requestdraw1=$requestdraw."blackRequest='D' where gameid='$gameid'";
		}
		else
		{
			$requestdraw1=$requestdraw."whiteRequest='D' where gameid='$gameid'";
		}
		$res = mysqli_query($con,$requestdraw1);
		if(mysql_affected_rows($res) > 0)
		{
			echo '"code" : 200,';
			echo '"status" : "Draw request sent."';	
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the draw request. Please try again."';	
		}
	}
	
	
	//draw game
	if($_REQUEST['action']=="draw")
	{
		$updatepoints=mysqli_query($con,"update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid'");
		$updateopppoints=mysqli_query($con,"update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid1'");
		if($uuid==$userid)
		{
			if($blackreg=='D')
			{
				$updatequit=mysqli_query($con,"update game set whiteRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
			}
		}
		else
		{
			if($whitereg=='D')
			{
				$updatequit=mysqli_query($con,"update game set blackRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
			}
		}
		
		if(mysql_affected_rows($updatequit) > 0)
		{
			echo '"code" : 200,';
			echo '"status" : "Game drawn!",';
			echo '"nextUrl" : "livechess.php"';	
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the draw request. Please try again."';	
		}
	}
	
	//reject draw
	if($_REQUEST['action']=="cancel")
	{
		if($userid==$uuid)
		{
			if($blackreg=='D')
			{
			$updatequit=mysqli_query($con,"update game set blackRequest='K' where gameid='$gameid'");
			}
		}
		else
		{
			if($whitereg=='D')
			{
			$updatequit=mysqli_query($con,"update game set whiteRequest='K' where gameid='$gameid'");
			}
		}
		
		if(mysql_affected_rows($updatequit) > 0)
		{
			echo '"code" : 200,';
			echo '"status" : "Draw request declined!"';	
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the draw request. Please try again."';	
		}
	}
	
	//leave it as new game
	if($_REQUEST['action']=="clear")
	{
		if($userid==$uuid)
		{
			if($whitereg=='K')
			{
			$updatequit=mysqli_query($con,"update game set whiteRequest='N' where gameid='$gameid'");
			}
		}
		else
		{
			if($blackreg=='K')
			{
			$updatequit=mysqli_query($con,"update game set blackRequest='N' where gameid='$gameid'");
			}
		}
		
		if(mysqli_affected_rows($con) > 0)
		{
			echo '"code" : 200,';
			echo '"status" : "Draw request cleared!"';	
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the draw request. Please try again."';	
		}
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
