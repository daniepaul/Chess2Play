<?php
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();

		if(!isset($_SESSION['userid']))
		{
			session_destroy();
			header("Location:index.php");
		}
	?>
<html>
<head>
<script src="js/ajax/ajaxchess.js"></script>
</head>
    <body bgcolor="#CCCCCC">
    <br />
        <table width="100%">
            <tr>
            	<td>
                <a href="livechess.php?userid=<?=$_SESSION['userid'];?>" style="text-decoration:none">Play Live chess</a>
                </td>
		    </tr>
          </table>
    </body>
</html>
<?
mysql_close($con);
?>
