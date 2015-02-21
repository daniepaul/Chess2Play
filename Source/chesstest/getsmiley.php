<?php
/****************

Company: Colourz Technologies 
version: Chat 1.0
description: chatting window

--------------------

created by: Danielpaulrajsing
created on:  
completed on:
comments:
------------------
tested by: 
tested on:
test comment:
----------------------------
updated by: 
updated on:
update completed on:

****************/
?>
<?php
include ('includes/init.php');
$id = $_REQUEST["id"];
$s = $_REQUEST["s"];

$smi = array("smile.gif", "grin.gif", "wink.gif","blush.gif", "love.gif", "sad.gif", "cry.gif", "cool.gif", "angry.gif", "surprised.gif", "sick.gif", "tongue.gif", "heart.gif", "heartbroken.gif","angel.gif","please.gif");

$t_smi = array("Smile", "Grin", "Wink","Embarassed", "Love", "Sad", "Cry", "Cool", "Angry", "Surprised", "Sick", "Tongue", "Heart", "Heartbroken","Angel","Please");

$tex = array(":)",":D",";)",":[",":*",":(",":((","8(",":x",":0",":s",":p",":heart:",":brokenheart:",":angel:",":please:");
?>
<table cellpadding="0" cellspacing="0" width="100" height="100" border="0" >
<?php
$r = 0;
for($i=0; $i<sizeof($smi);$i++)
{
if($r==0)
{
echo "<tr>";
}
$img = '<img src="smileys_s/'.$smi[$i].'" alt="" onclick="insertsmiley(\''.$id.'\',\''.$tex[$i].'\',\''.$s.'\')" title="'.$t_smi[$i].'" />';
echo '<td align="center" valign="middle" onMouseOver="this.style.background=\'#FFFFFF\'" onMouseOut="this.style.background=\'\'">'.$img.'</td>';
if($r==3)
{
echo "</tr>";
$r=0;
}
else
{
$r = $r+1;
}
}
?>
</table>