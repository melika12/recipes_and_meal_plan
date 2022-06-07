<?php
session_start();

include_once('../api/api_calls.php');

if (isset($_POST['request_recipe'])) {

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
            print_r($errors);
        }
    } 
    insertRecipeRequest($_POST['meal_name'], $newFilename, $_POST['meal_time'], $_POST['course_text'], $_POST['count']);

    header('Location: ../pages/home.php');
    exit();
}