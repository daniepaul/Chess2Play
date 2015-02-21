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
$uid = $_REQUEST['uid'];

$q=mysql_query("SELECT * FROM chatting WHERE rec_id='$uid' and Cstatus='N'");
if(mysql_num_rows($q)>0)
{
$room = mysql_result($q,0,"room");
$fromid = mysql_result($q,0,"send_id");
$r=mysql_query("SELECT * FROM userprofile WHERE userid='".mysql_result($q,0,"send_id")."'");
$recivername =  mysql_result($r,0,"username");
echo $room."##COLOURZ##".$recivername."##COLOURZ##".$fromid;
}
?>