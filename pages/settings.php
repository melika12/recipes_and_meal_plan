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
    <title>M&M - Indstillinger</title>
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
                            Indstillinger
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
                        <form style="display: inline;" action="../scripts/delete.php" method="post">
                            <button class="btn btn-danger" type="submit" name="delete_user"
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
</body>
</html>