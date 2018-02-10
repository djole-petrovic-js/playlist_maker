<?php
  define('DB_USERNAME','test');
  define('DB_PASSWORD','test');
  define('DB_HOST','127.0.0.1');
  define('DB_NAME','playlist_maker');

  function executeQuery($sql) {
    $connection = mysqli_connect(
      DB_HOST,
      DB_USERNAME,
      DB_PASSWORD,
      DB_NAME
    );

    if ( mysqli_connect_errno() ) {
      echo 'Could not connect to database...';
    }

    $result = mysqli_query($connection,$sql);

    mysqli_close($connection);

    return $result;
  }
