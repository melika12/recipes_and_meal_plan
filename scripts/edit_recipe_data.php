<?php
session_start();
require('../api/api_calls.php');

//edit and save requested recipe
if (isset($_POST['edit_recipe'])) {
    $id = $_POST['recipe_id'];
    $ingredients = getIngredients();
    $units = getUnits();
    $oldRecipe = getRecipeById($id);
    $newFilename = null;

    //checks if image has been updated
    if(isset($_FILES['image'.$id.''])){
       $errors= array();
       $file_name = $_FILES['image'.$id.'']['name'];
       $file_tmp =$_FILES['image'.$id.'']['tmp_name'];
       $file_ext=strtolower(end(explode('.',$_FILES['image'.$id.'']['name'])));
 
       $extensions= array("jpeg","jpg","png");
 
       if(in_array($file_ext,$extensions)=== false){
          $errors[]="extension not allowed, please choose a JPEG or PNG file.";
       }
 
       $timestamp = date("dmYHis");
       $newFilename = $_POST['edit_meal_name'.$id.'']."-".$timestamp.'.'.$file_ext;
 
       if(empty($errors)==true){
          move_uploaded_file($file_tmp,"../img/".$newFilename);
        }else{
            $newFilename = null;
        }
    } 
    if ($newFilename == null) {
        $newFilename = $oldRecipe['img'];
    } else {
        //deletes the old picture from the img folder
        if (file_exists('../img/'.$oldRecipe['img'])) {
            unlink('../img/'.$oldRecipe['img']);
        }
    }
    updateRecipe($id, $_POST['edit_meal_name'.$id.''], $newFilename, $_POST['edit_meal_time'.$id.''], $_POST['edit_course_text'.$id.''], $_POST['edit_count'.$id.'']);

    //gets the ingredients attached to the recipe
    $recipeIngredients = array();
    $recipeIngredients = getRecipeIngredients($id);

    //looping through the ingredients to see how many there was added
    for ($i=$_POST['counter'.$id.'']; $i > 0; $i--) { 
        //checks if the name exists
        if(isset($_POST['edit_ingredient'.$i.''])) {
            $input = $_POST['edit_ingredient'.$i.''];

            //make an array that gets the ingredient name, amount abd unit name
            $iau = explode('|',$input);
            $amount = $iau[2];
            //gets the id of unit and ingredient
            $found_i = array_search($iau[1], array_column($ingredients, 'name'));
            $found_u = array_search($iau[3], array_column($units, 'name'));

            //reference id
            $refid = $iau[0];
            //sleeps in i microsecond
            usleep(1);
            if ($refid == 0) {
                //inserts in the recipeingredient table
                insertRecipeIngredientRequest($id, $ingredients[$found_i]['id'], $amount, $units[$found_u]['id']);
            } else {
                $key = array_search($refid, array_column($recipeIngredients, 'id'));
                
                //removes the ingredients that exists and should be on the list
                if (!is_null($key) && $recipeIngredients[$key]['id'] == $refid) {
                    unset($recipeIngredients[$key]);
                }
            }
        }
    }
    if (!empty($recipeIngredients) && sizeof($recipeIngredients) > 0) {
        foreach ($recipeIngredients as $ri) {
            //deletes each ingredient that has been removed from the list
            deleteRecipeIngredient($ri['id']);
        }
    }
    header('Location: ../pages/home.php');
    exit();
}