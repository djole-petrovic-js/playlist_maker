<?php 
  session_start();

  $errors = [];
  
  if ( isset($_POST['btnSubmit']) ) {
    require_once 'utils/executeQuery.php';

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user = executeQuery("SELECT * FROM user WHERE username = '$username'");

    if ( mysqli_num_rows($user) == 0 ) {
      $errors[] = 'Username or password is incorrect...';
    } else {
      $userInfo = mysqli_fetch_array($user);
      $isValidPassword = password_verify($password,$userInfo['password']);

      if ( $isValidPassword == 0 ) {
        $errors[] = 'Username or password is incorrect...';
      } else {
        foreach ( ['id_user','role_id','email','username'] as $field ) {
          $_SESSION[$field] = $userInfo[$field];
        }

        header('Location:index.php');
      }
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>
  <div class="container">
    <div class="wrapper admin">
    <h1>Log In</h1>
    <br>
    <div class="row">
      <div class="col-md-6">
        <form action="/login.php" method="POST">
          <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="Username.">
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password.">
          </div>
          <button name="btnSubmit" type="submit" class="btn btn-primary">Log In!</button>
        </form>
      </div>
      <?php if ( count($errors) > 0 ): ?>
        <div class="col-md-6">
          <ul class="list-group">
            <?php foreach ( $errors as $e ): ?>
              <li class="list-group-item"><?php echo $e; ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      <?php endif ?>
    </div>
    <br>
    </div>
  </div>
  <?php include_once 'inc/footer.php' ?>
</body>
</html>