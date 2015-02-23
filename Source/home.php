<?php
include_once("config.php");
include_once("include/dbopen.php");

if($_SESSION['userid']=="")
{
header("Location:index.php");
}
?>
<html>
<head>
<title>Home Page</title>
</head>

<frameset rows="10%,90%" framespacing="0" frameborder="no" border="0">
  <frame src="sessionuser.php" scrolling="NO">
  <frame src="frontpage.php" scrolling="NO">
</frameset><noframes></noframes>
</html>
<?php
include_once("include/dbclose.php");
?>
