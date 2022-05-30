<?php
    session_start();
    require('../api/api_calls.php');

    if($_GET['search'] != '') {
        $meal = getRecipeByName($_GET['search']);
    
        if($meal) {
            $_SESSION['searchedList'] =  $meal;
            header('Location: ../pages/home.php');
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>