<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $id = $obj->id;
  $category_name = $obj->category_name;

  $result = executeQuery("
    UPDATE category
    SET category_name = '$category_name'
    WHERE id_category = $id
  ");

  $response = [];

  if ( $result == 1 ) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }

  echo json_encode($response);
?>