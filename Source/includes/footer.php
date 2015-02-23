<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-right">
        <h5>©daniepaul.com 2015<br/>
        Theme by <a href="http://www.bootply.com/templates" target="_blank">Bootply.com</a></h5>
      </div>
    </div>
  </div>
</footer>
<?php if(!isset($_SESSION['userid']) || $_SESSION['userid'] == "") { ?>
<script src="angular/login-controller.js"></script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form ng-submit="login()" ng-controller="UserLoginCtrl">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
                <div class="form-group">
            <label for="inputUsername">Username</label>
            <input type="text" class="form-control" ng-model="username" id="inputUsername" required placeholder="Enter username">
          </div>
          <div class="form-group">
            <label for="inputPassword1">Password</label>
            <input type="password" class="form-control" ng-model="password" id="inputPassword1" required placeholder="Password">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
<!-- script references --> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/scripts.js"></script>
</body>
</html>