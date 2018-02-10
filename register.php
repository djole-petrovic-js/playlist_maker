<?php 
  session_start();

  if ( isset($_POST['btnSubmit']) ) {
    require_once 'utils/executeQuery.php';

    $errors     = array();
    $email      = '';
    $password   = '';
    $username   = '';
    $country    = '';
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $emailRegex  = '/[a-zA-Z0-9\.\?\!]+@[a-z]+(\.[a-z]{2,4})?\.[a-z]{2,4}/';
    $countryRegex = '/[a-zA-Z0-9\.\/]{5,}/';
    $usernameRegex = '/[a-zA-Z0-9.\?\!]{5,15}/';

    if ( isset($_POST['username']) && $_POST['username'] != '' ) {
      $username = $_POST['username'];

      if ( !preg_match($usernameRegex, $username) ) {
        $errors[] = 'Username is not properly formated...';
      }

      $user = executeQuery("SELECT * FROM user WHERE username = '$username'");
      
      if ( mysqli_num_rows($user) > 0 ) {
        $errors[] = 'Username already exists, please select another one...';
      }
    } else {
      $errors[] = 'Username is required...';
    }

    if ( isset($_POST['email']) && $_POST['email'] != '' ) {
      $email = $_POST['email'];
      $tempEmail = addslashes($email);

      if ( !preg_match($emailRegex,$email) ) {
        $errors[] = 'Email is not propery formated...';
      }

      $user = executeQuery("SELECT * FROM user WHERE email = '$tempEmail'");

      if ( mysqli_num_rows($user) > 0 ) {
        $errors[] = 'Email already exists, please select another one...';
      }
    } else {
      $errors[] = 'Email is required...';
    }
    if ( isset($_POST['password']) && $_POST['password'] != '' ) {
      $password = $_POST['password'];
      
      if ( strlen($password) < 6 ) {
        $errors[] = 'Password has to be at least 5 characters long...';
      }
    } else {
      $errors[] = 'Password is required...';
    }

    if ( isset($_POST['country']) && $_POST['country'] != '' ) {
      $country = $_POST['country'];
      if ( !preg_match($countryRegex,$country) ) {
        $errors[] = 'Country is not properly formated...';
      }
    } else {
      $errors[] = 'Country name is missing...';
    }

    echo var_dump($errors);

    if ( count($errors) == 0 ) {
      $hash = password_hash($password,PASSWORD_DEFAULT);
      
      $sql = "
        INSERT INTO user(username,password,email,country,description)
        VALUES ('$username','$hash','$email','$country','$description')
      ";

      executeQuery($sql);

      $user = mysqli_fetch_array(executeQuery("SELECT * from user WHERE email='$email'"));

      foreach ( ['id_user','role_id','email','username'] as $field ) {
        $_SESSION[$field] = $user[$field];
      }

      header('Location:index.php');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>
  <div class="container">
    <h1>Register</h1>
    <br>
    <div class="row">
      <div class="col-md-6">
        <form id="registerForm" method="POST" action="/register.php">
          <div class="form-group">
            <input class="form-control" type="text" name="username" placeholder="Username">
            <br>
            <button class="btn btn-primary" id="checkIfUsernameExists">Check if username exists</button>
            <label id="checkIfUsernameExistsLabel"></label>
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="email" placeholder="Email">
            <button class="btn btn-primary" id="checkIfEmailExists">Check if email exists</button>
            <label id="checkIfEmailExistsLabel"></label>
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="country" placeholder="Enter you coutry name">
          </div>
          <div class="form-group">
            <textarea class="form-control" name="description" placeholder="If you want, you can provide some aditional data about yourself..."></textarea>
          </div>
          <button id="btnSubmit" name="btnSubmit" class="btn btn-primary" type="submit">Register!</button>
          <br>
        </form>
        <br>
      </div>
      <div id="errorsDiv" class="col-md-6">
        
      </div>
    </div>
  </div>
  <?php include_once 'inc/footer.php' ?>
</body>
<script src="public/js/Form.js"></script>
<script src="public/js/register.js"></script>
</html>