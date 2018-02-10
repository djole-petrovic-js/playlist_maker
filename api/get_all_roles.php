<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $result = executeQuery("
    SELECT *
    FROM role
  ");

  echo json_encode(convertToJSON($result));
?>