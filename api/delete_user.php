<?php 
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $id = $obj->id;

  $checkIfAdmin = executeQuery("SELECT * FROM user WHERE id_user = $id");
  $user = mysqli_fetch_array($checkIfAdmin);

  if ( $user['role_id'] == 2 ) {
    return json_encode([ 'success' => false ]);
  }

  $result = executeQuery("DELETE FROM user WHERE id_user = $id");

  $response = [];

  if ( $result == 1 ) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }

  echo json_encode($response);
?>