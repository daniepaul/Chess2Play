<?php
	$fn = "logs/".$_REQUEST['f'];
	$notation = $_REQUEST['notation'];
	$notation = str_replace("~","\n",$notation);
	$handle = fopen($fn, 'a');
	fwrite ($handle, $notation);
	fclose($handle);				
?>