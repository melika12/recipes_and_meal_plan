<?php
    require('../api/api_calls.php');

    if($_GET['search'] != '') {
        $meal = getRecipeByName($_GET['search']);
    
        if($meal) {
            header('Location: ../pages/meals.php?recipe='.$meal['id']);
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>