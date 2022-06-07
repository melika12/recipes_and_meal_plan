<?php
// session_start();

require('../api/api_calls.php');

if(isset($_POST['delete_user'])) {
    deleteUser($_POST['user_id']);
}

header('Location: ../pages/users.php');
exit();
?>