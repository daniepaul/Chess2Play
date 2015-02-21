<? ob_start();
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();

$userid = $_REQUEST['userid'];
$gameid=$_SESSION['gameid'];
$updatestatuslog=mysql_query("update log set status='N' where userid='$userid'");
$usergamestatus=mysql_query("select * from game where gameid='$gameid'");
$usergamestatusrow=mysql_fetch_assoc($usergamestatus);
$uuid=$usergamestatusrow['whitePlayer'];
$uuid1=$usergamestatusrow['blackPlayer'];
$whitereg=$usergamestatusrow['whiteRequest'];
$blackreg=$usergamestatusrow['blackRequest'];
if($userid==$uuid)
{
	if(($blackreg=='N')&&($whitereg=='N'))
	{
	$updatepoints=mysql_query("update userpoints set losegame=losegame+1 where userid='$uuid'");
	$updateopppoints=mysql_query("update userpoints set wongame=wongame+1,points=points+2 where userid='$uuid1'");
	$updatequit=mysql_query("update game set whiteRequest='Q',gameStatus='F',won='$uuid1' where gameid='$gameid'");
	}
	if(($blackreg=='D')&&($whitereg!='D'))
	{
	$updatepoints=mysql_query("update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid'");
	$updateopppoints=mysql_query("update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid1'");
	$updatequit=mysql_query("update game set whiteRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
	}
}
else
{
	if(($blackreg=='N')&&($whitereg=='N'))
	{
	$updatepoints=mysql_query("update userpoints set losegame=losegame+1 where userid='$uuid1'");
	$updateopppoints=mysql_query("update userpoints set wongame=wongame+1,points=points+2 where userid='$uuid'");
	$updatequit=mysql_query("update game set blackRequest='Q',gameStatus='F',won='$uuid' where gameid='$gameid'");
	}
	if(($whitereg=='D') && ($blackreg!='D'))
	{
	$updatepoints=mysql_query("update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid1'");
	$updateopppoints=mysql_query("update userpoints set drawgame=drawgame+1,points=points+1 where userid='$uuid'");
	$updatequit=mysql_query("update game set blackRequest='D',gameStatus='F',won='0' where gameid='$gameid'");
}
}
$deleteinvites=mysql_query("delete from game where (whitePlayer='$userid' or blackPlayer='$userid') and gameStatus='I'");
$deletechatmsg=mysql_query("delete from chatting where (send_id='$userid' or rec_id='$userid')");
session_destroy();
mysql_close($con);
header("Location:../index.php");
?>

