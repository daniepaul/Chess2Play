/****************

Company: Colourz Technologies 
version: ColourzChat V1.0
description: chatting window

--------------------

created by: Senthil Kumar P
created on:  
completed on:
comments:
------------------
tested by: Danielpaulrajsing
tested on:
test comment:
----------------------------
updated by: Danielpaulrajsing
updated on:
update completed on:



****************/

function loadchild(roomdata,SenderId,Reciever,RecieverId)
{
//create the object for the display div
var obj = document.getElementById("chatpanel");
var maindiv="maindiv_"+ roomdata;
var chatTitle="chatTitle_"+ roomdata;
var showConversation="showConversation_"+ roomdata;
var MessageBox="MessageBox_"+ roomdata;
if(document.getElementById(maindiv))
{
return false;
}
else
{
	var objmaindiv=document.createElement('div');
	objmaindiv.setAttribute('id',maindiv);
	objmaindiv.setAttribute('align','left');
	obj.appendChild(objmaindiv);
	
	//create thre title div tag
	var imagebutton_close = ' ';
	var imagebutton_min = ' ';
	var objchattitlediv=document.createElement('div');
	objchattitlediv.setAttribute('id',chatTitle);
	objchattitlediv.setAttribute('class','chatTitle');
	objchattitlediv.className='chatTitle';
	objchattitlediv.setAttribute('align','left');
	objchattitlediv.innerHTML=imagebutton_close+imagebutton_min+"Chat with "+ Reciever;
	objmaindiv.appendChild(objchattitlediv);
	
	
	//create the conversation div tag
	var objconversationdiv=document.createElement('div');
	objconversationdiv.setAttribute('id',showConversation);
	objconversationdiv.className='showconversation';
	objconversationdiv.setAttribute('class','showconversation');
	objconversationdiv.setAttribute('align','left');
	objmaindiv.appendChild(objconversationdiv);
	
	//create the message box
	var smileydiv = '<div class="smilybox" id="smilybox_'+roomdata+'" align="right" style="display:none"></div>'
	var smileybox = '<img src="chesstest/smileys/smile.gif" alt=":)" style="vertical-align:middle; float:right" title="Smileys" onclick="showsmily(\'smilybox_'+roomdata+'\')" class="smily_img" />';
	var objinputHTML = '<div class="bottom_civ">'+smileydiv+smileybox+'<input type="text" placeholder="Enter your message and press enter." id="'+MessageBox+'" class="MessageBox" value="" onkeyup="keyup(event.keyCode,\''+MessageBox+'\',\''+SenderId+'\',\''+RecieverId+'\',\''+roomdata+'\')" /></div>';
	objmaindiv.innerHTML = objmaindiv.innerHTML+objinputHTML;
	createsmileys(MessageBox,'smilybox_'+roomdata);
	getChat(roomdata,showConversation);
}
}

//Create Smileys

function createsmileys(id,s)
{
	xmlHttp4=GetXmlHttpObject();
	 if (xmlHttp4==null){
  		  alert ("Your browser does not support AJAX!");
		  return;
	 } 
	 var url="chesstest/getsmiley.php?id="+id+"&s="+s+"&ms="+getAjaxTime();
		xmlHttp4.onreadystatechange=function stateChangedcreatesmiley(){ 
		if (xmlHttp4.readyState==4){ 
			document.getElementById(s).innerHTML=xmlHttp4.responseText;
		}
		};
		xmlHttp4.open("GET",url,true);
		xmlHttp4.send(null);
}

//insert smileys

function insertsmiley(id,val,smiley)
{
	document.getElementById(id).value = document.getElementById(id).value+val;
	document.getElementById(smiley).style.display = "none";
	document.getElementById(id).focus();
}

//show smily
function showsmily(id)
{
	if(document.getElementById(id).style.display == "none")
	{
		document.getElementById(id).style.display = "block";
		setTimeout("showsmily('"+id+"')",3000);
	}
	else
	{
		document.getElementById(id).style.display = "none";
	}
}


//Enter Function
function keyup(arg1,id,fId,tId,rm) {
	if(arg1==13) {insertChat(id,fId,tId,rm); }
}

//Close the div
//function closechat(id)
//{
//var obj = document.getElementById("chatpanel");
//var remobj = document.getElementById(id);
//obj.removeChild(remobj);

//}

