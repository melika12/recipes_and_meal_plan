<?php
include_once('../api/api_calls.php'); 

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    insertUser($username, $password);
} else {
    header('Location: ../pages/register.php');
}

header('Location: ../pages/login.php');
exit();