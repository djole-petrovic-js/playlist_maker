<?php 
  require_once 'utils/executeQuery.php';

  $sql = 'SELECT * FROM link WHERE permission = 0';

  if ( !isset($_SESSION['id_user']) ) {
    $sql .= ' OR permission = 1';
  } else if ( $_SESSION['role_id'] == 1 ) {
    $sql .= " OR permission = 2";
  } else {
    $sql .= " OR permission = 2 OR permission = 3";
  }

  $sql .= ' ORDER BY link_order';

  $navigation = executeQuery($sql);
?>
<!-- banner -->
  <div class="banner">
    <div class="container">
      <nav class="navbar navbar-default">
        <div class="navbar-header navbar-left">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <h1><a class="navbar-brand" href="/">Playlist<span>Maker</span></a></h1>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
          <nav class="menu menu--iris">
            <ul class="nav navbar-nav menu__list">
              <?php while ( $row = mysqli_fetch_array($navigation) ): ?>
                <li class="menu__item">
                  <a href="<?php echo $row['href'] ?>" title="<?php echo $row['title'] ?>" class="menu__link"><?php echo $row['link_name'] ?></a>
                </li>
              <?php endwhile ?>
            </ul>
          </nav>
        </div>
      </nav>
      <div class="agile_banner_info">
        <h3>Maker</h3>
        <div class="agile_banner_info_pos">
          <h2>Playlist</h2>
        </div>
      </div>
    </div>
  </div>
<!-- //banner -->  