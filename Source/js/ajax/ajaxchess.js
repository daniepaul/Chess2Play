/////////////////////display the currently logged users////////////////////////
function getXMLHttp(){
    var xmlHttp
	    try{ xmlHttp = new XMLHttpRequest(); }
	    catch(e){
   		    try{ xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
    	    catch(e){ 
			try { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); }
      	        catch(e){ return false; } } }
  	 return xmlHttp;
	}
	
function getUsers(userid)
	{
  	window.setTimeout("getUsers('"+userid+"')",5000);
	var xmlHttp = getXMLHttp();
   	xmlHttp.onreadystatechange = function()
  	{
    	if(xmlHttp.readyState == 4)
    	{
      	document.getElementById("loggedusers").innerHTML=xmlHttp.responseText;
    	}
  	}
  	var url="getloggedusers.php";
	url=url+"?userid="+userid;
	xmlHttp.open("GET", url, true);
  	xmlHttp.send(null);
	}

///////////////////display the invites///////////////////
function getXMLHttp1(){
    var xmlHttp1
	    try{ xmlHttp1 = new XMLHttpRequest(); }
	    catch(e){
   		    try{ xmlHttp1 = new ActiveXObject("Msxml2.XMLHTTP"); }
    	    catch(e){ 
			try { xmlHttp1 = new ActiveXObject("Microsoft.XMLHTTP"); }
      	        catch(e){ return false; } } }
  	 return xmlHttp1;
	}

function displayRequest(userid)
	{
  	window.setTimeout("displayRequest('"+userid+"')",5000);
	var xmlHttp1 = getXMLHttp1();
   	xmlHttp1.onreadystatechange = function()
  	{
    	if(xmlHttp1.readyState == 4)
    	{
      	        if(xmlHttp1.responseText == "0")
				{
					window.location = "chesstest/test.php";
				}
				else
				{
					document.getElementById("displayrequest").innerHTML=xmlHttp1.responseText;
				}
    	}
  	}
  	var url1="displayrequest.php";
	url1=url1+"?userid="+userid;
	xmlHttp1.open("GET", url1, true);
  	xmlHttp1.send(null);
	}

/////////////////////////check user game status//////////////////////////////

function getXMLHttp2(){
    var xmlHttp2
	    try{ xmlHttp2 = new XMLHttpRequest(); }
		 catch(e){
   		    try{ xmlHttp2 = new ActiveXObject("Msxml2.XMLHTTP"); }
    	    catch(e){ 
			try { xmlHttp2 = new ActiveXObject("Microsoft.XMLHTTP"); }
      	        catch(e){ return false; } } }
  	 return xmlHttp2;
	}
	
function userstatus(gameid)
	{
	window.setTimeout("userstatus('"+gameid+"')",5000);
	var xmlHttp2 = getXMLHttp2();
   	xmlHttp2.onreadystatechange = function()
  	{
		if(xmlHttp2.readyState == 4)
    	{
				if(xmlHttp2.responseText == "0")
				{
					var agree=confirm("You Won! oppenent quit the game.");
					if (agree)
					window.location = "livechess.php";
					else	
					window.location = "livechess.php";
				}				
				if(xmlHttp2.responseText == "1")
				{
					var agree1=confirm("Oppenent Request for draw game!");
					if (agree1)
					{
					window.location = "drawgame.php?action=draw";
					}
					else
					{
						function GetXmlHttpObject9()
						{
						var xmlHttp9=null;
						try
						{
						// Firefox, Opera 8.0+, Safari
						xmlHttp9=new XMLHttpRequest();
						}
						catch (e)
						{
						// Internet Explorer
						try
						{
						xmlHttp9=new ActiveXObject("Msxml2.XMLHTTP");
						}
						catch (e)
						{
						xmlHttp9=new ActiveXObject("Microsoft.XMLHTTP");
						}
						}
						return xmlHttp9;
						}
				
					var xmlHttp9;
					xmlHttp9=GetXmlHttpObject9();
                    if (xmlHttp9==null)
                    {
                    alert ("Your browser does not support AJAX!");
		            return;
				    } 
					var url="drawgame.php";
					url=url+"?action=cancel";
					xmlHttp9.open("GET",url,true);
					xmlHttp9.send(null);
					}
				}
				if(xmlHttp2.responseText == "2")
				{
					var agree2=confirm("Game draw! Oppenent Accepted your request.");
					if (agree2)
					window.location = "livechess.php";
					else	
					window.location = "livechess.php";
				}
				if(xmlHttp2.responseText == "3")
				{
					var agree3=confirm("Oppenent Reject your request.");
						function GetXmlHttpObject10()
						{
						var xmlHttp10=null;
						try
						{
						// Firefox, Opera 8.0+, Safari
						xmlHttp10=new XMLHttpRequest();
						}
						catch (e)
						{
						// Internet Explorer
						try
						{
						xmlHttp10=new ActiveXObject("Msxml2.XMLHTTP");
						}
						catch (e)
						{
						xmlHttp10=new ActiveXObject("Microsoft.XMLHTTP");
						}
						}
						return xmlHttp10;
						}
				
					if (agree3)
					{						
					var xmlHttp10;
					xmlHttp10=GetXmlHttpObject10();
                    if (xmlHttp10==null)
                    {
                    alert ("Your browser does not support AJAX!");
		            return;
				    } 
					var url="drawgame.php";
					url=url+"?action=clear";
					xmlHttp10.open("GET",url,true);
					xmlHttp10.send(null);
					}
					else
					{
					var xmlHttp10;
					xmlHttp10=GetXmlHttpObject10();
                    if (xmlHttp10==null)
                    {
                    alert ("Your browser does not support AJAX!");
		            return;
				    } 
					var url="drawgame.php";
					url=url+"?action=clear";
					xmlHttp10.open("GET",url,true);
					xmlHttp10.send(null);
					}
					
				}
				if(xmlHttp2.responseText == "F")
				{
					MyColor = " ";
					alert("Congratulations! You won the game.");
				}
		  }
  	}
  	var url2="usercheckstat.php";
	url2=url2+"?gameid="+gameid;
	xmlHttp2.open("GET", url2, true);
  	xmlHttp2.send(null);
	}
	
////////////////////////disable right click/////////////////////////////

/*var message="";
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
*/
////////////////////////////////////////////////////////////////////////