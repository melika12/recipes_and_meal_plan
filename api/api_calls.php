<?php
include_once('../conn.php');

/// ---------------------- RECIPES ---------------------- ///
function getRecipes() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipes', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getRecipeById($id) {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipes/'.$id, false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getRecipeByName($name) {
  $url = 'http://localhost:5000/api/recipes/meal?name='.$name;
  $url = str_replace(" ","%20",$url);
  $get_meal = callAPI('GET', $url, false);
  if (is_int($get_meal)) {
    return $get_meal;
  } else {
    $data = json_decode($get_meal, true);
    return $data;
  }
}

function insertRecipeRequest($name, $img, $time, $coa, $cop) {
  //checks if its request or add
  $request = 1;
  if ($_SESSION['user']['isAdmin']) {
    $request = 0;
  }
  $data_array =  array(
    "name" => $name,
    "img" => $img,
    "time" => $time,
    "course_of_action" => $coa,
    "count_of_people" => $cop,
    "request" => $request
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/recipes', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function acceptRequestedRecipe($id) {
    //request will always be 0 since its only admin that can handle requests
    $patch_data = callAPI('PATCH', 'http://localhost:5000/api/recipes/'.$id, false);
    if (is_int($patch_data)) {
      return $patch_data;
    } else {
      return;
    }
  }  

function deleteRecipe($id) {
    $delete_recipe = callAPI('DELETE', 'http://localhost:5000/api/recipes/'.$id, false);
    if (is_int($delete_recipe)) {
      return $delete_recipe;
    } else {
      $data = json_decode($delete_recipe, true);
      return $data;
    }
  }  

function updateRecipe($id, $name, $img, $time, $coa, $cop) {
  $data_array =  array(
    "id" => $id,
    "name" => $name,
    "img" => $img,
    "time" => $time,
    "course_of_action" => $coa,
    "count_of_people" => $cop,
    "request" => 0
  );
  $put_data = callAPI('PUT', 'http://localhost:5000/api/recipes/'.$id, json_encode($data_array));
  if (is_int($put_data)) {
    return $put_data;
  } else {
    return;
  }
}
  

/// ---------------------- RECIPE INGREDIENTS ---------------------- ///
function getAllRecipeIngredients() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipeingredients', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}


function getRecipeIngredients($id) {
  $get_ingredients = callAPI('GET', 'http://localhost:5000/api/recipeingredients/recipe?recipeid='.$id, false);
  if (is_int($get_ingredients)) {
    return $get_ingredients;
  } else {
    $data = json_decode($get_ingredients, true);   
    return $data;
  }
}

function insertRecipeIngredientRequest($recipeid, $ingredient_id, $amount, $unit_id) {
  $data_array =  array(
    "recipe_id" => $recipeid,
    "ingredient_id" => $ingredient_id,
    "amount" => $amount,
    "unit_id" => $unit_id
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/recipeingredients', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function deleteRecipeIngredient($id) {
    $delete_data = callAPI('DELETE', 'http://localhost:5000/api/recipeingredients/'.$id, false);
    if (is_int($delete_data)) {
      return $delete_data;
    } else {
      $data = json_decode($delete_data, true);
      return $data;
    }
  }

function updateRecipeIngredient($id, $recipeid, $ingredient_id, $amount, $unit_id) {
  $data_array =  array(
    "id" => $id,
    "recipe_id" => $recipeid,
    "ingredient_id" => $ingredient_id,
    "amount" => $amount,
    "unit_id" => $unit_id
  );
  $put_data = callAPI('PUT', 'http://localhost:5000/api/recipeingredients/'.$id, json_encode($data_array));
  if (is_int($put_data)) {
    return $put_data;
  } else {
    return;
  }
}

function getRecipeIngredientsByIngredientIds($ingredientIds) {
  $query = "";
  foreach ($ingredientIds as $ingredientId) {
    $query .= "ingredientIds=".$ingredientId."&";
  }
  $query = substr($query, 0, -1);

  $url = 'http://localhost:5000/api/recipeingredients/ingredients?'.$query;
  $url = str_replace(" ","%20",$url);

  $get_ingredients = callAPI('GET', $url, false);
  if (is_int($get_ingredients)) {
    return $get_ingredients;
  } else {
    $data = json_decode($get_ingredients, true);   
    return $data;
  }
}
  

/// ---------------------- USERS ---------------------- ///
function getUser() {
  $get_user = callAPI('GET', 'http://localhost:5000/api/users', false);
  if (is_int($get_user)) {
    return $get_user;
  } else {
    $data = json_decode($get_user, true);   
    return $data;
  }
}

function getUserById($id) {
  $get_data = callAPI('GET', 'http://localhost:5000/api/users/'.$id, false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getUserByName($name) {
  $url = 'http://localhost:5000/api/users/name?username='.$name;
  $url = str_replace(" ","%20",$url);
  $get_user = callAPI('GET', $url, false);
  if (is_int($get_user)) {
    return $get_user;
  } else {
    $data = json_decode($get_user, true);   
    return $data;
  }
}

function updateUser($id, $username, $password, $isAdmin) {
  $isAdmin = ($isAdmin) ? true : false;
  $data_array =  array(
    "id" => $id,
    "username" => $username,
    "password" => $password,
    "isAdmin" => $isAdmin
  );
  $put_data = callAPI('PUT', 'http://localhost:5000/api/users/'.$id, json_encode($data_array));
  if (is_int($put_data)) {
    return $put_data;
  } else {
    return;
  }
}

function deleteUser($id) {
  $delete_user = callAPI('DELETE', 'http://localhost:5000/api/users/'.$id, false);
  if (is_int($delete_user)) {
    return $delete_user;
  } else {
    $data = json_decode($delete_user, true);
    return $data;
  }
}

function insertUser($username, $password) {
  $data_array =  array(
    "username" => $username,
    "password" => $password
  );
  $post_data = callAPI('POST', 'http://localhost:5000/api/users', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function insertAdminUser($username, $password) {
  $data_array =  array(
    "username" => $username,
    "password" => $password,
    "isAdmin" => true
  );
  $post_data = callAPI('POST', 'http://localhost:5000/api/users', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

/// ---------------------- WEEKDAYS ---------------------- ///
function getweekdays() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/weekdays', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

/// ---------------------- REQUESTS ---------------------- ///
function getRecipeRequests() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipes/requests', false);
	if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getIngredientRequests() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/ingredients/requests', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getUnitRequests() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/units/requests', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}
    

/// ---------------------- INGREDIENTS ---------------------- ///
function getIngredients() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/ingredients', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getIngredientId($id) {
  $get_data = callAPI('GET', 'http://localhost:5000/api/ingredients/'.$id, false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getIngredientByName($name) {
  $url = 'http://localhost:5000/api/ingredients/name?ingredientname='.$name;
  $url = str_replace(" ","%20",$url);

  $get_data = callAPI('GET', $url, false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function insertIngredientRequest($name) {
  //checks if its request or add
  $request = 1;
  if ($_SESSION['user']['isAdmin']) {
    $request = 0;
  }
  
  $data_array =  array(
    "name" => $name,
    "request" => $request
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/ingredients', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function deleteIngredient($id) {
  $delete_ingredient = callAPI('DELETE', 'http://localhost:5000/api/ingredients/'.$id, false);
  if (is_int($delete_ingredient)) {
    return $delete_ingredient;
  } else {
    $data = json_decode($delete_ingredient, true);
    return $data;
  }
}

function saveRequestedIngredient($id, $name) {
  //request will always be 0 since its only admin that can handle requests
  $data_array =  array(
    "id" => $id,
    "name" => $name,
    "request" => 0
  );
  $put_data = callAPI('PUT', 'http://localhost:5000/api/ingredients/'.$id, json_encode($data_array));
  if (is_int($put_data)) {
    return $put_data;
  } else {
    return;
  }
}

function acceptRequestedIngredient($id) {
    //request will always be 0 since its only admin that can handle requests
    $patch_data = callAPI('PATCH', 'http://localhost:5000/api/ingredients/'.$id, false);
    if (is_int($patch_data)) {
      return $patch_data;
    } else {
      return;
    }
  }  

/// ---------------------- UNITS ---------------------- ///
function getUnits() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/units', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getUnitByName($name) {
  $url = 'http://localhost:5000/api/units/name?unitname='.$name;
  $url = str_replace(" ","%20",$url);

  $get_data = callAPI('GET', $url, false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function deleteUnit($id) {
  $delete_unit = callAPI('DELETE', 'http://localhost:5000/api/units/'.$id, false);
  if (is_int($delete_unit)) {
    return $delete_unit;
  } else {
    $data = json_decode($delete_unit, true);
    return $data;
  }
}

function insertUnitRequest($unit) {
  //checks if its request or add
  $request = 1;
  if ($_SESSION['user']['isAdmin']) {
    $request = 0;
  }
  
  $data_array =  array(
    "name" => $unit,
    "request" => $request
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/units', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function saveRequestedUnit($id, $name) {
    //request will always be 0 since its only admin that can handle requests
    $data_array =  array(
      "id" => $id,
      "name" => $name,
      "request" => 0
    );
    $put_data = callAPI('PUT', 'http://localhost:5000/api/units/'.$id, json_encode($data_array));
    if (is_int($put_data)) {
      return $put_data;
    } else {
      return;
    }
  }  

  function acceptRequestedUnit($id) {
    //request will always be 0 since its only admin that can handle requests
    $patch_data = callAPI('PATCH', 'http://localhost:5000/api/units/'.$id, false);
    if (is_int($patch_data)) {
      return $patch_data;
    } else {
      return;
    }
  }  

/// ---------------------- NUMBER OF PEOPLE ---------------------- ///
function getNumberOfPeople() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/numberofpeople', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}