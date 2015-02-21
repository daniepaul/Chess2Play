<?php
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();
$userid = $_REQUEST['userid'];
$getloggedusers=mysql_query("select u.userid, u.username from log l, userprofile u where u.userid = l.userid and (u.userid <> '$userid')  and l.status = 'Y'");
if (mysql_num_rows($getloggedusers) != 0)
{
	while ($getloggedrow = mysql_fetch_assoc($getloggedusers))
	{
		echo"<img src=\"images/online.gif\" alt=\"\" title=\"\" border=\"0\" />&nbsp;";
		echo $getloggedrow['username'];
		$oppuserid=$getloggedrow['userid'];
     	$getinviteduser=mysql_query("select * from game where whitePlayer='$userid' and blackPlayer='$oppuserid' and gameStatus='I'");
		 $getinvitedusercount=mysql_num_rows($getinviteduser);
		 if($getinvitedusercount==0)
	 	{
	 	$getuserstatus=mysql_query("select * from game where (whitePlayer='$oppuserid' or blackPlayer='$oppuserid') and gameStatus='A' and whiteRequest='N' and blackRequest='N'");
	 	$getuserstatuscount=mysql_num_rows($getuserstatus);
	 	if($getuserstatuscount==1)
	 	{
		echo "&nbsp;<font color=\"#006699\"><b>Playing...<br></b></font>";
		}
		else
		{
		$getoppinvite=mysql_query("select * from game where whitePlayer='$oppuserid' and blackPlayer='$userid' and gameStatus='I' and whiteRequest='N' and blackRequest='N'");
		if(mysql_num_rows($getoppinvite)==1)
		{?>
	<a href="game.php?userid=<?=$userid?>&oppuid=<?=$getloggedrow['userid']?>" style="text-decoration:none" onclick="">&nbsp;<font color="#6600CC" size="3">Invite</font></a><br>
		<? }
		else
		{?>
	<a href="inviteplayers.php?userid=<?=$userid?>&opid=<?=$getloggedrow['userid']?>" style="text-decoration:none" onclick="">&nbsp;<font color="#6600CC" size="3">Invite</font></a><br>
		<? }
		}
		}
		else
		{
		echo "&nbsp;<font color=\"#FF0000\"><b>Invited<br></b></font>";
		}
	}
}
else
{
	echo "<font color=\"#993333\"><b> You only !</b></font>";
}
mysql_close($con);
?>
