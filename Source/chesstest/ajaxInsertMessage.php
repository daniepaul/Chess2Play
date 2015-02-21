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
$sid=$_SESSION['userid'];
$cid=$_REQUEST['cid'];
$room1=$_REQUEST['rm'];
$txt=$_REQUEST['txt'];
echo $queryval=mysql_query("INSERT INTO chatting(send_id,rec_id,text,room) VALUES ('$sid','$cid','$txt','$room1')"); 
echo "inserted";
?>