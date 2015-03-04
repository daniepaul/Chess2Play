<?php
function insertsmiley($t)
{
	$t = html_entity_decode($t, ENT_QUOTES);
	$smileys = array("happy","happy", "grin","grin", "wink2","wink2","cry","cry","cry", "unhappy","unhappy",  "sunglasses","sunglasses", "angry","angry", "surprised","surprised", "tongue","tongue");
	$smileys_insert = array(":)",":-)",":d",":-d",";)",";-)",":'(",":((",":-((",":(",":-(","b|","b-|","x(","x-(",":o",":-o",":p",":-p");
	for($i=0; $i<sizeof($smileys);$i++)
	{
		$smileysimg[$i] = "<smiley class='dpchaticons-emo-".$smileys[$i]."'></smiley>";
	}
	$newt = str_ireplace($smileys_insert,$smileysimg,$t);
	return $newt;
}
?>