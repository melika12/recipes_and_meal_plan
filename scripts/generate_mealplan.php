<?php
session_start();
include_once('../api/api_calls.php');
$days = getweekdays();
$ingredients = getIngredients();
$recipeIngredients = getAllRecipeIngredients();
$recipes = getRecipes();

//Generate mealplan
if (isset($_POST['generate_mealplan'])) {
    $ingredientIds = [];
    //looping through the counter to see how many there was added
    for ($i=$_POST['ingredient_counter']; $i > 0; $i--) { 
        //checks if the name exists
        if(isset($_POST['mealplan_ingredient'.$i])) {
            $input = $_POST['mealplan_ingredient'.$i];
            
            //gets the index of the ingredient
            $found_id = array_search($input, array_column($ingredients, 'name'));
            
            //inserts id in array
            array_push($ingredientIds, $ingredients[$found_id]['id']);
        }
    }
    
    $result = getRecipeIngredientsByIngredientIds($ingredientIds); 
    
    $output = unique_multi_array($result,'recipe_id');
    
    $chosenRecipes = [];
    $alreadyChosen = [];
    foreach ($recipes as $recipe) {
        //gets the index of the recipe id
        $found = array_search($recipe['id'], array_column($output, 'recipe_id'));
        if ($recipe['id'] == $output[$found]['recipe_id']) {
            array_push($chosenRecipes, $recipe);
            array_push($alreadyChosen, $recipe['id']);
        }
    }

    if (count($chosenRecipes) < 7) {
        for ($i = count($chosenRecipes); $i < 7; $i++) {
            $index = rand(0, (count($recipes)-1)); 
            while (in_array($recipes[$index]['id'], $alreadyChosen)) {
                $index = rand(0, (count($recipes)-1)); 
            }
            array_push($chosenRecipes, $recipes[$index]);
            array_push($alreadyChosen, $recipes[$index]['id']);
        }
    } elseif (count($chosenRecipes) > 7) {
        for ($i = count($chosenRecipes); $i > 7; $i--) {
            unset($chosenRecipes[rand(0, count($chosenRecipes)-1)]);
        }
        $chosenRecipes = array_values($chosenRecipes);
    } 
    $_SESSION['chosenRecipes'] = $chosenRecipes;
    header('Location: ../pages/home.php#generated_mealplan');
    // exit();    
}

function unique_multi_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
  }