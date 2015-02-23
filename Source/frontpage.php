<?php
include_once("config.php");
include_once("include/dbopen.php");

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
<?php
include_once("include/dbclose.php");
?>
