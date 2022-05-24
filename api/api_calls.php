<?php
include_once('../conn.php');
function getRecipe() {
  $get_data = callAPI('GET', 'http://localhost:5000/api/recipeitems', false);
  $response = json_decode($get_data, true);
  $errors = $response['response']['errors'];
  $data = $response['response']['data'][0];
  return $data;
}