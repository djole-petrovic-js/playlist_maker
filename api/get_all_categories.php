<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $result = executeQuery("
    SELECT *
    FROM category
  ");

  echo json_encode(convertToJSON($result));
?>