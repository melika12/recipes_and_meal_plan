<?php
include_once('../conn.php');
function getRecipe() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipeitems', false);
  if (is_int($get_data)) {
    return $get_data;
  } else {
    $data = json_decode($get_data, true);   
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