<? ob_start();
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();

$userid=$_SESSION['userid'];
if($userid == "")
{
header("Location:../index.php");
}
$gameplayed1=mysql_query("select playedgame,wongame,drawgame,losegame,points from userpoints where userid='$userid'");
$gameplayed=mysql_fetch_assoc($gameplayed1);

$display=mysql_query("select gameid,whitePlayer,blackPlayer,whiteRequest,blackRequest from game where (whitePlayer='$userid' or blackPlayer='$userid') and gameStatus='A'");
$diplayrow=mysql_fetch_assoc($display);
$uid=$diplayrow['whitePlayer'];
$uid1=$diplayrow['blackPlayer'];
$inviteid=$diplayrow['gameid'];
$whitereg=$diplayrow['whiteRequest'];
$blackreg=$diplayrow['blackRequest'];
$_SESSION['gameid']=$inviteid;
$fname = "match".$inviteid.".txt";
if($uid != $userid)
{
$displayopp=mysql_query("select userid,username from userprofile where userid='$uid'");
$playercolor = "w";
}
else
{
$displayopp=mysql_query("select userid,username from userprofile where userid='$uid1'");
$playercolor = "b";
}
$diplayrowopp=mysql_fetch_assoc($displayopp);
$chatterid=$diplayrowopp['userid'];
if($userid>$chatterid)
{
$room1=$chatterid.'_'.$userid;
}
else
{
$room1=$userid.'_'.$chatterid;
}

