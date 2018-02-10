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
  <div class="footer">
    <div class="container">
      <div class="col-md-4 agileinfo_footer_grid">
        <h3>About Us</h3>
        <p>Playlist maker allows you to create your own music playlist that you can listen anywhere.Simply upload you music files and you are ready to go!</p>
        <div class="agileits_footer_grid_gallery">
          <div class="agileits_footer_grid_gallery1">
            <a href="#" data-toggle="modal" data-target="#myModal"><img src="public/images/2.jpg" alt=" " class="img-responsive" /></a>
          </div>
          <div class="agileits_footer_grid_gallery1">
            <a href="#" data-toggle="modal" data-target="#myModal"><img src="public/images/3.jpg" alt=" " class="img-responsive" /></a>
          </div>
          <div class="agileits_footer_grid_gallery1">
            <a href="#" data-toggle="modal" data-target="#myModal"><img src="public/images/4.jpg" alt=" " class="img-responsive" /></a>
          </div>
          <div class="agileits_footer_grid_gallery1">
            <a href="#" data-toggle="modal" data-target="#myModal"><img src="public/images/7.jpg" alt=" " class="img-responsive" /></a>
          </div>
          <div class="agileits_footer_grid_gallery1">
            <a href="#" data-toggle="modal" data-target="#myModal"><img src="public/images/8.jpg" alt=" " class="img-responsive" /></a>
          </div>
          <div class="agileits_footer_grid_gallery1">
            <a href="#" data-toggle="modal" data-target="#myModal"><img src="public/images/9.jpg" alt=" " class="img-responsive" /></a>
          </div>
          <div class="clearfix"> </div>
        </div>
      </div>
      <div class="col-md-4 agileinfo_footer_grid">
        <h3>Navigation</h3>
        <ul class="agileinfo_social_icons">
          <?php while ( $row = mysqli_fetch_array($navigation) ): ?>
            <a href="<?php echo $row['href']; ?>" class="list-group-item"><?php echo $row['link_name']; ?></a>
          <?php endwhile; ?>
        </ul>
        <!--<ul class="agileinfo_social_icons">
          <li><a href="#" class="facebook"><span class="fa fa-facebook" aria-hidden="true"></span><i>-</i>Facebook</a></li>
          <li><a href="#" class="twitter"><span class="fa fa-twitter" aria-hidden="true"></span><i>-</i>Twitter</a></li>
          <li><a href="#" class="google"><span class="fa fa-google-plus" aria-hidden="true"></span><i>-</i>Google+</a></li>
          <li><a href="#" class="instagram"><span class="fa fa-instagram" aria-hidden="true"></span><i>-</i>Instagram</a></li>
        </ul> -->
      </div>
    </div>
  </div>
<!-- //footer -->
<!-- copy-right -->
  <div class="w3agile_copy_right">
    <div class="container">
       <p>© 2017 Playlist Maker. All Rights Reserved</p>
    </div>
  </div>
<!-- //copy-right -->