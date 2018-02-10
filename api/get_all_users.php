<?php 
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $result = executeQuery("
    SELECT *
    FROM user u
    INNER JOIN role r
    ON u.role_id = r.id_role
  ");

  echo json_encode(convertToJSON($result));
?>