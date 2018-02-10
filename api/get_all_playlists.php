<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $result = executeQuery("
    SELECT * FROM playlist p
    INNER JOIN user u
    ON p.user_id = u.id_user
    INNER JOIN category c
    ON p.category_id = c.id_category
  ");

  echo json_encode(convertToJSON($result));
?>