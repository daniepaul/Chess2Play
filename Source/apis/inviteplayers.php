<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['userid']) && isset($_REQUEST['opid']))
{
	$userid = $_REQUEST['userid'];
	$opponentuserid = $_REQUEST['opid'];
	
	$selectinvite=mysqli_query($con,"select * from game where (whitePlayer='".$userid."' or whitePlayer='".$opponentuserid."') and (blackPlayer='".$opponentuserid."' or blackPlayer='".$userid."') and gameStatus='I'");	
	$selectinvitecount=mysqli_num_rows($selectinvite);
	
	if($selectinvitecount <= 0)
	{	
		if(!mysqli_query($con,"insert into game (whitePlayer,blackPlayer,gameStatus,datePlayed) values('".$userid."','".$opponentuserid."','I',now())"))
		{
			echo '"code" : 503,';
			echo '"status" : "Error occured while sending the game invite. Please try again."';	
		}
		else
		{
			$gameid = mysqli_insert_id($con);
			echo '"code" : 200,';
			echo '"status" : "Invited for the game!",';
			echo '"gameid" : "'.$gameid.'",';
			echo '"userid" : "'.$userid.'",';
			echo '"opponentid" : "'.$opponentuserid.'"';	
		}
	}
	else
	{
		$row = mysqli_fetch_array($selectinvite);
		echo '"code" : 201,';
		echo '"status" : "Joining already existing invite",';
		echo '"gameid" : "'.$row["gameid"].'",';
		echo '"userid" : "'.$userid.'",';
		echo '"opponentid" : "'.$opponentuserid.'",';	
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