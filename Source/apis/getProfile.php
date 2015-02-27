<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['userid']))
{
	$userid = $_REQUEST['userid'];
	$profileQuery=mysqli_query($con,"select a.*, (select SUM(playedgame) from userpoints where userpoints.userid=a.userid) as playedgame, (select SUM(wongame) from userpoints where userpoints.userid=a.userid) as wongame, (select SUM(drawgame) from userpoints where userpoints.userid=a.userid) as drawgame, (select SUM(losegame) from userpoints where userpoints.userid=a.userid) as losegame, (select SUM(points) from userpoints where userpoints.userid=a.userid) as points from userprofile as a where a.userid='".$userid."' or a.username='".$userid."'");

	if(mysqli_num_rows($profileQuery) > 0)
	{
		$profileRow = mysqli_fetch_assoc($profileQuery);
		$userloggedin = (isset($_SESSION['userid']) && $_SESSION['userid'] == $profileRow['userid']) ? 'true' : 'false';
					echo '"code" : 200,';
					echo '"status" : "Profile Found",';
					echo '"user" : {';
					echo ' 	"userId" : "'.$profileRow['userid'].'",';
					echo '	"username" : "'.$profileRow['username'].'",';					
					echo '	"email" : "'.$profileRow['email'].'",';
					echo '	"gender" : "'.$profileRow['gender'].'",';
					echo '	"country" : "'.$profileRow['country'].'",';
					echo '	"playedGames" : "'.$profileRow['playedgame'].'",';
					echo '	"wonGames" : "'.$profileRow['wongame'].'",';
					echo '	"drawnGames" : "'.$profileRow['drawgame'].'",';
					echo '	"lostGames" : "'.$profileRow['losegame'].'",';
					echo '	"totalPoints" : "'.$profileRow['points'].'",';
					echo '  "LoggedIn" : "'.$userloggedin.'"';
					echo '}';
	}
	else
	{
		echo '"code" : 503,';
		echo '"status" : "User profile not found."';
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