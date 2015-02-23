<?php
include_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title>Chess2Play - Two player chess application</title>
<meta name="generator" content="Bootply" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
<link href="css/styles.css" rel="stylesheet">
<script src="js/jquery.min.js"></script>
<script src="js/angular.min.js"></script>
<script src="js/bootbox.min.js"></script> 
<script src="angular/chess-app.js"></script> 
</head>
<body ng-app="ChessApp">
<nav class="navbar navbar-static">
  <div class="container">
    <div class="navbar-header"> <a class="navbar-brand" href="<?=BASEDIR ?>"><b>Chess2Play</b></a> <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="glyphicon glyphicon-chevron-down"></span> </a> </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="<?=BASEDIR ?>">About Chess2Play</a></li>
        <li><a href="http://www.daniepaul.com/" target="_blank">Daniepaul.com</a></li>
      </ul>
      <ul class="nav navbar-right navbar-nav">
      <?php if(isset($_SESSION['userid']) && $_SESSION['userid'] != "") { ?>
      	<?php /*?><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="badge redBadge" style="vertical-align:top">1</span> <i class="glyphicon glyphicon-tasks"></i> <i class="glyphicon glyphicon-chevron-down"></i></a>
          <div class="dropdown-menu">
          	<table class="table table-striped table-hover notificationsPanel" style="margin-bottom:0px">
              <tr><td>Test 1</td></tr>
              <tr><td>Test 2</td></tr>
            </table>
          </div>
        </li><?php */?>
        <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> <i class="glyphicon glyphicon-chevron-down"></i></a>
          <ul class="dropdown-menu">
            <li><a href="<?=BASEDIR ?>profile.php">Profile</a></li>
            <li><a href="<?=BASEDIR ?>logout.php">Logout</a></li>
          </ul>
        </li>
        <?php } else { ?>
        <li> <a href="#"  data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-user"></i> Login</a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<!-- /.navbar -->