//quit from the game
if($_REQUEST['action'] == "cancel")
{
$requestquit="update game set ";
if($uid == $userid)
{
if($blackreg=='N')
{
$updatepoints=mysql_query("update userpoints set losegame=losegame+1 where userid='$uid'");
$updateopppoints=mysql_query("update userpoints set wongame=wongame+1,points=points+2 where userid='$uid1'");
$requestquit1=$requestquit."whiteRequest='Q',gameStatus='F',won='$uid1' where gameid='$inviteid'";
}
}
else
{
if($whitereg=='N')
{
$updatepoints=mysql_query("update userpoints set losegame=losegame+1 where userid='$uid1'");
$updateopppoints=mysql_query("update userpoints set wongame=wongame+1,points=points+2 where userid='$uid'");
$requestquit1=$requestquit."blackRequest='Q',gameStatus='F',won='$uid' where gameid='$inviteid'";
}
}
mysql_query($requestquit1);
header("Location:../livechess.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chess</title>
<script src="../js/ajax/ajaxchess.js"></script>
<link href="css/colourzchat.css" rel="stylesheet" type="text/css"/>
<script src="js/colourzchat.js"></script>
<script type="text/javascript" src="bgfade.js"></script>
<script type="text/javascript">
function confirmSubmit()
{
var agree=confirm("Do you surely want to quit?");
if (agree)
	return true ;
else
	return false ;
}
function confirmSubmit1() {
var agree1=confirm("Do you want to request draw?");
var xmlHttp;
if (agree1)
{
     xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null)
	  {
		  alert ("Your browser does not support AJAX!");
		  return;
	  } 
		var url="../drawgame.php";
		url=url+"?game=draw";
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
else
{
return false;					
}
}
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}
</script>
<script type="text/javascript">
var RevertToColor = "";
var SelectedCell = "noneid";
var playerColor = "w";
var MyColor = "<?php echo $playercolor; ?>";
var clickedid = "";
var clickedColor = "";
var clickedPiece = "";
var clickedi = "";
var clickedj = "";
var PieceSelected = false;
var FirstMove = "";
var filename = "<?php echo $fname;?>";
var Stricking = false;
var StrickingComplete = false;
var waittime = 800;
var PreviousNotation = "";


function CR(color,coin,i,j)
{
coinRelation = new Array(color,coin,i,j);
return coinRelation;
}

function RA(color,coin,i,j)
{
RuleRelation = new Array(color,coin,i,j);
return RuleRelation;
}

//possible movements
var rulesArray = new Array(RA("b","p","0","-1"), RA("w","p","0","+1"), RA("a","r","0","n"), RA("a","r","n","0"), RA("a","r","0","-n"), RA("a","r","-n","0"), RA("a","b","n","n"), RA("a","b","-n","-n"), RA("a","b","n","-n"), RA("a","b","-n","n"), RA("a","n","1","2"), RA("a","n","1","-2"), RA("a","n","-1","2"), RA("a","n","-1","-2"), RA("a","n","2","1"), RA("a","n","2","-1"), RA("a","n","-2","1"), RA("a","n","-2","-1"), RA("a","q","n","0"), RA("a","q","0","n"), RA("a","q","n","n"), RA("a","q","-n","-n"), RA("a","q","n","-n"), RA("a","q","-n","n"), RA("a","q","-n","0"), RA("a","q","0","-n"),RA("a","k","1","0"), RA("a","k","0","1"), RA("a","k","1","1"), RA("a","k","-1","-1"), RA("a","k","1","-1"), RA("a","k","-1","1"), RA("a","k","-1","0"), RA("a","k","0","-1"));

//default positions
var initialLocation = new Array(CR("b","r","1","8"),CR("b","n","2","8"),CR("b","b","3","8"),CR("b","q","5","8"),CR("b","k","4","8"),CR("b","b","6","8"),CR("b","n","7","8"),CR("b","r","8","8"),CR("b","p","1","7"),CR("b","p","2","7"),CR("b","p","3","7"),CR("b","p","4","7"),CR("b","p","5","7"),CR("b","p","6","7"),CR("b","p","7","7"),CR("b","p","8","7"),CR("w","r","1","1"),CR("w","n","2","1"),CR("w","b","3","1"),CR("w","q","5","1"),CR("w","k","4","1"),CR("w","b","6","1"),CR("w","n","7","1"),CR("w","r","8","1"),CR("w","p","1","2"),CR("w","p","2","2"),CR("w","p","3","2"),CR("w","p","4","2"),CR("w","p","5","2"),CR("w","p","6","2"),CR("w","p","7","2"),CR("w","p","8","2"));


function ClickedCell(id)
{
if(MyColor == playerColor)
{
document.getElementById("noneid").innerHTML = "";
childElement = document.getElementById(id).childNodes[0];
	//check whether the clicked cell contains coins
	if(childElement != "[object Text]" && document.getElementById(id).innerHTML != "&nbsp;")
	{
	ChildElementId = childElement.id;
		if(PieceSelected == true && ChildElementId == clickedid)
		{
		document.getElementById(SelectedCell).style.background = RevertToColor;
		clickedid = "none";
		PieceSelected = false;
		}
		else
		{
		id_split = ChildElementId.split("");
			
			//check the clicked coin color with the color selected by the player 
			if(id_split[0] == playerColor && PieceSelected == false)
			{
			document.getElementById(SelectedCell).style.background = RevertToColor;
			SelectedCell = id;
			RevertToColor = document.getElementById(id).style.background;
			document.getElementById(id).style.background = "#FFFF00";
			clickedid = ChildElementId;
			clickedColor = id_split[0];
			clickedPiece = id_split[1];
			clickedi = id_split[2];
			clickedj = id_split[3];	
			FirstMove = id_split[4];
			PieceSelected = true;
			}
			else if(id_split[0] != playerColor && PieceSelected == true)
			{
				Stricking = true;
				MoveCell(id);
			}
		}
	}
	else if(PieceSelected == true)
	{
	MoveCell(id);
	}
	}
}

//to move the coins
function MoveCell(id)
{
id_split = id.split("");
newclickedi = id_split[4];
newclickedj = id_split[5];
moveArray = new Array();
moveArray = FindLocation(clickedColor,clickedPiece,clickedi,clickedj);
MoveApproved = false;
for(var i=0; i<moveArray.length; i++)
{
//check the move is valid or not
if(moveArray[i] == newclickedi+";"+newclickedj)
{
MoveApproved = true;
break;
}
}
if(MoveApproved)
{
if(Stricking) {StrickingComplete = true;}
msg = CreateNotation(clickedColor,clickedPiece,clickedi,clickedj,newclickedi,newclickedj,StrickingComplete);
name = " ";
if(clickedPiece == "k")
{
name = "name='"+clickedColor+"king'";
}
document.getElementById(id).innerHTML = "<img src='images/"+clickedColor+clickedPiece+".gif' id='"+clickedColor+clickedPiece+newclickedi+newclickedj+"' "+name+" />";
document.getElementById(SelectedCell).innerHTML = "&nbsp";
document.getElementById(SelectedCell).style.background = RevertToColor;
Stricking = false;
StrickingComplete = false;
clickedid = "none";
PieceSelected = false;
	if(playerColor == "b") { playerColor = "w";	}
	else { playerColor = "b";	}
	ajax_write("wtf.php?notation=" + msg +"&f="+filename);
	document.getElementById("displayStatus").innerHTML = "Opponent move !";
}
else
{
document.getElementById("noneid").innerHTML = "Invalid Move";
}
}

/* Creating the notation */
function CreateNotation(clickedColor,clickedPiece,clickedi,clickedj,newclickedi,newclickedj,stricking_Nature)
{
Name_Array = new Array("a","b","c","d","e","f","g","h");
if(clickedPiece == "p") clickedPiece = "";
operat = "-";
if(stricking_Nature) {operat = "X";}
notation = clickedPiece.toUpperCase()+Name_Array[clickedi-1]+clickedj+operat+Name_Array[newclickedi-1]+newclickedj;
if(clickedColor == "b")
{
notation = notation +"~";
}
else
{
notation = notation +" ";
}
return notation;
}

/* Request for Writing the Notation */
function ajax_write(url)
{
	if(window.XMLHttpRequest){
		xmlhttp2=new XMLHttpRequest();
		if(xmlhttp2.overrideMimeType){
			xmlhttp2.overrideMimeType('text/xml');
		}
	} else if(window.ActiveXObject){
		try{
			xmlhttp2=new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try{
				xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e){
			}
		}
	}

	if(!xmlhttp2) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}

	xmlhttp2.open('GET',url,true);
	xmlhttp2.send(null);
}

