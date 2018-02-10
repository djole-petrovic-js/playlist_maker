<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $pollAndOptions = executeQuery("
    SELECT *
    FROM poll p
    INNER JOIN poll_options po
    ON p.id_poll = po.poll_id
  ");

  echo json_encode(convertToJSON($pollAndOptions));
?>