<?php
include_once("config.php");
include_once("include/dbopen.php");


	$userid = $_REQUEST['userid'];
	$acceptinvite=mysql_query("select whitePlayer,blackPlayer from game where gameStatus='A' and whitePlayer='".$userid."'");
	if(mysql_num_rows($acceptinvite)!= 0)
	{
	$checkplayedgame1=mysql_query("select playedgame from userpoints where userid='".$userid."'");
	if(mysql_num_rows($checkplayedgame1)==0)
	{
	$insertgame1=mysql_query("insert into userpoints(userid,playedgame) values('".$userid."','1')");
	}
	else
	{
	$updategame=mysql_query("update userpoints set playedgame=playedgame+1 where userid='".$userid."'");
	}
	echo "0";
	}
	else
	{
$displayinvite=mysql_query("SELECT u.username,u.userid FROM userprofile u,game i WHERE u.userid = i.whitePlayer and i.blackPlayer = '".$userid."' and gameStatus='I' group by u.username");
  if(mysql_num_rows($displayinvite) != 0)
  {
  while($displayinviterow =mysql_fetch_assoc($displayinvite)){
	$opponenid=$displayinviterow['userid'];
  $checkoppplay=mysql_query("select * from game where (whitePlayer='".$opponenid."' or blackPlayer='".$opponenid."') and gameStatus='A'");
  if(mysql_num_rows($checkoppplay)==0)
  {
  $oppuserstatus=mysql_query("select * from log where userid='".$opponenid."' and status='Y'");
  if(mysql_num_rows($oppuserstatus)==1)
  {
echo $displayinviterow['username']; ?>&nbsp;<a href="game.php?userid=<?=$userid?>&oppuid=<?=$displayinviterow['userid']?>" style="text-decoration:none" onclick="">Accept</a><br>
 <? } } } }
 else
 {?>
 <font color="#FF0000"><b><? echo "No request yet !";?></b></font>
 <? } }
 include_once("include/dbclose.php");
?>