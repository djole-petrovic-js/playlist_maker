<?php
  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $result = executeQuery("
    SELECT *
    FROM song s
    INNER JOIN playlist p
    ON s.playlist_id = p.id_playlist
  ");

  echo json_encode(convertToJSON($result));
?>