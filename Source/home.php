<? 
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();
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
<?
mysql_close($con);
?>
