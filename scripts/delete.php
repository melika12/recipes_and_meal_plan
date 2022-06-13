<?php
session_start();

require('../api/api_calls.php');

//delete user from user page
if (isset($_POST['admin_delete_user'])) {
    deleteUser($_POST['user_id']);
    
    header('Location: ../pages/users.php');
    exit();
}

//delete user
if (isset($_POST['delete_user'])) {
    deleteUser($_SESSION['user']['id']);
    
    header('Location: ./logout.php');
    exit();
}

//delete unit
if(isset($_POST['delete_unit'])) {
    deleteUnit($_POST['unit_id']);
    
    header('Location: ../pages/units.php');
    exit();
}

//delete ingredient
if(isset($_POST['delete_ingredient'])) {
    deleteIngredient($_POST['ingredient_id']);

    header('Location: ../pages/ingredient.php');
    exit();
}

//delete recipe
if(isset($_POST['delete_recipe'])) {
    $id = $_POST['recipe_id'];
    //gets the ingredients attached to the recipe
    $recipeIngredients = getRecipeIngredients($id);
    foreach ($recipeIngredients as $ri) {
        //deletes each ingredient attached to the recipe
        deleteRecipeIngredient($ri['id']);
    }
    //deletes the recipe
    deleteRecipe($id);

    //deletes the picture from the img folder
    if (file_exists('../img/'.$_POST['recipe_img'])) {
        unlink('../img/'.$_POST['recipe_img']);
    }

    header('Location: ../pages/home.php');
    exit();
}
