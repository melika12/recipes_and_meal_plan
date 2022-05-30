<?php
    session_start();

    require('../api/api_calls.php');

    $meal = getRecipeId($_GET['recipe']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="meal" content="<?= $_GET['recipe'] ?>">

    <link rel="stylesheet" href="../css/halfmoon.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <title>M&M - Mad</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="content">
                <h2><?= $meal['name'] ?></h2>
            </div>

            <div class="card">
                <div class="row mt-20">
                    <div class="col">
                        <h5 class="mt-0">Fremgangsmetode:</h5>
                        <p><?= $meal['course_of_action'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/halfmoon.min.js"></script>
</body>
</html>