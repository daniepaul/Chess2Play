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
include("config.php");
session_start();
ob_start();
$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or mysql_error("Cannot connect to the host");
$db=mysql_select_db(DB,$con) or mysql_error("Cannot select the specified database"); 
?>