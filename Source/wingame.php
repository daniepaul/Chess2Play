<? ob_start();
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();

$userid = $_SESSION['userid'];
$gameid=$_SESSION['gameid'];
$usergamestatus=mysql_query("select * from game where gameid='$gameid'");
$usergamestatusrow=mysql_fetch_assoc($usergamestatus);
$uuid=$usergamestatusrow['whitePlayer'];
$uuid1=$usergamestatusrow['blackPlayer'];
$whitereg=$usergamestatusrow['whiteRequest'];
$blackreg=$usergamestatusrow['blackRequest'];
$uid = "";
$uid1 = "";
if($_REQUEST['mycolor']=="b")
{
$uid = $uuid1;
$uid1 = $uuid;
}
else
{
$uid1 = $uuid1;
$uid = $uuid;
}
if($_REQUEST['action']=="finish")
{
$updatepoints=mysql_query("update userpoints set losegame=losegame+1 where userid='$uid'");
$updateopppoints=mysql_query("update userpoints set wongame=wongame+1,points=points+2 where userid='$uid1'");

$updatequit=mysql_query("update game set whiteRequest='N',blackRequest='N',gameStatus='F',won='$uid1' where gameid='$gameid'");
}


mysql_close($con);
?>

