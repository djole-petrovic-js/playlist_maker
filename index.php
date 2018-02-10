<?php
  session_start();

  require_once 'utils/executeQuery.php';

  $pollAndOptions = executeQuery("
    SELECT *
    FROM poll p
    INNER JOIN poll_options po
    ON p.id_poll = po.poll_id
  ");

  $pollname = mysqli_fetch_array(executeQuery("SELECT * FROM poll"))['poll_name'];

  $playlists = executeQuery("
    SELECT *
    FROM playlist p
    INNER JOIN user u
    ON p.user_id = u.id_user
    INNER JOIN category
    ON p.category_id = category.id_category
    ORDER BY created_at DESC
    LIMIT 3
  ");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<!-- custom-theme -->
<?php include_once 'inc/metadata.php'; ?>
<link href="public/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" href="public/css/custom.css">
</head>
  
<body>
  <?php include_once 'inc/banner.php'; ?>  
  
  <div class="container">
    <div class="row">
      <div class="col-md-12" id="search">
        <form action="/search.php" method="GET">
          <input type="text" name="q" placeholder="Search for more playlists">
          <button class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

<!-- banner-bottom -->
  <div class="banner-bottom">
    <div class="playlistWreaper">
    
    <?php while ( $row = mysqli_fetch_array($playlists) ): ?>
      <div class="col-md-3 agileits_w3layouts_banner_bottom_grid">
        <div class="hovereffect">
          <a href="/listen.php?playlist=<?php echo $row['id_playlist']; ?>">
            <img src="uploads/<?php echo $row['cover'] ?>" alt="image" class="img-responsive" />
          </a>
        </div>
        <div class="agileinfo_banner_bottom_grid">
          <div class="agileits_banner_bottom_grid1">
            <h4 class="w3ls_color"><?php echo $row['category_name']; ?></h4>
            <h3><?php echo $row['playlist_name']; ?></h3>
            <p>
              Created By <?php echo $row['username']; ?>
               on <?php echo date('d/m/Y',strtotime($row['created_at'])); ?>
            </p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>

    </div>
    <div class="clearfix"></div>
  </div>
<!-- //banner-bottom -->
<!-- about -->
  <div class="about">
    <div class="container">
      <div class="w3_agile_about_grids">
        <div class="col-md-6 w3_agile_about_grid_left">
          <img src="public/images/5.jpg" alt=" " class="img-responsive" />
        </div>
        <div class="col-md-6 w3_agile_about_grid_right">
          <h3>Welcome to Playlist Maker!</h3>
          <div class='panel panel-primary'>
            <div class='panel-heading'>
                <h3 class='panel-title'><?php echo $pollname; ?></h3>
            </div>
            <div class='panel-body'>
                <ul class='list-group' id='pollUL'>
                    <?php while ( $row = mysqli_fetch_array($pollAndOptions) ): ?>
                      <li class='list-group-item'>
                        <div class='checkbox'>
                          <label>
                            <input name='poll' type='radio' value=<?php echo $row['id_poll_options']; ?>> <?php echo $row['option_name']; ?>
                          </label>
                        </div>
                      </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class='panel-footer text-center'>
                <button id='btnVote' type='button' class='btn btn-primary btn-block btn-sm'>
                    Vote!
                </button>
                <button class='btn btn-primary btn-block btn-sm' id='btnShowVotes' class='small'>
                    Get Results!
                </button>
            </div>
          </div>
        </div>
        <div class="clearfix"> </div>
      </div>
    </div>
  </div>
<!-- //about -->

  <?php require_once 'inc/footer.php'; ?>

<!-- bootstrap-pop-up -->
  <div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          Symphony
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>            
        </div>
        <section>
          <div class="modal-body">
            <div class="col-md-6 w3_modal_body_left">
              <img src="public/images/15.jpg" alt=" " class="img-responsive" />
            </div>
            <div class="col-md-6 w3_modal_body_right">
              <h4>Suspendisse et sapien ac diam suscipit posuere</h4>
              <p>Ut enim ad minima veniam, quis nostrum 
              exercitationem ullam corporis suscipit laboriosam, 
              nisi ut aliquid ex ea commodi consequatur? Quis autem 
              vel eum iure reprehenderit qui in ea voluptate velit 
              esse quam nihil molestiae consequatur.
              <i>" Quis autem vel eum iure reprehenderit qui in ea voluptate velit 
                esse quam nihil molestiae consequatur.</i>
                Fusce in ex eget ligula tempor placerat. Aliquam laoreet mi id felis commodo 
                interdum. Integer sollicitudin risus sed risus rutrum 
                elementum ac ac purus.</p>
            </div>
            <div class="clearfix"> </div>
          </div>
        </section>
      </div>
    </div>
  </div>
<!-- //bootstrap-pop-up -->
<!-- flexisel -->
  <script type="text/javascript">
      $(window).load(function() {
        $("#flexiselDemo1").flexisel({
          visibleItems: 3,
          animationSpeed: 1000,
          autoPlay: false,
          autoPlaySpeed: 3000,        
          pauseOnHover: true,
          enableResponsiveBreakpoints: true,
          responsiveBreakpoints: { 
            portrait: { 
              changePoint:480,
              visibleItems: 1
            }, 
            landscape: { 
              changePoint:640,
              visibleItems:2
            },
            tablet: { 
              changePoint:768,
              visibleItems: 2
            }
          }
        });
        
      });
  </script>
  <script type="text/javascript" src="public/js/jquery.flexisel.js"></script>
<!-- //flexisel -->
<!-- start-smooth-scrolling -->
<script type="text/javascript" src="public/js/move-top.js"></script>
<script type="text/javascript" src="public/js/easing.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $(".scroll").click(function(event){    
      event.preventDefault();
      $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
    });
  });
</script>
<!-- start-smooth-scrolling -->
<!-- for bootstrap working -->
  <script src="public/js/bootstrap.js"></script>
<!-- //for bootstrap working -->
<!-- here stars scrolling icon -->
  <script type="text/javascript">
    $(document).ready(function() {
      /*
        var defaults = {
        containerID: 'toTop', // fading element id
        containerHoverID: 'toTopHover', // fading element hover id
        scrollSpeed: 1200,
        easingType: 'linear' 
        };
      */
                
      $().UItoTop({ easingType: 'easeOutQuart' });
                
      });
  </script>
<!-- //here ends scrolling icon -->
  <script src="public/js/index_client.js"></script>
</body>
</html>