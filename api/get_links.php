<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $links = executeQuery('SELECT * FROM link');

  echo json_encode(convertToJSON($links));
?>