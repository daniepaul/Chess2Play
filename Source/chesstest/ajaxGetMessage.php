<?php
/****************

Company: Colourz Technologies 
version: Chat 1.0
description: chatting window

--------------------

created by: Senthil Kumar P
created on:  
completed on:
comments:
------------------
tested by: Danielpaulrajsing
tested on:
test comment:
----------------------------
updated by: Danielpaulrajsing
updated on:
update completed on:

****************/
?>
<?php
include ('includes/init.php');
?>
<?php
$now = time();
//$sid=$_SESSION['uid'];
//if($_SESSION['uid']=="" || $_SESSION['uid']==null){echo "uid session not set";}
$room1=$_REQUEST['room'];
$uids = split("_",$room1);
if($uids[0] == $_SESSION['userid'])
$oppid = $uids[1];
else
$oppid = $uids[0];
	$r=mysql_query("SELECT * FROM userprofile WHERE userid='$oppid'");
	$oppname = mysql_result($r,0,"username");
$q=mysql_query("SELECT * FROM  chatting WHERE room='$room1' order by datetime");
mysql_query("update chatting set Cstatus='Y' WHERE room='$room1' and send_id='$oppid'");
while($selectchat=mysql_fetch_assoc($q)){
	$uidv=$selectchat['send_id'];
if($uidv != $previd)
{
	//echo "SELECT * FROM usertable WHERE Uid='$uid'";
	if($uidv == $_SESSION['userid'])
	{
	$displayname = '<span style="color:#0000FF; line-height:180%">'."me:".'</span>';
	}
	else
	{
	$displayname = '<span style="color:#FF0000; line-height:180%">'.$oppname.'</span>'.":";
	}
	$previd = $uidv;
	echo $displayname;
}
else
{
echo "&nbsp;&nbsp;";
}
$nv = insertsmiley($selectchat['text']);
 echo $nv;
	echo "<br/>"; 
	$lasttime = strtotime($selectchat['datetime']);
}
if($lasttime < $now-60)
{
echo "<span style='color:#BBBBBB; font-size:11px'>Sent at ".date("h:i A",$lasttime)." on ".date("l",$lasttime)."<br/><span>";
}
echo "<span style='line-height:8px; font-size:8px'><br/></span>"; 
?>

<?php
function insertsmiley($t)
{
$smileys = array("heart.gif", "heartbroken.gif","angel.gif","please.gif","smile.gif","smile.gif", "grin.gif","grin.gif", "wink.gif","wink.gif","blush.gif","blush.gif", "love.gif","love.gif","cry.gif","cry.gif", "sad.gif","sad.gif",  "cool.gif","cool.gif", "angry.gif","angry.gif", "surprised.gif","surprised.gif", "sick.gif","sick.gif", "tongue.gif","tongue.gif");
$smileys_insert = array(":heart:",":brokenheart:",":angel:",":please:",":)",":-)",":d",":-d",";)",";-)",":[",":-[",":*",":-*",":((",":-((",":(",":-(","8(","8-(",":x",":-x",":0",":-0",":s",":-s",":p",":-p");
for($i=0; $i<sizeof($smileys);$i++)
{
$smileysimg[$i] = '<img src="chesstest/smileys/'.$smileys[$i].'" alt="" width="19" style="vertical-align:middle" />';
$smileys_insert_2[$i] = strtoupper($smileys_insert [$i]);
}
$newt = str_replace($smileys_insert,$smileysimg,$t);
$newt = str_replace($smileys_insert_2,$smileysimg,$newt);
return $newt;
}
?>