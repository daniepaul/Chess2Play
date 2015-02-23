<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['userid']) && isset($_SESSION['gameid']))
{
	$userid = $_REQUEST['userid'];
	$gameid=$_SESSION['gameid'];
	$updatestatuslog=mysqli_query($con,"update log set status='N' where userid='$userid'");
	$usergamestatus=mysqli_query($con,"select * from game where gameid='$gameid'");
	$usergamestatusrow=mysqli_fetch_assoc($usergamestatus);
	$uuid=$usergamestatusrow['whitePlayer'];
	$uuid1=$usergamestatusrow['blackPlayer'];
	$whitereg=$usergamestatusrow['whiteRequest'];
	$blackreg=$usergamestatusrow['blackRequest'];
	if($userid==$uuid)
	{
		if(($blackreg=='N')&&($whitereg=='N'))
		{
			$updatepoints=mysqli_query($con,"update userpoints set losegame=losegame+1 where userid='$uuid'");
			$updateopppoints=mysqli_query($con,"update userpoints set wongame=wongame+1,points=points+2 where userid='$uuid1'");
			$updatequit=mysqli_query($con,"update game set whiteRequest='Q',gameStatus='F',won='$uuid1' where gameid='$gameid'");
		}
		if(($blackreg=='D')&&($whitereg!='D'))
		{
			$updatepoints=mysqli_query($con,"update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid'");
			$updateopppoints=mysqli_query($con,"update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid1'");
			$updatequit=mysqli_query($con,"update game set whiteRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
		}
	}
	else
	{
		if(($blackreg=='N')&&($whitereg=='N'))
		{
			$updatepoints=mysqli_query($con,"update userpoints set losegame=losegame+1 where userid='$uuid1'");
			$updateopppoints=mysqli_query($con,"update userpoints set wongame=wongame+1,points=points+2 where userid='$uuid'");
			$updatequit=mysqli_query($con,"update game set blackRequest='Q',gameStatus='F',won='$uuid' where gameid='$gameid'");
		}
		if(($whitereg=='D') && ($blackreg!='D'))
		{
			$updatepoints=mysqli_query($con,"update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid1'");
			$updateopppoints=mysqli_query($con,"update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid'");
			$updatequit=mysqli_query($con,"update game set blackRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
		}
	}
	$deleteinvites=mysqli_query($con,"delete from game where (whitePlayer='$userid' or blackPlayer='$userid') and gameStatus='I'");
	$deletechatmsg=mysqli_query($con,"delete from chatting where (send_id='$userid' or rec_id='$userid')");
	session_destroy();
	echo '"code" : 200,';
	echo '"status" : "Logged out successful!",';
	echo '"nextUrl" : "index.php"';
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

