<?php
include_once("config.php");
include_once("include/dbopen.php");

$userid = $_SESSION['userid'];
$gameid=$_SESSION['gameid'];
$usergamestatus=mysql_query("select * from game where gameid='$gameid'");
$usergamestatusrow=mysql_fetch_assoc($usergamestatus);
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
mysql_query($requestdraw1);
}


//draw game
if($_REQUEST['action']=="draw")
{
$updatepoints=mysql_query("update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid'");
$updateopppoints=mysql_query("update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid1'");
if($uuid==$userid)
{
if($blackreg=='D')
{
$updatequit=mysql_query("update game set whiteRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
}
}
else
{
if($whitereg=='D')
{
$updatequit=mysql_query("update game set blackRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
}
}
header("Location:livechess.php");
}

//reject draw
if($_REQUEST['action']=="cancel")
{
	if($userid==$uuid)
	{
		if($blackreg=='D')
		{
		$updatequit=mysql_query("update game set blackRequest='K' where gameid='$gameid'");
		}
	}
	else
	{
		if($whitereg=='D')
		{
		$updatequit=mysql_query("update game set whiteRequest='K' where gameid='$gameid'");
		}
	}
}

//leave it as new game
if($_REQUEST['action']=="clear")
{
	if($userid==$uuid)
	{
		if($whitereg=='K')
		{
		$updatequit=mysql_query("update game set whiteRequest='N' where gameid='$gameid'");
		}
	}
	else
	{
		if($blackreg=='K')
		{
		$updatequit=mysql_query("update game set blackRequest='N' where gameid='$gameid'");
		}
	}
}

include_once("include/dbclose.php");
?>

