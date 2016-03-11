<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['email']))
{
	$username = htmlentities($_REQUEST['username'], ENT_QUOTES);
	$password = htmlentities($_REQUEST['password'], ENT_QUOTES);
	$email = htmlentities($_REQUEST['email'], ENT_QUOTES);
	$gender = htmlentities(isset($_REQUEST['gender'])?$_REQUEST['gender']:"Unknown", ENT_QUOTES);
	$country = htmlentities(isset($_REQUEST['country'])?$_REQUEST['country']:"Unknown", ENT_QUOTES);
	$age = htmlentities(isset($_REQUEST['age'])?$_REQUEST['age']:"0", ENT_QUOTES);
	$city = htmlentities(isset($_REQUEST['city'])?$_REQUEST['city']:"Unknown", ENT_QUOTES);
	$registerquery="insert into userprofile (username, email, gender, age, country, city, password) values ('".$username."','".$email."','".$gender."','".$age."','".$country."','".$city."','".$password."')";
	
	if (!mysqli_query($con, $registerquery)) 
	{
		echo '"code" : 503,';
		echo '"status" : "User registration failed."';	
	}
	else
	{
		echo '"code" : 200,';
		echo '"status" : "User registered successfully!",';	
    echo '"user" : {';
      echo ' 	"userId" : "'.mysqli_insert_id($con).'",';
      echo '	"username" : "'.$_REQUEST['username'].'",';					
      echo '	"email" : "'.$_REQUEST['email'].'"';
		echo '}';
	}
}
else
{
	echo '"code" : 502,';
	echo '"status" : "Invalid registration Request. Please check the details."';	
}
?>
<?php
echo '}';
include_once("dbclose.php");
?>
