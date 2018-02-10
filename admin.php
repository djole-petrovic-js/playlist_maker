<?php 
  session_start();

  if ( !isset($_SESSION['id_user']) || $_SESSION['role_id'] != 2 ) {
    header('Location:login.php');
  }


?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
  <script src="/public/js/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.js"></script>
  <script src="/public/js/angular.rout.min.js"></script>
  <script src="/public/js/admin.js"></script>
</head>
<body ng-app="admin">
  <?php include_once 'inc/banner.php'; ?>
  <div class="container">
    <div class="wrapper admin">
      <div class="row">
        <div class="col-md-12">
          <h1>Admin Panel</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <ul class="list-group">
            <a href="#users" class="list-group-item">Users</a>
            <a href="#links" class="list-group-item">Links</a>
            <a href="#playlists" class="list-group-item">Playlists</a>
            <a href="#songs" class="list-group-item">Songs</a>
            <a href="#categories" class="list-group-item">Categories</a>
            <a href="#roles" class="list-group-item">Roles</a>
          </ul>
        </div>
        <div class="col-md-10" id="admin-left">
          <ng-view></ng-view>
        </div>
      </div>
    </div>
  </div>
  <?php include_once 'inc/footer.php' ?>
</body>
</html>