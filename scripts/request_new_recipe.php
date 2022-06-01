<?php
session_start();

include_once('../api/api_calls.php');

if (isset($_POST['request_recipe'])) {
    if(!empty($_FILES["file"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["file"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['file']['tmp_name'];
            $image_type = $_FILES['file']['type'];
            $imgContent = file_get_contents($image);
            // Insert image content into database 
            // var_dump($image_type);exit;
            $userid = $_SESSION['user']['id'];
            $meal_name = $_POST['meal_name'];
            // $meal_ingredients_selected = $_POST['meal_ingredients'];

            // var_dump("USERID: ".$userid." | IMAGE_TYPE: ".$image_type." | MEAL_NAME: ".$meal_name);exit;
            insertRecipeRequest($userid, $meal_name, $imgContent, $image_type, "hej", "test test test");
        }
    }

    header('Location: ../pages/home.php');
    exit();
}