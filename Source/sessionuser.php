<?php
include_once("config.php");
include_once("include/dbopen.php");
?>
<html>
<head>
<SCRIPT language="JavaScript">
<!--//Disable right click script
var message="";
///////////////////////////////////
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
// -->
</SCRIPT>

<script language="JavaScript">
window.onunload = function() 
{
var xmlHttp;
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
try
{
xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
xmlHttp.onreadystatechange=function()
{
if(xmlHttp.readyState==4)
{
document.myForm.time.value=xmlHttp.responseText;
}
}
xmlHttp.open("POST","include/logout.php?userid=<?=$_SESSION['userid'];?>",true);
xmlHttp.send(null);
}
 
</script>

</head>
<form method="post">
    <body bgcolor="#CCCCCC">
        <table width="100%">
            <tr>            	
                <td align="right" valign="top">Welcome&nbsp;:&nbsp;<?=$_SESSION['username'];?>&nbsp;&nbsp;
                <a href="include/logout.php?userid=<?=$_SESSION['userid'];?>" style="text-decoration:none" target="_parent">Logout</a></td>
            <tr>
        </table>
</form>
    </body>
</html>
<?php
include_once("include/dbclose.php");
?>
