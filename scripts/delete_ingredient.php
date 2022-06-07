<?php
require('../api/api_calls.php');

if(isset($_POST['delete_ingredient'])) {
    deleteIngredient($_POST['ingredient_id']);
}

header('Location: ../pages/ingredient.php');
exit();
?>