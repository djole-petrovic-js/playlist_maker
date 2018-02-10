<?php 
  require_once '../utils/executeQuery.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $username = $obj->username;

  $user = executeQuery("SELECT * FROM user WHERE username = '$username'");
  $exists = mysqli_num_rows($user) > 0;

  echo json_encode([
    'exists' => $exists
  ]);
?>