<?php
session_start();

include_once('../api/api_calls.php');

if (isset($_POST['request_ingredient'])) {
    $userid = $_SESSION['user']['id'];
    $ingredient = $_POST['ingredient_name'];
    insertIngredientRequest($userid, $ingredient);

    header('Location: ../pages/ingredient.php');
    exit();
}

// ADMIN
if (isset($_POST['add_ingredient'])) {
    $ingredient = $_POST['ingredient_name'];
    insertIngredient($ingredient);

    header('Location: ../pages/ingredient.php');
    exit();
}