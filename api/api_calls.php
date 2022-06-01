<?php
include_once('../conn.php');

/// ---------------------- RECIPES ---------------------- ///
function getRecipe() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipeitems', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getRecipeId($id) {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipeitems/'.$id, false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
    return $data;
  }
}

function getRecipeByName($name) {
  $get_meal = callAPI('GET', 'http://localhost:5000/api/recipeItems/meal?name='.$name, false);
  if (is_int($get_meal)) {
    return $get_meal;
  } else {
    $data = json_decode($get_meal, true);   
    return $data;
  }
}

function insertRecipe($name, $desc, $course) {
  $data_array =  array(
    "name"             => $name,
    "description"      => $desc,
    "course_of_action" => $course,
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/recipeitems', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function updateRecipe($id, $image, $name, $description, $course_of_action) {
  $data_array =  array(
    "id" => $id,
    "img" => $image,
    "name" => $name,
    "description" => $description,
    "course_of_action" => $course_of_action
  );
  $put_data = callAPI('PUT', 'http://localhost:5000/api/recipeItems/'.$id, json_encode($data_array));
  if (is_int($put_data)) {
    return $put_data;
  } else {
    return;
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
  $get_user = callAPI('GET', 'http://localhost:5000/api/users/name?username='.$name, false);
  if (is_int($get_user)) {
    return $get_user;
  } else {
    $data = json_decode($get_user, true);   
    return $data;
  }
}

function updateUser($id, $username, $password) {
  $data_array =  array(
    "id" => $id,
    "username" => $username,
    "password" => $password
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

/// ---------------------- Recipe Requests ---------------------- ///
function insertRecipeRequest($userid, $recipe_name, $recipe_img, $recipe_img_type, $recipe_desc, $recipe_coa) {
  $data_array =  array(
    "user_id" => $userid,
    // "ingredient_name" => "",
    // "unit_name" => "",
    "recipe_name" => $recipe_name,
    "recipe_img" => $recipe_img,
    "recipe_img_extension" => $recipe_img_type,
    "recipe_description" => $recipe_desc,
    "recipe_course_of_action" => $recipe_coa,
    "recipe_count_of_people" => 1
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/requests', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}

function getRecipeRequests() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/requests', false);
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

function insertIngredient($name, $desc, $course) {
  $data_array =  array(
    "name"             => $name,
    "description"      => $desc,
    "course_of_action" => $course,
    );
  $post_data = callAPI('POST', 'http://localhost:5000/api/ingredients', json_encode($data_array));
  if (is_int($post_data)) {
    return $post_data;
  } else {
    return;
  }
}
