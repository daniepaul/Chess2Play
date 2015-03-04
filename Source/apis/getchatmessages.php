<?php
include_once("../config.php");
include_once("dbopen.php");
include_once("../libs/smileysComposer.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['userid']) && isset($_REQUEST['gameid']))
{
	$userid = $_REQUEST['userid'];
	$gameid = $_REQUEST['gameid'];
	$isInitial = isset($_REQUEST['loadInitial']) ? true : false;
	$sql = "select a.*,DATE_FORMAT(datetime, '%h:%i %p') as time,(select username from userprofile where userid=a.send_id) as username from chatting as a where a.room = '$gameid'";
	if(!$isInitial)
		$sql .= " and a.send_id <> $userid and a.Cstatus='N'";
	
	$result = mysqli_query($con,$sql);

	if (mysqli_num_rows($result) > 0)
	{
		$updateIds = "";
		echo '"code" : 200,';
		echo '"status" : "New chat message available.",';
		echo '"messages" : [';
		$i = 0;
		while($row = mysqli_fetch_assoc($result))
		{
			if($i > 0)
				echo ",";
				
			echo '{';
			echo '  "dir" : "'.(($row["send_id"] == $userid) ? 'sent' : 'recieved').'",';
			echo '  "text" : "'.insertsmiley($row["text"]).'",';
			echo '  "username" : "'.(($row["send_id"] == $userid) ? 'me' : $row["username"]).'",';
			echo '  "time" : "'.$row["time"].'"';
			echo '}';
			
			if($i > 0)
				$updateIds .= ",";
			$updateIds .= $row["id"];
			
			$i++;
		}
		echo ']';
		mysqli_query($con,"update chatting set Cstatus='Y' where id in (".$updateIds.")");
	}
	else
	{
		echo '"code" : 201,';
		echo '"status" : "No new chat message."';	
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
