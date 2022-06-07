<?php
session_start();

require('../api/api_calls.php');

if (isset($_POST['save_user_info'])) {
    updateUser($_SESSION['user']['id'], $_POST['username'], $_POST['password']);

    header('Location: ../pages/settings.php');
    exit();
}

if (isset($_POST['save_user_changes'])) {
    updateUser($_POST['user_id'], $_POST['username'], $_POST['password']);

    header('Location: ../pages/users.php');
    exit();
}