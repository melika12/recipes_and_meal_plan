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

function getUserByName($name) {
  $get_user = callAPI('GET', 'http://localhost:5000/api/users/name?username='.$name, false);
  if (is_int($get_user)) {
    return $get_user;
  } else {
    $data = json_decode($get_user, true);   
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