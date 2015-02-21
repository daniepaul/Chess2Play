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
include("includes/init.php");
?>
<html>
<head>
<title><?php echo SITE_NAME; ?></title>
<?php if($page=="chat") { ?>
<?php include ('functions.php'); ?>
<link href="css/colourzchat.css" rel="stylesheet" type="text/css"/>
<!--[if IE]>
    <link href="css/colourzchat_ie.css" rel="stylesheet" type="text/css"/>
<![endif]-->
<script type="text/javascript">
var universaluser = '<?php echo $_SESSION['uid']; ?>';
</script>
<script type="text/javascript" src="js/colourzchat.js"></script>
<?php } ?>
</head>
<body <?php if($page=="chat") { ?>onload="checkChat();adjustchat();"<?php } ?>>
