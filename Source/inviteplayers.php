<?php
include_once("config.php");
include_once("include/dbopen.php");
?>
<script src="js/ajax/ajaxchess.js"></script>     
 <? 
	$userid = $_REQUEST['userid'];
	$opponentuserid = $_REQUEST['opid'];
	
	$selectinvite=mysql_query("select * from game where (whitePlayer='".$userid."' or whitePlayer='".$opponentuserid."') and (blackPlayer='".$opponentuserid."' or blackPlayer='".$userid."') and gameStatus='I'");	
	$selectinvitecount=mysql_num_rows($selectinvite);
	
	if($selectinvitecount == 0)
	{
	$insertinvite=mysql_query("insert into game (whitePlayer,blackPlayer,gameStatus,datePlayed) values('".$userid."','".$opponentuserid."','I',now())");	
	header("Location:livechess.php?opid=".$opponentuserid."&userid=".$userid);
	}
	else
	{
	header("Location:livechess.php?userid=".$userid);
	}
	
?>
<?php
include_once("include/dbclose.php");
?>

	
