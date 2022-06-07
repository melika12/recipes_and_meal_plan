<?php
require('../api/api_calls.php');

if(isset($_POST['delete_unit'])) {
    deleteUnit($_POST['unit_id']);
}

header('Location: ../pages/units.php');
exit();
?>