<?php 
  session_start();

  require_once 'utils/executeQuery.php';

  $playlistID = isset($_GET['playlist']) ? (int)$_GET['playlist'] : '';

  $result = executeQuery("
    SELECT *
    FROM playlist
    WHERE id_playlist = $playlistID
  ");

  $playlist = mysqli_fetch_array($result);

  $songs = executeQuery("
    SELECT *
    FROM song
    WHERE playlist_id = $playlistID
  ");

  $i = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Listen</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
  <link rel="stylesheet" type="text/css" href="public/css/player.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>

  <div class="container">
    
  <div class="column center">
        <h1><?php echo $playlist['playlist_name']; ?></h1>
    </div>
    <div class="column add-bottom">
        <div id="mainwrap">
            <div id="nowPlay">
                <span class="right" id="npTitle"></span>
            </div>
            <div id="audiowrap">
                <div id="audio0">
                    <audio controlsList="nodownload" preload id="audio1" controls="controls">Your browser does not support HTML5 Audio!</audio>
                </div>
                <div id="tracks">
                    <a id="btnPrev">&laquo;</a>
                    <a id="btnNext">&raquo;</a>
                </div>
            </div>
            <div id="plwrap">
                <ul id="plList">
                  <?php while ( $row = mysqli_fetch_array($songs) ): ?>
               <li>
                        <div class="plItem">
                          <div class="plNum"><?php echo ++$i; ?></div>
                          <div class="plTitle"><?php echo $row['song_title'] ?></div>
                        </div>
                    </li>
                  <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
  </div>
  <?php include_once 'inc/footer.php' ?>
</body>
<script src='http://api.html5media.info/1.1.8/html5media.min.js'></script>
<script src="public/js/player.js"></script>
</html>