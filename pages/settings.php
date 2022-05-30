<?php
    session_start();
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <title>M&M - Settings</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="content">
                <h2>
                    <div class="row">
                        <div class="col">
                            Settings
                        </div>
                    </div>
                </h2>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" role="button" href="./user_info.php">
                            <i class="fa fa-address-card"></i> Bruger Detaljer
                        </a>
                        <form style="display: inline;" action="../scripts/delete_user.php">
                            <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Er du sikker på at du vil slette denne bruger?')">
                                <i class="fas fa-user-times"></i> Slet Bruger
                            </button>
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