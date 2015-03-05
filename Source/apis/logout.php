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
	$updatestatuslog=mysqli_query($con,"update log set status='N' where userid='$userid'");
	session_destroy();
	echo '"code" : 200,';
	echo '"status" : "Logged out successful!"';
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

