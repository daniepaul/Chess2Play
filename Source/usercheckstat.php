<?php
include_once("config.php");
include_once("include/dbopen.php");


	$gameid1=$_REQUEST['gameid'];
	$usrid=$_SESSION['userid'];
	$chkuserstatus=mysql_query("select * from game where gameid='".$gameid1."'");
	$chkuserstatusrow=mysql_fetch_assoc($chkuserstatus);
	$uuiid=$chkuserstatusrow['whitePlayer'];
	$uuiid1=$chkuserstatusrow['blackPlayer'];
	$whitereq1=$chkuserstatusrow['whiteRequest'];
	$blackreq1=$chkuserstatusrow['blackRequest'];
	if($chkuserstatusrow['gameStatus'] == "F")
	{
	echo "F";
	}
	else if(($usrid==$uuiid) && ($blackreq1=='Q'))
	{
	echo "0";
	}
	else if(($usrid==$uuiid1) && ($whitereq1=='Q'))
	{
	echo "0";
	}
	else if(($usrid==$uuiid) && ($blackreq1=='D'))
	{
	if($whitereq1!='D')
	{
	echo "1";
	}
	else
	{
	echo "2";
	}
	}
	else if(($usrid==$uuiid1) && ($whitereq1=='D'))
	{
	if($blackreq1!='D')
	{
	echo "1";
	}
	else
	{
	echo "2";
	}
	}
	else if(($usrid==$uuiid) && ($whitereq1=='K'))
	{
	echo "3";
	}
	else if(($usrid==$uuiid1) && ($blackreq1=='K'))
	{
	echo "3";
	}
	else
	{
	echo "4";
	}
include_once("include/dbclose.php");
?>