<?php
include_once("config.php");
include_once("include/dbopen.php");
$userid=$_SESSION['userid'];
$opponentuserid = $_REQUEST['opid'];
?>
<html>
<head>
<script src="js/ajax/ajaxchess.js"></script>
</head>
<body bgcolor="#CCCCCC" onLoad="getUsers(<?php echo $userid;?>); displayRequest(<?php echo $userid;?>);">
<br />
<table width="100%">    
<tr>
    <td>
    <div id="log">
        <table width="200px" align="left" bgcolor="#FFFFFF">
            <tr>
                 <td><b>List of users online</b></td>
              </tr>
              <tr>
                  <td><div id="loggedusers"></div></td>
               </tr>
        </table>        			
    </div>
    </td>
    </tr>
<tr>
    <td>
    <div id="invite">
        <table width="200px" align="left" bgcolor="#FFFFFF">
                    	<tr>
                        	<td><b>Invite u to play</b></td>
                        </tr>
                        <tr>
                        	<td>
                            	<div id="displayrequest"></div>
                            </td>
                        </tr>
                    </table>
     </div>
    </td>
    </tr>
     
    </table>
   
    </body>
</html>
<?php
include_once("include/dbclose.php");
?>

