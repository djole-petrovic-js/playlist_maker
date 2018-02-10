<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $id_link = $obj->id_link;
  $link_name = $obj->link_name;
  $link_order = $obj->link_order;
  $permission = $obj->permission;

  $result = executeQuery("
    UPDATE link
    SET link_name = '$link_name', link_order = $link_order, permission = $permission
    WHERE id_link = $id_link
  ");

  $response = [];

  if ( $result == 1 ) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }

  echo json_encode($response);
?>