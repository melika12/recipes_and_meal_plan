<?php
    session_start();

    if (isset($_SESSION['user'])) {
        header('Location: ./home.php');
        exit();
    }
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../js/login.js"></script>

    <title>M&M - Login</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card" id="first">
                        <h3 class="card-title">Login</h3>
                        <form action="../scripts/login.php" name="login" method="post">
                            <div class="form-group">
                                <label for="username" class="required">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="required">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group text-center">
                                Har du ikke en bruger? <a href="#" onclick="signUp();return false;" id="signup">Registrere dig her</a>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>

                    <!-- HIDDEN REGISTER FORM -->
                    <div class="card" id="second" style="display:none">
                        <h3 class="card-title">Register</h3>
                        <form action="../scripts/create_user.php" name="registration" method="post">
                            <div class="form-group">
                                <label for="username" class="required">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="required">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group text-center">
                                <a href="#" onclick="logIn(); return false;" id="signin">Har du allerede en bruger?</a>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                    <!-- HIDDEN REGISTER FORM END -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/halfmoon.min.js"></script>
</body>
</html>