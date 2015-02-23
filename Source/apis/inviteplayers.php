<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_SESSION['userid']) && isset($_SESSION['opid']))
{
	$userid = $_REQUEST['userid'];
	$opponentuserid = $_REQUEST['opid'];
	
	$selectinvite=mysqli_query($con,"select * from game where (whitePlayer='".$userid."' or whitePlayer='".$opponentuserid."') and (blackPlayer='".$opponentuserid."' or blackPlayer='".$userid."') and gameStatus='I'");	
	$selectinvitecount=mysqli_num_rows($selectinvite);
	
	if($selectinvitecount <= 0)
	{
		$insertinvite=mysqli_query($con,"insert into game (whitePlayer,blackPlayer,gameStatus,datePlayed) values('".$userid."','".$opponentuserid."','I',now())");	
		if(mysql_affected_rows($insertinvite) > 0)
		{
			echo '"code" : 200,';
			echo '"status" : "Game drawn!",';
			echo '"nextUrl" : "livechess.php?opid='.$opponentuserid.'&userid='.$userid.'"';	
		}
		else
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the draw request. Please try again."';	
		}
	}
	else
	{
		echo '"code" : 200,';
		echo '"status" : "Game drawn!",';
		echo '"nextUrl" : "livechess.php?&userid='.$userid.'"';	
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