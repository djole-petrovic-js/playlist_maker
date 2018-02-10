<?php 
  session_start();

  if ( !isset($_SESSION['id_user']) ) {
    header('Location:login.php');
  }

  require_once 'utils/executeQuery.php';

  $user_id = $_SESSION['id_user'];
  $errors = [];

  if ( isset($_POST['btnDeletePlaylist']) ) {
    $id = $_POST['playlistID'];

    executeQuery("DELETE FROM playlist WHERE id_playlist = $id");
  }

  if ( isset($_POST['btnSubmitPlaylist']) ) {
    $playlist = isset($_POST['playlist']) ? $_POST['playlist'] : '';
    $category = isset($_POST['category']) ? (int)$_POST['category'] : '';
    $target_dir = 'uploads/';
    $targetName = date('dmYiHs') .basename($_FILES["cover"]["name"]);
    $target_file = $target_dir . $targetName;

    $check = getimagesize($_FILES['cover']['tmp_name']);

    if ( $check === false ) {
      $errors[] = 'File you uploaded is not an image...';
    }

    if ( $playlist === '' || $category === '' ) {
      $errors[] = 'Missing playlist name or a category, please enter them both!';
    }      

    if ( count($errors) == 0 ) {
      $sql = "
        INSERT INTO playlist(playlist_name,user_id,category_id,cover)
        VALUES ('$playlist',$user_id,$category,'$targetName')
      ";

      move_uploaded_file($_FILES['cover']['tmp_name'],$target_file);
      executeQuery($sql);
    }
  }

  if ( isset($_POST['btnSubmitSong']) ) {
    $playlistID = (int)$_POST['playlistID'];
    $target_dir = 'uploads/';
    $targetName = date('dmYiHs') . basename($_FILES["song"]["name"]);
    $target_file = $target_dir . implode(explode(' ',$targetName));

    $uploaded = $_FILES['song']['type'];

    $onlyName = pathinfo($_FILES['song']['name'])['filename'];

    if ( $uploaded !== 'audio/mp3' ) {
      $errors[] = 'Not an mp3 file...';
    }

    if ( count($errors) == 0 ) {
      $sql = "
        INSERT INTO song (song_name,playlist_id,song_title)
        VALUES ('$target_file',$playlistID,'$onlyName')
      ";

      move_uploaded_file($_FILES['song']['tmp_name'],$target_file);
      executeQuery($sql);
    }
  }

  $allPlaylists = executeQuery("SELECT * FROM playlist WHERE user_id = $user_id ORDER BY created_at DESC");

  $playlists = [];

  while ( $row = mysqli_fetch_array($allPlaylists) ) {
    $playlists[] = $row;
  }

  $categories = executeQuery("SELECT * FROM category");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profile</title>
  <?php include_once 'inc/metadata.php'; ?>
    <link rel="stylesheet" type="text/css" href="public/css/custom.css">
    <link rel="stylesheet" type="text/css" href="public/css/style1.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>

  <div class="container">
    <div class="wrapper">
      <h1>Profile</h1>
      <div class="row">
        <div class="col-md-6">
          <h2>Your playlists!</h2>
          <?php if ( count($playlists) == 0 ): ?>
            <div class="alert alert-info">
              <p>You have no playlists at the moment, go create one!</p>
            </div>
          <?php else: ?>
            <ul class="list-group">
              <?php foreach ( $playlists as $row ): ?>
                <li class="list-group-item">
                  <div class="row">
                    <div class="col-md-5">
                      <img class="cover_photo" src="uploads/<?php echo $row['cover']; ?>">
                    </div>
                    <div class="col-md-7">
                      <a class="btn btn-primary" href="/listen.php?playlist=<?php echo $row['id_playlist'] ?>"><?php echo $row['playlist_name']; ?></a>
                      <br>
                      Created at : <?php echo date('d/m/Y',strtotime($row['created_at'])); ?><br>
                      <label>Add new Song to this list!</label>
                      <form action="/profile.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="playlistID" value="<?php echo $row['id_playlist']; ?>">
                        <input class="form-control" type="file" name="song">
                        <button class="btn btn-primary" name="btnSubmitSong" type="submit">Submit</button>
                      </form>
                    </div>
                  </div>
                  <div class="row">
                    <button class="btnSongs" id="getSongs" data-id="<?php echo $row['id_playlist'] ?>">List all songs in this playlist!</button>
                    <ul class="list-group" id="list<?php echo $row['id_playlist'] ?>"></ul>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-12 list-group-item">
              <?php if ( count($errors) > 0 ): ?>
                <ul class="list-group">
                  <?php foreach ( $errors as $e ): ?>
                    <li class="list-group-item">
                      <?php echo $e; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
              <div class="alert alert-info">
                <p>Before you upload you song, make sure it is under 4mbs, or else it wont upload...</p>
              </div>
              <div class="alert alert-info">
                <p>To create you playlist, simply use the quick start form below. After that is done, you can upload your own files, make sure they are in mp3 format.</p>
              </div>
              <form method="POST" action="/profile.php" enctype="multipart/form-data">
                <div class="form-group">
                  <input class="form-control" type="text" name="playlist" placeholder="Playlist name">
                </div>
                <div class="form-group">
                  <label>Upload Cover Photo</label>
                  <input class="form-control" name="cover" type="file">
                </div>
                <div class="form-group">
                  <label>Select you playlist category!</label>
                  <select name="category" class="form-control">
                    <?php while ( $row = mysqli_fetch_array($categories) ): ?>
                      <option value="<?php echo $row['id_category'] ?>"><?php echo $row['category_name']; ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <button name="btnSubmitPlaylist" class="btn btn-primary" type="Submit">Create new Playlist!</button>
              </form>
            </div>
            <?php if ( count($playlists) > 0 ): ?>
              <div class="col-md-6 list-group-item">
                <p>Delete Playlist!</p>
                <p>Select playlist to delete...</p>
                <form action="/profile.php" method="POST">
                  <select name="playlistID">
                    <?php foreach ( $playlists as $row ): ?>
                      <option value="<?php echo $row['id_playlist']; ?>">
                        <?php echo $row['playlist_name'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <button type="submit" name="btnDeletePlaylist" class="btn btn-danger">Delete!</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once 'inc/footer.php'; ?>
</body>
<script src="public/js/profile.js"></script>
</html>