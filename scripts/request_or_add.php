<?php
session_start();
error_reporting(0);
include_once('../api/api_calls.php');
$ingredients = getIngredients();
$units = getUnits();

//request or add recipe
if (isset($_POST['request_recipe'])) {
    $newFilename = null;
    if(isset($_FILES['image'])){
       $errors= array();
       $file_name = $_FILES['image']['name'];
       $file_tmp =$_FILES['image']['tmp_name'];
       $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
 
       $extensions= array("jpeg","jpg","png");
 
       if(in_array($file_ext,$extensions)=== false){
          $errors[]="extension not allowed, please choose a JPEG or PNG file.";
       }
 
       $timestamp = date("dmYHis");
       $newFilename = $_POST['meal_name']."-".$timestamp.'.'.$file_ext;
 
       if(empty($errors)==true){
          move_uploaded_file($file_tmp,"../img/".$newFilename);
        }else{
            $newFilename = null;
        }
    } 
    insertRecipeRequest($_POST['meal_name'], $newFilename, $_POST['meal_time'], $_POST['course_text'], $_POST['count']);
    $recipe = [];
    $recipe = getRecipeByName($_POST['meal_name']);

    //looping through the counter to see how many there was added
    for ($i=$_POST['counter']; $i > 0; $i--) { 
        //checks if the name exists
        if(isset($_POST['ingredient'.$i])) {
            $input = $_POST['ingredient'.$i];
            //make an array that gets the ingredient name, amount abd unit name
            $iau = explode('|',$input);
            $amount = $iau[1];
            //gets the id of unit and ingredient
            $found_i = array_search($iau[0], array_column($ingredients, 'name'));
            $found_u = array_search($iau[2], array_column($units, 'name'));

            //sleeps in i microsecond
            usleep(1);
            //inserts in the recipeingredient table
            insertRecipeIngredientRequest($recipe[0]['id'], $ingredients[$found_i]['id'], $amount, $units[$found_u]['id']);
        }
    }
    header('Location: ../pages/home.php');
    exit();
}

//request or add unit
if (isset($_POST['request_unit'])) {
    $unit = $_POST['unit'];
    insertUnitRequest($unit);

    header('Location: ../pages/units.php');
    exit();
}

//request or add ingredient
if (isset($_POST['request_ingredient'])) {
    $ingredient = $_POST['ingredient_name'];
    insertIngredientRequest($ingredient);

    header('Location: ../pages/ingredient.php');
    exit();
}