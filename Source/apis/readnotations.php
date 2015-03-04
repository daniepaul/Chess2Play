<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['gameid']))
{
	$gameid = $_REQUEST['gameid'];
	$result = mysqli_query($con,"select notations from game where gameid='".$gameid."'");
	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_array($result);
		$notationStr = $row["notations"];
		$notationStr = rtrim($notationStr, "~");
		$notationRows = explode("~",$notationStr);
		$lastNotationRow = explode("@",rtrim((sizeof($notationRows) > 0 ? $notationRows[sizeof($notationRows)-1] : ""),"@"));
		echo '"code" : 200,';
		echo '"status" : "Notation read successfully!",';	
		if(isset($_REQUEST['fetchAll']))
		{
			echo '"notations" : [';
			for($i = 0; $i < sizeof($notationRows); $i++)
			{
				$notationCol = explode("@",rtrim($notationRows[$i],"@"));
				if(sizeof($notationCol) > 0)
				{
					if($i > 0)
						echo ',';
					echo '{';
					echo '"whiteNotation" : "'.$notationCol[0].'",';
					echo '"blackNotation" : "'.(sizeof($notationCol) > 1 ? $notationCol[1] : '').'"';
					echo '}';
				}
			}
			echo '],';
		}
		echo '"lastNotation" : "'.((sizeof($lastNotationRow) > 0) ? $lastNotationRow[sizeof($lastNotationRow)-1] : "").'",';
		echo '"nextPlayColor" : "'.(sizeof($lastNotationRow) > 1 ? "w" : "b").'"';	
	}
	else
	{
		echo '"code" : 404,';
		echo '"status" : "Error reteireving notations."';			
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
?>
<?php
include_once("dbclose.php");
?>