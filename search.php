<?php 
  session_start();

  require_once 'utils/executeQuery.php';

  $q = isset($_GET['q']) ? $_GET['q'] : '';
  $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  $limit = 4;
  $offset = ($page - 1) * $limit ;

  $sql = "
    SELECT * FROM playlist p
    INNER JOIN user u
    ON u.id_user = p.user_id
  ";

  if ( $q !== '' ) {
    $sql .= "WHERE p.playlist_name LIKE '%$q%'";
  }

  $sqlWithoutLimit = $sql;

  $sql .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";

  $playlists = executeQuery($sql);

  $numberOfResults = mysqli_num_rows(executeQuery($sqlWithoutLimit));
  $lastPageNumber = ceil($numberOfResults / $limit);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>

  <div class="container">
    <div class="searchWreaper">
      <?php if ( mysqli_num_rows($playlists) == 0 ): ?>
        <div class="alert alert-info">
          <p>No playlist mathes your criteria, please try another query.</p>
        </div>
      <?php else: ?>
        <ul class="list-group">
          <?php while ( $row = mysqli_fetch_array($playlists) ): ?>
            <li class="list-group-item">
              <div class="row">
                <div class="col-md-4">
                  <img class="search_img" src="uploads/<?php echo $row['cover']; ?>">
                </div>
                <div class="col-md-8">
                  <p>
                    <a href="/listen.php?playlist=<?php echo $row['id_playlist']; ?>"><?php echo $row['playlist_name']; ?></a>
                  </p>
                  <p>
                    Created at <?php echo date('d/m/Y',strtotime($row['created_at'])); ?>
                    by <?php echo $row['username']; ?>
                  </p>
                </div>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php endif; ?>
      
    </div>
    <?php if ( mysqli_num_rows($playlists) > 0 ): ?>
      <div class="row">
        <div class="col-md-12" id="pagination">
          <ul class="pagination">
            <?php for ( $i = 1; $i <= $lastPageNumber ;$i++ ): ?>
              <li class="<?php echo $i == $page ? 'active' : '' ?>">
                <?php $searchQuery = $q === '' ? "page=$i" : "q=$q&page=$i" ?>
                <a href="/search.php?<?php echo $searchQuery; ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <?php include_once 'inc/footer.php'; ?>
</body>
</html>