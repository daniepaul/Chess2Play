<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_SESSION['userid']) && isset($_SESSION['gameid']) && isset($_REQUEST['action']))
{
	$userid = $_SESSION['userid'];
	$gameid=$_SESSION['gameid'];
	$usergamestatus=mysqli_query($con,"select * from game where gameid='".$gameid."'");
	$usergamestatusrow=mysqli_fetch_assoc($usergamestatus);
	$uuid=$usergamestatusrow['whitePlayer'];
	$uuid1=$usergamestatusrow['blackPlayer'];
	$whitereg=$usergamestatusrow['whiteRequest'];
	$blackreg=$usergamestatusrow['blackRequest'];
	$uid = "";
	$uid1 = "";
	if($_REQUEST['mycolor']=="b")
	{
		$uid = $uuid1;
		$uid1 = $uuid;
	}
	else
	{
		$uid1 = $uuid1;
		$uid = $uuid;
	}
	if($_REQUEST['action']=="finish")
	{
		$updatepoints=mysqli_query($con,"update userpoints set losegame=losegame+1 where userid='".$uid."'");
		$updateopppoints=mysqli_query($con,"update userpoints set wongame=wongame+1,points=points+2 where userid='".$uid1."'");
		$updatequit=mysqli_query($con,"update game set whiteRequest='N',blackRequest='N',gameStatus='F',won='".$uid1."' where gameid='".$gameid."'");
		
		if(mysql_affected_rows($updatequit) > 0)
		{
			echo '"code" : 200,';
			echo '"status" : "Game resigned successfully."';	
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the resign request. Please try again."';	
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