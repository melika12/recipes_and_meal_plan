<?php
include_once('../api/api_calls.php'); 

if (isset($_POST['add_admin_user'])) {
    if(!empty($_POST['admin_username']) && !empty($_POST['admin_password'])) {
        insertAdminUser($_POST['admin_username'], $_POST['admin_password']);
    
        header('Location: ../pages/users.php');
        exit();
    }
} 
?>