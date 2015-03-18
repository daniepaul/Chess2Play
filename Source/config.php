<?php
session_start();
ob_start();
global $configuration;
date_default_timezone_set("Asia/Calcutta");

$configuration['host'] = "localhost";
$configuration['user'] = "root";
$configuration['pass'] = "";
$configuration['db'] = "chess";
$configuration['timezone'] = '+5:30';

//Generic Definations
define("SITE_NAME", "Chess Game");
define("AUTHOR", "Daniel Paul Rajsingh J");
define("SITE_OWNER", "www.daniepaul.com");
define("KEYWORDS", "daniepaul, chess game, chess, two player");
define("DESCRIPTION", "2PlayerChess is a two player chess game. Developed by daniepaul.com");
define("WEBMASTER","services@daniepaul.com");

//Location Definations
define("BASEDIR","http://localhost/chess2/");
define("FILE_UPLOAD_LOCATION",BASEDIR."uploadFile/");
define("IMAGEPATH",BASEDIR."images/");

//Global Definations
define("FROMEMAILADDRESS","info@daniepaul.com");

define("COPYRIGHTYEAR","2015");
define("COPYRIGHTNAME","daniepaul.com");
?>