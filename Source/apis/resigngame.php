<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['userid']) && isset($_REQUEST['opponentid']) && isset($_REQUEST['gameid']))
{
	$userid = $_REQUEST['userid'];
	$oppid = $_REQUEST['opponentid'];
	$gameid=$_REQUEST['gameid'];
	$playColor=$_REQUEST['playercolor'];

	mysqli_query($con,"update userpoints set losegame=losegame+1 where userid='$userid'");
	mysqli_query($con,"update userpoints set wongame=wongame+1,points=points+2 where userid='$opponentid'");
	mysqli_query($con,"update game set ".($playColor == "w"? "whiteRequest" : "blackRequest" ). "='Q',gameStatus='F',won='$opponentid' where gameid='$gameid'");
		

	if(mysqli_affected_rows($con) > 0)
	{
		echo '"code" : 200,';
		echo '"status" : "Successfully resigned from the game.",';	
		echo '"nextUrl" : "profile.php"';	
	}
	else
	{
		echo '"code" : 503,';
		echo '"status" : "Error occured while sending the resign request. Please try again."';	
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
