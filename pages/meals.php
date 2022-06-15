<?php
    session_start();

    require('../api/api_calls.php');
    $id = $_GET['recipe'];
    $meal = getRecipeById($id);
    $ingredientAmountUnit = getRecipeIngredients($id);
    $ingredients = getIngredients();
    $units = getUnits();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="meal" content="<?= $_GET['recipe'] ?>">
    <title>M&M - Mad</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars dark-mode" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="content row">
                <div class="col">
                    <h2><?= $meal['name'] ?></h2>
                </div>
                <div class="col">
                    <img src="../img/<?= (is_null($meal['img'])) ? 'placeholder.png' : $meal['img'] ?>" class="img-fluid rounded-circle" name="image" alt="Image">
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div class="col p-5" style="min-width:200px">
                        <h5 class="mt-0">Fremgangsmåde:</h5>
                        <p><?php foreach(explode("\r\n", $meal['course_of_action']) as $txt) { echo $txt.'<br>'; } ?></p>
                    </div>
                    <div class="col p-5">
                        <h5 class="mt-0">Tilberedningstid:</h5>
                        <p><?= $meal['time'] ?> minutter</p>
                    </div>
                    <div class="col p-5">
                        <table class="table table-bordered">
                            <tr>
                                <th>Ingredienser:</th>
                                <th>Mængde:</th>
                                <th>Måleenhed:</th>
                            </tr>
                            <?php foreach ($ingredientAmountUnit as $iau) { ?>
                            <tr>
                                <td><?= $ingredients[$iau['ingredient_id']-1]['name'] ?></td>
                                <td><?= $iau['amount'] ?></td>
                                <td><?= $units[$iau['unit_id']-1]['name'] ?></td>
                            </tr>
                            <?php } ?> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>