<?php
  function convertToJSON($mysqlObj) {
    $output = [];

    while ( $row = mysqli_fetch_array($mysqlObj) ) {
      $output[] = $row;
    }

    return $output;
  }
?>