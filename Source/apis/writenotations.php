<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['notation']) && isset($_REQUEST['gameid']))
{
	$gameid = $_REQUEST['gameid'];
	$notation =strtoupper($_REQUEST['notation']);
	$result = mysqli_query($con,"update game set notations=CONCAT(notations,'".$notation."') where gameid='".$gameid."'");
	if(mysqli_affected_rows($con) > 0)
	{
		echo '"code" : 200,';
		echo '"status" : "Notation written successfully!",';
		echo '"savedNotation" : "'.rtrim(rtrim($notation,"~"),"@").'",';
		echo '"nextPlayer" : "'.(strstr($notation,"@") == "@" ? "b" : "w").'"';	
	}
	else
	{
		echo '"code" : 503,';
		echo '"status" : "Error writing notation."';			
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