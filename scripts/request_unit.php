<?php
session_start();

include_once('../api/api_calls.php');

if (isset($_POST['request_unit'])) {
    $userid = $_SESSION['user']['id'];
    $unit = $_POST['unit'];
    insertUnitRequest($userid, $unit);

    header('Location: ../pages/units.php');
    exit();
}

// ADMIN
if (isset($_POST['add_unit'])) {
    $unit = $_POST['unit'];
    insertUnit($unit);

    header('Location: ../pages/units.php');
    exit();
}