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

    <link rel="stylesheet" href="/css/halfmoon.min.css">
    <link rel="stylesheet" href="/css/fontawesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <title>Socialert - Settings</title>
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
                        <a class="btn btn-primary" role="button" href="bio.php">
                            <i class="fa fa-address-card"></i> Biography
                        </a>
                        <a class="btn btn-primary" role="button" href="privacy_policy.php">
                            <i class="fas fa-user-lock"></i> Privacy Policy
                        </a>
                        <form style="display: inline;" action="/scripts/delete_user.php">
                            <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="fas fa-user-times"></i> Delete Profile
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