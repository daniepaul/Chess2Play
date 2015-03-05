<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
?>

{
<?php
if(isset($_SESSION['userid']))
{
$userid = $_SESSION['userid'];
$getloggedusers=mysqli_query($con,"select u.userid, u.username from log l, userprofile u where u.userid = l.userid and (u.userid <> '".$userid."')  and l.status = 'Y'");
if (mysqli_num_rows($getloggedusers) > 0)
{
	echo '"code" : 200,';
	echo '"status" : "Active users available.",';
	echo '"activeUsers" : [';
	$i = 0;
	while ($getloggedrow = mysqli_fetch_assoc($getloggedusers))
	{
		if($i > 0)
			echo ',';
		$i++;
		
		echo '{';
		echo '"username" : "'.$getloggedrow['username'].'",';
		echo '"userid" : "'.$getloggedrow['userid'].'",';
		$oppuserid=$getloggedrow['userid'];
     	$getinviteduser=mysqli_query($con,"select * from game where whitePlayer='".$userid."' and blackPlayer='".$oppuserid."' and gameStatus='I'");
		$getinvitedusercount=mysqli_num_rows($getinviteduser);
		if($getinvitedusercount==0)
	 	{
	 	$getuserstatus=mysqli_query($con,"select * from game where (whitePlayer='".$oppuserid."' or blackPlayer='".$oppuserid."') and gameStatus='A' and whiteRequest='X' and blackRequest='X'");
	 	$getuserstatuscount=mysqli_num_rows($getuserstatus);
	 	if($getuserstatuscount==1)
	 	{
			$row = mysqli_fetch_array($getuserstatus);
			echo '"status" : "Playing",';
			echo '"gameId" : "'.$row["gameid"].'"';			
		}
		else
		{
		$getoppinvite=mysqli_query($con,"select * from game where whitePlayer='".$oppuserid."' and blackPlayer='".$userid."' and gameStatus='I'");
		if(mysqli_num_rows($getoppinvite)==1)
		{
			$row = mysqli_fetch_array($getoppinvite);
			echo '"status" : "Requested",';
			echo '"gameId" : "'.$row["gameid"].'"';
		}
		else
		{
			echo '"status" : "Available",';
			echo '"gameId" : ""';			
		}
		}
		}
		else
		{
			$row = mysqli_fetch_array($getinviteduser);
			echo '"status" : "Invited",';
			echo '"gameId" : "'.$row["gameid"].'"';
		}
		echo '}';
	}
	echo ']';
	}
	else
	{
		echo '"code" : 404,';
		echo '"status" : "No Active users available."';	
	}
}
else
{
	echo '"code" : 502,';
	echo '"status" : "Invalid Request. Please check the details."';
}
?>
}
<?php
include_once("dbclose.php");
?>
