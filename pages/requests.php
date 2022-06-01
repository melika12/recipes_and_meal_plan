<?php 
  session_start();

  include_once('../api/api_calls.php');

  $recipeRequests = getRecipeRequests();
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
    <title>M&M Anmodninger</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="content">
                <h2>Opskriftsanmodninger</h2>
            </div>
            <?php foreach ($data as $d) { $recipeImage = base64_encode($d['recipe_img']); $imageType = $d['recipe_img_extension']; ?>
            <div class="card">
              <div class="row mt-20">
                  <div class="col-1 mr-20 text-center">
                      <img src="data:<?= $imageType ?>;base64,<?= $recipeImage ?>" alt="<?= $d['recipe_name'] ?>" class="rounded-circle img-fluid w-100 h-100">
                  </div>
                  <div class="col">
                      <h5 class="mt-0"><?= $d['recipe_name'] ?></h5>
                      <h6><?= $d['recipe_description'] ?></h6>
                      <p><?= $d['recipe_course_of_action'] ?></p>
                  </div>
              </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="../js/halfmoon.min.js"></script>
</body>
</html>