//Minimize the div
function minimizechat(id)
{
var obj = document.getElementById("chatpanel");
var remobj = document.getElementById(id);
if(document.getElementById(id).childNodes[1].style.display != "none")
{
document.getElementById(id).childNodes[1].style.display = "none";
document.getElementById(id).childNodes[2].style.display = "none";
v = obj.offsetHeight-document.getElementById(id).childNodes[0].offsetHeight-5;
document.getElementById(id).style.margin=v+'px 2px 2px 2px';
}
else
{
v = obj.offsetHeight-document.getElementById(id).childNodes[0].offsetHeight;
document.getElementById(id).style.margin='2px 2px 2px 2px';
document.getElementById(id).childNodes[1].style.display = "";
document.getElementById(id).childNodes[2].style.display = "";
}
}

//Inserting the chat message
function insertChat(id,fId,tId,rm){
	var txt=document.getElementById(id).value;
	xmlHttp=GetXmlHttpObject();
	 if (xmlHttp==null){
  		  alert ("Your browser does not support AJAX!");
		  return;
	 } 
	 var url="chesstest/ajaxInsertMessage.php?rm="+rm+"&cid="+tId+"&txt="+txt+"&ms="+getAjaxTime();
		xmlHttp.onreadystatechange=function stateChangedinsertchat(){ //alert(xmlHttp.responseText);
		if (xmlHttp.readyState==4){ 	
			document.getElementById(id).value = "";
			document.getElementById(id).focus();		
		}
		};
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

//Unique number generation
function getAjaxTime()
{
zeit = new Date(); 
ms = (zeit.getHours() * 24 * 60 * 1000) + (zeit.getMinutes() * 60 * 1000) + (zeit.getSeconds() * 1000) + zeit.getMilliseconds(); 
return ms;
}	

//Get the conversation using ajax
var timestamp = new Array();
var prevmsg = new Array();
function getChat(rm,id){
	
	xmlHttp1=GetXmlHttpObject();
	   if (xmlHttp1==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	  
		var url="chesstest/ajaxGetMessage.php?room="+rm+"&ms="+getAjaxTime();	
		xmlHttp1.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp1.readyState==4){ 	
		 if(prevmsg[id] != xmlHttp1.responseText)
		 {
		 prevmsg[id] = xmlHttp1.responseText;
		 if(!document.getElementById(id)) {clearTimeout(timestamp[id]); return false;}	        
			document.getElementById(id).innerHTML=xmlHttp1.responseText;
			var objDiv=	document.getElementById(id);
			objDiv.scrollTop = objDiv.scrollHeight;					
			}
		}
};
		xmlHttp1.open("GET",url,true);
		xmlHttp1.send(null);
		functionstring = "getChat('"+rm+"','"+id+"')";
		timestamp[id] = setTimeout(functionstring,1000);
}

function checkChat()
{
	uid = universaluser;
	xmlHttp2=GetXmlHttpObject();
	   if (xmlHttp2==null){
  		 alert ("Your browser does not support AJAX!");
		  return;
	   }	  
		var url="chesstest/ajaxCheckChat.php?uid="+uid+"&ms="+getAjaxTime();
		xmlHttp2.onreadystatechange=function stateChangedgetchat(){ 
		if (xmlHttp2.readyState==4){ 
		if(xmlHttp2.responseText != "")
		{
		 getvalue = xmlHttp2.responseText;
		 splitvalue = getvalue.split("##COLOURZ##");
		 loadchild(splitvalue[0],uid,splitvalue[1],splitvalue[2]);
		}
		}
};
		xmlHttp2.open("GET",url,true);
		xmlHttp2.send(null);
		functionstring = "checkChat()";
		setTimeout(functionstring,1000);
}

//xmlHTTP initialization
function GetXmlHttpObject(){
	 xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch(e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}		
	}
	return xmlHttp;
}

//To get the body for ie
function truebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}

//Adjust chat location on scroll
function adjustchat()
{
movement = window.pageYOffset? window.pageYOffset : truebody().scrollTop? truebody().scrollTop : 0;
obj_top = window.innerHeight? window.innerHeight : truebody().offsetHeight;
newtop = parseInt(obj_top)+parseInt(movement)-260;
document.getElementById("chatpanel").style.top = newtop+"px";
setTimeout('adjustchat()',100);
}