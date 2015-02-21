<?
$con=mysql_connect('localhost','root','') or die("could not select to mysql server!");
mysql_select_db('chess',$con) or die("could not select database!");
session_start();


$error = isset($_GET['err']) ? (  ($_GET['err'] == 1) ? "Username / Password incorrect." : " Already Logged !") : "";

if(isset($_REQUEST['btnsubmit']))
{
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$loginquery=mysql_query("select * from userprofile where username='$username' and password='$password'");
	$loginrow = mysql_fetch_assoc($loginquery);
	$logincount = mysql_num_rows($loginquery);
	$_SESSION['userid'] = $loginrow['userid'];
	$_SESSION['username'] = $loginrow['username'];
	$userid=$_SESSION['userid'];
	$status='Y';

	if($logincount != 0)
	{
		$logquery=mysql_query("select * from log where userid='$userid'");
		$logcount =mysql_num_rows($logquery);
		
		if($logcount != 0)
		{
			$checklog=mysql_query("select * from log where userid='$userid' and status='$status'");
			$checklogcount =mysql_num_rows($checklog);
			
			if($checklogcount != 0)
			{
			header("Location:index.php?err=2");
			}
			else
			{
			$updatelog=mysql_query("update log set status='$status' where userid='$userid'");
			header("Location:home.php");
			}
		}
		else
		{
			$insertlog=mysql_query("INSERT INTO LOG (userid, logtime, status)VALUES('$userid', now(), '$status')");
			header("Location:home.php");
		}
	}
	else
	{
	header("Location:index.php?err=1");
	}
	
}
?>
<html>
<title>index Page</title>
<head>
<script src="js/validate.js"></script>
</head>
<body  bgcolor="#CCCCCC">

<br /><br /><br /><br /><br /><br />
  <table align="center">
  	<tr>
    	<td align="center" colspan = "3"><strong>Login Form</strong></td>
    </tr>
    <tr height="5px"></tr>
    <tr>
        <td colspan="3" align="center"><font color="#FF0000"><?php echo $error; ?></font></td>
    </tr>
    <tr height="5px"></tr>
<form method="post" action="" name='loginForm' onSubmit="return  validate();">
    <tr>
        <td><strong>User name</strong></td>
        <td>:</td>
        <td><input type="text" name="username" id="username" onBlur="checktextbox(this);" value="<?=$_REQUEST['username'];?>">&nbsp;&nbsp;<span id="usernameerror"></span></td>
    </tr>
    <tr>
        <td><strong>Password</strong></td>
        <td>:</td>
        <td><input type="password" name="password" id="password" onBlur="checktextbox(this);">&nbsp;&nbsp;<span id="passworderror"></span></td>
    </tr>
    <tr>
        <td colspan="3" align="center">
            <input type="submit" name="btnsubmit" id="btnsubmit"  value="Submit">
        </td>
    </tr>
</form>
  </table>
</body>
</html>
<?
mysql_close($con);
?>
