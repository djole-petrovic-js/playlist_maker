<?php 
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $id = $obj->id;

  $result = executeQuery("DELETE FROM category where id_category = $id");

  $response = [];

  if ( $result == 1 ) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }

  echo json_encode($response);
?>