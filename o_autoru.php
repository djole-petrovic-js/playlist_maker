<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <?php include_once 'inc/metadata.php'; ?>
  <link rel="stylesheet" type="text/css" href="public/css/custom.css">
  <link rel="stylesheet" type="text/css" href="public/css/style1.css">
</head>
<body>
  <?php include_once 'inc/banner.php'; ?>
  <div class="container">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-12">
          <h1>O autoru</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
            <img class="img-responsive" src="public/images/Djordje-Petrovic.jpg" id="img">
        </div>
        <div class="col-md-4">
            <p id="bio">Ja sam Djordje Petrovic. Rodjen sam u Pirotu, a zivim u Beogradu od 2010-e godine, i imam 24 godina. Trenutno studiram web programiranje na Visokoj ICT skoli u Beogradu. U slobodno vreme volim da gledam filmove , da igram poker, da izlazim itd itd...</p>
        </div>
      </div>
    </div>
  </div>
  <?php include_once 'inc/footer.php' ?>
</body>
</html>