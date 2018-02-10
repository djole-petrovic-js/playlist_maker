<?php 
  session_start();

  $errors = [];
  $emailRegex = '/[a-zA-Z0-9\.\?\!]+@[a-z]+(\.[a-z]{2,4})?\.[a-z]{2,4}/';
  $messageRegex = '/[a-zA-Z0-9\s\.\?\!\-_\'\"]{10,100}/';
  $usernameRegex = '/[a-zA-Z0-9.\?\!]{5,15}/';
  $subjectRegex = '/[A-Z][a-z]{2,15}/';
  $isMailSent = '';

  if ( isset($_POST['btnSubmit']) ) {
    $email = '';
    $message = '';
    $username = '';
    $subject = '';

    if ( isset($_POST['subject']) && $_POST['subject'] !== '' ) {
      $subject = $_POST['subject'];

      if ( !preg_match($subjectRegex,$subject) ) {
        $errors[] = 'Subject is not properly format (First letter capitalised, minimum length 3 characters)';
      }
    } else {
      $errors[] = 'Subject is missing...';
    }

    if ( isset($_POST['username']) && $_POST['username'] != '' ) {
      $username = $_POST['username'];

      if ( !preg_match($usernameRegex, $username) ) {
        $errors[] = 'Name you provided is not properly formated...';
      }
    } else {
      $errors[] = 'Your name is required...';
    }

    if ( isset($_POST['email']) && $_POST['email'] != '' ) {
      $email = $_POST['email'];

      if ( !preg_match($emailRegex, $email) ) {
        $errors[] = 'Email is not properly formated...';
      }
    } else {
      $errors[] = 'Your email is required...';
    }

    if ( isset($_POST['question']) && $_POST['question'] != '' ) {
      $message = trim($_POST['question']);

      if ( !preg_match($messageRegex, $message) ) {
        $errors[] = 'Your message needs to have at least 10 characters...';
      }
    } else {
      $errors[] = 'Enter your message...';
    }

    if ( count($errors) == 0 ) {
      $headers = "From: djordje.petrovic.6.15@ict.edu.rs";

      if ( @mail('djordje.petrovic.6.15@ict.edu.rs', $subject, $message,$headers) ) {
        $isMailSent = true;
      } else {
        $isMailSent = false;
      }
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>Contact Page</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>
  <div class="container">
    <div class="wrapper admin">
      <div class="row">
        <div class="col-md-6">
          <h1>Contact Page</h1>
          <br>
          <form action="/contact.php" method="POST">
            <?php if ( isset($_SESSION['id_user']) ): ?>
              <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
              <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
              <div class="alert alert-info">
                <p>Since you are logged in, our reply will be sent to your email address...</p>
              </div>
            <?php else: ?>
              <div class="form-group">
                <input value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" class="form-control" type="text" name="username" placeholder="Enter your name...">
              </div>
              <div class="form-group">
                <input value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" class="form-control" type="text" name="email" placeholder="Enter your email...">
              </div>
            <?php endif; ?>
            <div class="form-group">
              <input value="<?php echo isset($_POST['subject']) ? $_POST['subject'] : '' ?>" class="form-control" type="text" name="subject" placeholder="Subject...">
            </div>
            <div class="form-group">
              <textarea  name="question" class="form-control" placeholder="Enter your message!">
                <?php echo isset($_POST['question']) ? trim($_POST['question']) : '' ?>
              </textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="btnSubmit">Submit!</button>
          </form>        
        </div>
        <?php if ( isset($_POST['btnSubmit']) && $isMailSent !== '' ): ?>
          <div class="col-md-6">
            <?php if ( $isMailSent ): ?>
              <div class="alert alert-info">
                <p>Your message was successfully sent!</p>
              </div>
            <?php else: ?>
              <div class="alert alert-danger">
                <p>Error occured while sending your email, please try again...</p>
              </div>
            <?php endif; ?>
          </div>
          <?php  ?>
        <?php endif; ?>
        <?php if ( count($errors) > 0 ): ?>
          <div class="col-md-6">
            <ul class="list-group">
              <?php foreach ( $errors as $e ): ?>
                <div class="alert alert-danger">
                  <li class="list-group-item"><?php echo $e; ?></li>
                </div>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php include_once 'inc/footer.php' ?>
</body>
</html>