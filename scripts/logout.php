<?php
    session_start();
    unset($_SESSION['user']);
    header('Location: ../pages/home.php');
    die;
