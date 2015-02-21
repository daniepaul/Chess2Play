<?php
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();
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
mysql_close($con);
?>

