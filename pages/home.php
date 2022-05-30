<?php 
  session_start();

  include_once('../api/api_calls.php');

  $data = getRecipe();
  if(isset($_SESSION['searchedList'])) {
        $data = $_SESSION['searchedList'];
  }
  unset($_SESSION['searchedList']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/halfmoon.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <title>M&M Retter</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="content">
                <h2>Retter</h2>
            </div>

            <?php foreach ($data as $d) { ?>
            <div class="card">
              <div class="row mt-20">
                  <div class="col-1 mr-20 text-center">
                      <img src="https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png"
                            class="img-fluid rounded-circle" alt="Image" style="height: 75px; width: 75px;">
                  </div>
                  <div class="col">
                      <?php if ($d['name']) { ?>
                          <h5 class="mt-0"><?= $d['name'] ?></h5>
                      <?php } ?>
                      <p><?= $d['description'] ?></p>
                  </div>
              </div>
              <div class="text-right"> <!-- text-right = text-align: right -->
                <a href="meals.php?recipe=<?= $d['id'] ?>" class="btn">Læs mere</a>
              </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="../js/halfmoon.min.js"></script>
</body>
</html>