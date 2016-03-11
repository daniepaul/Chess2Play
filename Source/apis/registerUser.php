<?php
include_once("../config.php");
include_once("dbopen.php");
header('Content-Type: application/json');
echo '{';
?>
<?php
if(isset($_POST['registerUser']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
	$username = htmlentities($_POST['username'], ENT_QUOTES);
	$password = htmlentities($_POST['password'], ENT_QUOTES);
	$email = htmlentities($_POST['email'], ENT_QUOTES);
	$gender = htmlentities(isset($_POST['gender'])?$_POST['gender']:"Unknown", ENT_QUOTES);
	$country = htmlentities(isset($_POST['country'])?$_POST['country']:"Unknown", ENT_QUOTES);
	$age = htmlentities(isset($_POST['age'])?$_POST['age']:"0", ENT_QUOTES);
	$city = htmlentities(isset($_POST['city'])?$_POST['city']:"Unknown", ENT_QUOTES);
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
      echo '	"username" : "'.$_POST['username'].'",';					
      echo '	"email" : "'.$_POST['email'].'"';
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
