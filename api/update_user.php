<?php 
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $userID = $obj->userID;
  $role_id = $obj->role_id;

  $result = executeQuery("
    UPDATE user
    SET role_id = $role_id
    WHERE id_user = $userID
  ");

  $response = [];

  if ( $result == 1 ) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }

  echo json_encode($response);
?>