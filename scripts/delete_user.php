<?php
session_start();

require('../api/api_calls.php');

deleteUser($_SESSION['user']['id']);

header('Location: ./logout.php');
exit();