//to check the path
function isOnPath(id)
{
childElement = document.getElementById(id).childNodes[0];
	if(childElement != "[object Text]" && document.getElementById(id).innerHTML != "&nbsp;")
	{
	return true;
	}
	else
	{
	return false;
	}
}


function FindLocation(color,coin,ii,jj)
{
ii = parseInt(ii);
jj = parseInt(jj);
//Initialize the ij array set
resultLocation = new Array();
var j=0;
if(coin != "p")
{
color = "a";
	for(var i=0; i<rulesArray.length; i++)
	{	
		/* Check if the supplied colour and coin match in the array */
		if(rulesArray[i][0] == color && rulesArray[i][1] == coin)
		{
			//Check the new i value
			if(rulesArray[i][2] == "n")
			{
					if(rulesArray[i][3] == "n")
					{	
						//two dimensional for loop is used to increase i and j simultaeneously
						for(var e=jj+1,d=ii+1; d<=8 && e<=8; e++,d++)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
							if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
					else if(rulesArray[i][3] == "-n")
					{
						for(var e=jj-1,d=ii+1; d<=8 && e>=1; e--,d++)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
					else
					{
						e = jj+parseInt(rulesArray[i][3]);
						for(var d=ii+1; d<=8; d++)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
		
			}
			else if(rulesArray[i][2] == "-n")
			{
					if(rulesArray[i][3] == "n")
					{
						for(var e=jj+1,d=ii-1; d>=1 && e<=8; e++,d--)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
					else if(rulesArray[i][3] == "-n")
					{
						for(var e=jj-1,d=ii-1; d>=1 && e>=1; e--,d--)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
					else
					{
						e = jj+parseInt(rulesArray[i][3]);
						for(var d=ii-1; d>=1; d--)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
			}
			else
			{
			d = ii+parseInt(rulesArray[i][2]);
					if(rulesArray[i][3] == "n")
					{
						for(var e=jj+1; e<=8; e++)
						{
						
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
					else if(rulesArray[i][3] == "-n")
					{
						for(var e=jj-1; e>=1; e--)
						{
						resultLocation[j] = d.toString()+";"+e.toString();
						j = j+1;
						if(isOnPath("cell"+d.toString()+e.toString()))
							{
							break;
							}
						}
					}
					else
					{	
					e = jj+parseInt(rulesArray[i][3]);
					resultLocation[j] = d.toString()+";"+e.toString();
					j = j+1;
					}
			}
			
			
		}
	}
}
else
{

	if(color == "b")
	{
		if(!isOnPath("cell"+ii.toString()+(jj-1).toString()))
		{
			resultLocation[j] = ii.toString()+";"+(jj-1).toString();
			j = j+1;
		}
		if(ii != 8)
		{
		if(isOnPath("cell"+(ii+1).toString()+(jj-1).toString()))
		{
			resultLocation[j] = (ii+1).toString()+";"+(jj-1).toString();
			j = j+1;
		}
		}
		if(ii != 1)
		{
		if(isOnPath("cell"+(ii-1).toString()+(jj-1).toString()))
		{
			resultLocation[j] = (ii-1).toString()+";"+(jj-1).toString();
			j = j+1;
		}
		}
		if(!isOnPath("cell"+ii.toString()+(jj-2).toString()) && !isOnPath("cell"+ii.toString()+(jj-1).toString()) && FirstMove == "i")
		{
			resultLocation[j] = ii.toString()+";"+(jj-2).toString();
			j = j+1;
		}
	}
	else
	{
		if(!isOnPath("cell"+ii.toString()+(jj+1).toString()))
		{
			resultLocation[j] = ii.toString()+";"+(jj+1).toString();
			j = j+1;
		}
		if(ii != 8)
		{
		if(isOnPath("cell"+(ii+1).toString()+(jj+1).toString()))
		{
			resultLocation[j] = (ii+1).toString()+";"+(jj+1).toString();
			j = j+1;
		}
		}
		if(ii != 1)
		{
		if(isOnPath("cell"+(ii-1).toString()+(jj+1).toString()))
		{
			resultLocation[j] = (ii-1).toString()+";"+(jj+1).toString();
			j = j+1;
		}
		}
		if(!isOnPath("cell"+ii.toString()+(jj+2).toString())  && !isOnPath("cell"+ii.toString()+(jj+1).toString())  && FirstMove == "i")
		{
			resultLocation[j] = ii.toString()+";"+(jj+2).toString();
			j = j+1;
		}
	}
	
}
return resultLocation;
}


//initialize the cells with the coins image
function initGame()
{
for(var i=0; i<initialLocation.length; i++)
{
initializeCoin = initialLocation[i];
CoinColor = initializeCoin[0];
CoinName = initializeCoin[1];
Coini = initializeCoin[2];
Coinj = initializeCoin[3];
name = " ";
if(CoinName == "k")
{
name = "name='"+CoinColor+"king'";
}
setImage = "<img src='images/"+CoinColor+CoinName+".gif' id='"+CoinColor+CoinName+Coini+Coinj+"i' "+name+" />";

document.getElementById("cell"+Coini+Coinj).innerHTML = setImage;

}
}

function ifcheck()
{
name = MyColor+"king";
ele = document.getElementsByName(name)[0].id;
id_split = ele.split("");
i = id_split[2];
j= id_split[3];
alert(i+", "+j);
return true;
}


/* Request for Reading Content */
function ajax_read(url) {
	if(window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
		if(xmlhttp.overrideMimeType){
			xmlhttp.overrideMimeType('text/xml');
		}
	} else if(window.ActiveXObject){
		try{
			xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try{
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e){
			}
		}
	}

	if(!xmlhttp) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}

	xmlhttp.onreadystatechange = function() {
	if (xmlhttp.readyState==4) {
		FullMessage = xmlhttp.responseText;
		if(PreviousNotation != FullMessage)
		{
		splitNotation = FullMessage.split("\n");
		lastNotation = splitNotation[splitNotation.length-1];
		if(lastNotation == "")lastNotation = splitNotation[splitNotation.length-2];
		LastMovementArray = lastNotation.split(" ");
		LastMovement = LastMovementArray[LastMovementArray.length-1];
		LastMovedColor = "b";
			if(LastMovement == "")
			{
			LastMovement = LastMovementArray[LastMovementArray.length-2];
			LastMovedColor = "w";
			}
			
			if(LastMovedColor != MyColor)
			{
			SplitLastMovement = LastMovement.split("");
			if(SplitLastMovement[2]=="-" || SplitLastMovement[2]=="X")
			{
			fromI = SplitLastMovement[0];
			fromJ = SplitLastMovement[1];
			toI = SplitLastMovement[3];
			toJ = SplitLastMovement[4];
			}
			else
			{
			fromI = SplitLastMovement[1];
			fromJ = SplitLastMovement[2];
			toI = SplitLastMovement[4];
			toJ = SplitLastMovement[5];
			}
			fromI = convertABC(fromI);
			toI = convertABC(toI);			
			InitiateMovement(fromI,fromJ,toI,toJ);
			}	
		}
		PreviousNotation = FullMessage;
		document.getElementById("displayNotation").innerHTML = FullMessage;
		zeit = new Date(); 
		ms = (zeit.getHours() * 24 * 60 * 1000) + (zeit.getMinutes() * 60 * 1000) + (zeit.getSeconds() * 1000) + zeit.getMilliseconds(); 
		intUpdate = setTimeout("ajax_read('logs/"+filename+"?x=" + ms + "')", waittime)
		}
	}

	xmlhttp.open('GET',url,true);
	xmlhttp.send(null);
}
		zeit = new Date(); 
		ms = (zeit.getHours() * 24 * 60 * 1000) + (zeit.getMinutes() * 60 * 1000) + (zeit.getSeconds() * 1000) + zeit.getMilliseconds(); 
var intUpdate = setTimeout("ajax_read('logs/"+filename+"')", waittime);

function SelectColor(v)
{
MyColor = v;
alert(MyColor);
}

function convertABC(v)
{
r = 0;
switch(v)
{
case "a": r=1; break;
case "b": r=2; break;
case "c": r=3; break;
case "d": r=4; break;
case "e": r=5; break;
case "f": r=6; break;
case "g": r=7; break;
case "h": r=8; break;
}
return r;
}

function InitiateMovement(fromI,fromJ,toI,toJ)
{
checkid = "cell"+toI+toJ;
childElement = document.getElementById(checkid).childNodes[0];
ChildElement = " ";
	//check whether the clicked cell contains coins
	if(childElement != "[object Text]" && document.getElementById(checkid).innerHTML != "&nbsp;")
	{
	ChildElement = childElement.name;
	}
document.getElementById("cell"+toI+toJ).innerHTML = document.getElementById("cell"+fromI+fromJ).innerHTML;
document.getElementById("cell"+fromI+fromJ).innerHTML = "&nbsp;";
elementId = "cell"+toI+toJ;
endBgColor = document.getElementById("cell"+toI+toJ).style.backgroundColor;
endBgColor = endBgColor.replace("rgb(","");
endBgColor = endBgColor.replace(")","");
endBgColor = endBgColor.replace(" ","");
endBgColor = endBgColor.replace(" ","");
ebc = endBgColor.split(",");
endBgColor1 = RGBToHex(ebc);
if (navigator.userAgent.indexOf('MSIE') !=-1)
{
NLBfadeBg( elementId, '#FF9900', endBgColor, 2000 );
}
else
{
NLBfadeBg( elementId, '#FF9900', endBgColor1, 2000 );
}
if(ChildElement == MyColor+"king")
{
alert("You Lost the Game. Opponent Won");
MyColor = " ";
finishgame();
}
	if(playerColor == "b") { playerColor = "w";	}
	else { playerColor = "b";	}
	document.getElementById("displayStatus").innerHTML = "Your move !";
	
}

function finishgame()
{
var xmlHttp;
xmlHttp=GetXmlHttpObject();
	   if (xmlHttp==null)
	  {
		  alert ("Your browser does not support AJAX!");
		  return;
	  } 
		var url="../wingame.php";
		url=url+"?action=finish&mycolor=<?php echo $playercolor; ?>";
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}
/*function initial_read() {
url = "logs/"+filename;
notations="a";
	if(window.XMLHttpRequest){
		xmlhttp3=new XMLHttpRequest();
		if(xmlhttp3.overrideMimeType){
			xmlhttp3.overrideMimeType('text/xml');
		}
	} else if(window.ActiveXObject){
		try{
			xmlhttp3=new ActiveXObject("Msxml2.XMLHTTP");
		} catch(e) {
			try{
				xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e){
			}
		}
	}

	if(!xmlhttp3) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}

	xmlhttp3.onreadystatechange = function() {
	if (xmlhttp3.readyState==4) {
		GEtting the response by reading the log file
		notations = xmlhttp3.responseText;
		}
	}

	xmlhttp3.open('GET',url,true);
	xmlhttp3.send(null);
	return notations;
}

function SavedMovements()
{
notations = initial_read();
if(notations != "")
{
		Getting the last move pair
		splitNotation = notations.split("\n");

		for(var i=0; i<splitNotation.length;i++)
		{
		lastNotation = splitNotation[i];
		If the last move is black it will set a extra line and will return 0 in previous line so we move to one level up
		if(lastNotation != "")
		{
		To get the last half move and finding the last moved color
		LastMovementArray = lastNotation.split(" ");
		for(var j=0; j<LastMovementArray.length; j++)
		{
		LastMovement = LastMovementArray[j];
		if(LastMovement != "")
		{
		if(j==0)LastMovedColor = "w";
		else LastMovedColor = "b";
		SplitLastMovement = LastMovement.split("");
			if the 3rd location is a '-' or 'x' the move is by  a pawn else it will have one more char in front to indicate the coin
			if(SplitLastMovement[2]=="-" || SplitLastMovement[2]=="X")
			{
			fromI = SplitLastMovement[0];
			fromJ = SplitLastMovement[1];
			toI = SplitLastMovement[3];
			toJ = SplitLastMovement[4];
			}
			else
			{
			fromI = SplitLastMovement[1];
			fromJ = SplitLastMovement[2];
			toI = SplitLastMovement[4];
			toJ = SplitLastMovement[5];
			}
			Converting the ABC values of notation to i location
			fromI = convertABC(fromI);
			toI = convertABC(toI);		
			Initializing the movement	
			InitiateMovement(fromI,fromJ,toI,toJ);
			}	
			}
		}}
}
PreviousNotation = notations;
}
*/
</script>
</head>
<body onload="userstatus(<?php echo $diplayrow['gameid'];?>); loadchild('<?php echo $room1; ?>','<?php echo $userid;?>','<?php echo $diplayrowopp['username']; ?>','<?php echo $diplayrowopp['userid']; ?>');">
<table width="200" align="left">
<tr>
<td>
<table width="200" align="right" border="1" style="background-color:#99CC99">
<tr valign="top">
<td align="center">
<b>Chess Game</b>
</td>
</tr>
<tr valign="top">
<td>
&nbsp;<b><? echo $_SESSION['username'];?></b>&nbsp;Vs&nbsp;<b><? echo $diplayrowopp['username'];?></b>
</td>
</tr>
<tr valign="top">
<td>
<a href="#" onClick="return confirmSubmit1()">Request draw</a>&nbsp;&nbsp;<a href="test.php?action=cancel" onClick="return confirmSubmit()">Resign</a>&nbsp;</td>
</tr>

<tr valign="top">
<td>
Your Color&nbsp;:&nbsp;<b><?php if($playercolor=="w"){echo "White";}else{echo "Black";}?></b>
</td>
</tr>

<tr valign="top">
<td>
Playing status&nbsp;:
</td>
</tr>

<tr valign="top">
<td>
<div style="float:right; margin-right:20px; width:120px; font-size:12pt; font-weight:bold" id="displayStatus"></div>
</td>
</tr>

</table>
</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td>
<table width="200" align="left">
<tr>
<td align="left" border="1">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Game History</b>
</td>
</tr>
<tr>
<td align="left">
<div style="position:absolute; float:left; margin-left:20px; width:130px; word-spacing:20px;" id="displayNotation"></div>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="200" align="right">
<tr>
<td height="10px">
</td>
</tr>
<tr>
<td height="10px">
<table width="200" align="right" border="1" style="background-color:#FFCC99">
<tr valign="top">
<td align="center">
<b>Game Points</b>
</td>
</tr>
<tr valign="top">
<td>
Over all&nbsp;:&nbsp;<?php echo $gameplayed['points'];?>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td height="10px">
</td>
</tr>
<tr>
<td>
<table width="200" align="right" border="1" style="background-color:#99CCFF">
<tr valign="top">
<td align="center">
<b>Game Played</b>
</td>
</tr>
<tr valign="top">
<td>
Total&nbsp;:&nbsp;<?php echo ($gameplayed['playedgame'])-1;?>&nbsp;&nbsp;Playing game&nbsp;:&nbsp;<?php echo $gameplayed['playedgame'];?>
</td>
</tr>
<tr valign="top">
<td>
Won&nbsp;:&nbsp;<?php echo $gameplayed['wongame'];?>
</td>
</tr>
<tr valign="top">
<td>
Lose&nbsp;:&nbsp;<?php echo $gameplayed['losegame'];?>
</td>
</tr>

<tr valign="top">
<td>
Draw&nbsp;:&nbsp;<?php echo $gameplayed['drawgame'];?>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<table align="right">
<tr>
<td>
<div class="chatpanel" align="right" id="chatpanel"></div>
<img src="images/close.png" style="display:none" /> <img src="images/minimize.png" style="display:none" />
<img src="smileys/mini_smile.gif" style="display:none" />
</td>
</tr>
</table> 
</td>
</tr>
</table>
<table align="center" width="500" height="500" style="border:1px #CCCCCC solid">
  <?php 
$color[0] = "#FFFFFF";
$color[1] = "#CCCCCC";
if($playercolor == 'b')
{ 
for($j=1; $j<= 8; $j++) { ?>
  <tr>
    <? for($i=1; $i<= 8; $i++) { $color_code = ($i+$j)%2;?>
    <td width="12.5%" height="12.5%" style="cursor:pointer; background:<?=$color[$color_code];?>" align="center" valign="middle" id="cell<?=$i?><?=$j?>" onclick="ClickedCell(this.id);" ondblclick="ClickedCell(this.id);">&nbsp;</td>
    <? } ?>
  </tr>
<?php } }else {
for($j=8; $j>= 1; $j--) { ?>
  <tr>
    <? for($i=8; $i>= 1; $i--) { $color_code = ($i+$j)%2;?>
    <td width="12.5%" height="12.5%" style="cursor:pointer; background:<?=$color[$color_code];?>" align="center" valign="middle" id="cell<?=$i?><?=$j?>" onclick="ClickedCell(this.id);" ondblclick="ClickedCell(this.id);">&nbsp;</td>
    <? } ?>
  </tr>
  <?php } }?>
</table>
<script type="text/javascript">initGame();</script>
<div id="noneid" align="center" style="color:#FF0000; font-weight:bold"></div>
</body>
</html>
