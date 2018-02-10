<?php 
  require_once '../utils/executeQuery.php';

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $playlistID = $obj->playlistID;

  $response = [];

  $all = executeQuery("SELECT * FROM song WHERE playlist_id = $playlistID");

  while ( $row = mysqli_fetch_array($all) ) {
    $response[] = $row;
  }

  echo json_encode($response);
?>