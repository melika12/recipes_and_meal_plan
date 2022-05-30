<?php
session_start();

require('../api/api_calls.php');

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: ../pages/login.php');
    exit();
}
$username = $_POST['username'];

$user = getUserByName($username);
$psw = $user['password'];

if ($user === null) {
    header('Location: ../pages/login.php');
    exit();
}

if (!$_POST['password'] == $psw) {
    header('Location: ../pages/login.php');
    exit();
}

// Log user in
$_SESSION['user'] = $user;

header('Location: ../pages/home.php');
exit();
