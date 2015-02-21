<?php ob_start();
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();

	$userid1 = $_REQUEST['userid'];
	$oppuid1 = $_REQUEST['oppuid'];
	$checkplayerplay=mysql_query("select * from game where whitePlayer='$oppuid1' and gameStatus='A'");
	if(mysql_num_rows($checkplayerplay)==0)
	{
	$displayinvite=mysql_query("SELECT gameid FROM game WHERE whitePlayer = '".$oppuid1."' and blackPlayer = '" . $userid1 . "' and gameStatus='I'");	
	$countdisplay=mysql_num_rows($displayinvite);
	$getid=mysql_fetch_assoc($displayinvite);
	if($countdisplay==1)
	{
	$inid = $getid['gameid'];
	$fname = "match".$inid.".txt";
	$fn = "chesstest/logs/".$fname;
	$handle = fopen($fn, 'w+');
	$acceptinvite=mysql_query("update game set gameStatus='A' where gameid='".$getid['gameid']."'");
	$deleteinvites=mysql_query("delete from game where (whitePlayer='$userid1' or blackPlayer='$userid1') and gameStatus='I'");	
	$checkplayedgame=mysql_query("select playedgame from userpoints where userid='$userid1'");
	if(mysql_num_rows($checkplayedgame)==0)
	{
	$insertgame=mysql_query("insert into userpoints(userid,playedgame) values('$userid1','1')");
	}
	else
	{
	$updategame=mysql_query("update userpoints set playedgame=playedgame+1 where userid='$userid1'");
	}
	header("Location:chesstest/test.php");
	}
	}
?>
<?
mysql_close($con);
?>
