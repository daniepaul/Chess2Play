<?php
include_once("../config.php");
include_once("dbopen.php");
include_once("../libs/smileysComposer.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['userid']) && isset($_REQUEST['gameid']) && isset($_REQUEST['message']))
{
	$userid = $_REQUEST['userid'];
	$gameid = $_REQUEST['gameid'];
	$message = htmlentities($_REQUEST['message'], ENT_QUOTES);
	$username =  $_REQUEST['message'];

	if (!mysqli_query($con,"INSERT INTO chatting (send_id,text,room) VALUES ('$userid','$message','$gameid')")) 
	{
		echo '"code" : 503,';
		echo '"status" : "Chat message not saved."';	
	}
	else
	{
		echo '"code" : 200,';
		echo '"status" : "Chat saved successfully!",';	
		echo '"messages" : [';
			echo '{';
			echo '  "dir" : "sent",';
			echo '  "text" : "'.insertsmiley($message).'",';
			echo '  "username" : "me",';
			echo '  "time" : "'.date('h:i a', time()).'"';
			echo '}';
		echo ']';
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
