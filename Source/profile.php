<?php
include_once("includes/header.php");
?>
<script type="text/javascript">
var profileId = <?=(isset($_REQUEST["userid"]) ? $_REQUEST["userid"] : (isset($_SESSION["userid"]) ? $_SESSION["userid"] : "")) ?>;
</script>
<script src="angular/activeUser-controller.js"></script>
<script src="angular/userprofile-controller.js"></script>
<header class="masthead">
  <div class="container">
    <div class="row">
      <div class="col-md-6" ng-controller="UserProfileCtrl">
        <h1><a href="#">{{profile.username}}</a>
            <p class="lead">Profile</p>
        </h1>
      </div>
      <div class="col-md-6">
        <div class="pull-right maxOnly" style="margin:5px"> <img src="images/man-icon.png"> </div>
      </div>
    </div>
  </div>
</header>

<!-- Begin Body -->
<div class="container">
  <div class="row">
  <?php if(!isset($_REQUEST["userid"])) { ?>
    <div class="col-md-6">
      <div class="panel">
        <div class="panel-heading customHeading">Active Players</div>
        <div class="panel-body">
        	<table class="table table-striped" ng-controller="ActiveUserCtrl">
            	<tr ng-repeat="user in users">
                	<td><a href="profile.php?userid={{user.userid}}">{{user.username}}</a></td>
                    <td ng-switch="user.status">
                    	<span ng-switch-when="Available" class="label label-success">{{user.status}}</span>
                        <span ng-switch-when="Invited" class="label label-default">{{user.status}}</span>
                        <span ng-switch-when="Playing" class="label label-danger">{{user.status}}</span>
                        <span ng-switch-when="Requested" class="label label-warning">{{user.status}}</span>
                    </td>
                    <td ng-switch="user.status">
                    	<a ng-switch-when="Available" class="btn btn-info btn-xs" href="#" role="button">Invite for a game</a>
                        <a ng-switch-when="Requested" class="btn btn-info btn-xs" href="{{user.nextUrl}}" role="button">Accept Invite</a>
                    </td>
                </tr>
            </table> 
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="col-md-6" ng-controller="UserProfileCtrl">
      <div class="panel">
        <div class="panel-heading customHeading">Game Stats</div>
        <div class="panel-body">
        	  <table class="table table-striped">
             	 <tr  class="success" style="font-weight:bold">
                <td>Total Points</td><td>{{profile.totalPoints}}</td>
                </tr>
            	<tr>
                <td>Total Games Played</td><td>{{profile.playedGames}}</td>
                </tr>
                <tr>
                <td>Games Won</td><td>{{profile.wonGames}}</td>
                </tr>
                <tr>
                <td>Games Lost</td><td>{{profile.lostGames}}</td>
                </tr>
                <tr>
                <td>Games Drawn</td><td>{{profile.drawnGames}}</td>
                </tr>
            </table> 
        </div>
      </div>
        <?php if(isset($_REQUEST["userid"])) { ?>
        </div>
        <div class="col-md-6" ng-controller="UserProfileCtrl">
        <?php } ?>
      <div class="panel">
        <div class="panel-heading customHeading">Profile Details</div>
        <div class="panel-body">
        	<table class="table table-striped">
            	<tr>
                <td>User Name</td><td>{{profile.username}}</td>
                </tr>
                <tr>
                <td>Email Address</td><td>{{profile.email}}</td>
                </tr>
                <tr>
                <td>Gender</td><td>{{profile.gender}}</td>
                </tr>
                <tr>
                <td>Location</td><td>{{profile.country}}</td>
                </tr>
            </table> 
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include_once("includes/footer.php");
?>