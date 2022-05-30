<?php
session_start();

require('../api/api_calls.php');

if (isset($_POST['save_user_info'])) {
    updateUser($_SESSION['user']['id'], $_POST['username'], $_POST['password']);

    header('Location: ../pages/settings.php');
    exit();
}