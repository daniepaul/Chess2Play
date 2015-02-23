<?php
include_once("../config.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['f']) && $_REQUEST['f'] != "")
{
	try
	{
		$fn = "logs/".$_REQUEST['f'];
		$notation = $_REQUEST['notation'];
		$notation = str_replace("~","\n",$notation);
		$handle = fopen($fn, 'a');
		fwrite ($handle, $notation);
		fclose($handle);
		echo '"code" : 200,';
		echo '"status" : "Game written successfully!"';	
	}
	catch (Exception $e)
	{
		echo '"code" : 503,';
		echo '"status" : "Action failed : '.$e->getMessage().'"';			
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