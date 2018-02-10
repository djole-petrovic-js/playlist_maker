<?php
  session_start();

  if ( !isset($_SESSION['id_user']) ) {
    echo json_encode([ 'userDoesntExist' => true ]);

    return;
  }

  require_once '../utils/executeQuery.php';
  require_once '../utils/convertToJSON.php';

  $userID = $_SESSION['id_user'];

  $voted = mysqli_num_rows(executeQuery("SELECT * FROM user_votes WHERE user_id = $userID"));

  if ( $voted == 1 ) {
    echo json_encode([ 'alreadyVoted' => true ]);

    return;
  }

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  $id = $obj->id;

  $updateMainPoll = executeQuery("
    UPDATE poll
    SET number_of_votes = number_of_votes + 1
  ");

  $result = executeQuery("
    UPDATE poll_options
    SET votes = votes + 1
    WHERE id_poll_options = $id
  ");

  executeQuery("INSERT INTO user_votes (user_id) values ($userID)");

  $response = [];

  if ( $result == 1 && $updateMainPoll == 1) {
    $response['success'] = true;
  } else {
    $response['success'] = false;
  }

  echo json_encode($response);
?>