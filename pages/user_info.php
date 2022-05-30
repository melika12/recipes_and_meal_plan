<?php
session_start();
require('../api/api_calls.php');

$editUser = getUserById($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/halfmoon.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <title>M&M - Bruger</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">
    <div class="page-wrapper with-navbar">
        <?php require_once('./navbar.php'); ?>
        <div class="content-wrapper">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="content">
                            <h2>Bruger Detaljer</h2>
                        </div>
                        <div class="card">
                            <h2 class="card-title">Ændre dit password</h2>
                            <form action="../scripts/save_user_info.php" method="post">
                                <div class="form-group">
                                    <label for="username">Brugernavn</label>
                                    <div class="input-group">
                                        <input type="text" name="username" id="username" class="form-control" value="<?= $editUser['username'] ?? '' ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" value="<?= $editUser['password'] ?? '' ?>">
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" name="save_user_info" class="btn btn-primary">Gem</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/js/halfmoon.min.js"></script>
</body>
</html>