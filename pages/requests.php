<?php 
  session_start();

  include_once('../api/api_calls.php');

  $recipeRequests = getRecipeRequests();
  $ingredients = getIngredients();
  $units = getUnits();
  $numberOfPeople = getNumberOfPeople();

  $ingredientRequests = getIngredientRequests();
  if($ingredientRequests != null) {
    usort($ingredientRequests,function($a,$b) {return strnatcasecmp($a['name'],$b['name']);});
  }

  $unitRequests = getUnitRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS style for numbered input field to hide arrows -->
<style>
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
</style>

    <script src="../js/recipe.js"></script>
    <title>M&M Anmodninger</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars dark-mode" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container">

            <!-- Recipe requests -->
            <div class="content">
                <h2>Opskriftsanmodninger</h2>
            </div>
            <div class="card">
            <?php 
                echo (count($recipeRequests) == 0) ? '<h4 class="card-title">Der er ingen nye anmodninger</h4>': '';
                foreach ($recipeRequests as $meal) { 
                    $ingredientAmountUnit = getRecipeIngredients($meal['id']); 
            ?>
                <div class="alert filled-lm" style="margin-bottom:inherit" role="alert">
                    <form action="../scripts/accept_edit_reject.php" method="post">
                        <div class="content row">
                            <div class="col">
                                <h4><?= $meal['name'] ?></h4>
                                <img src="../img/<?= (is_null($meal['img'])) ? 'placeholder.png' : $meal['img'] ?>" class="img-fluid rounded-circle" height="100" width="100" name="image" alt="Image">
                            </div>
                            <div class="row mw-full">
                                <div class="col p-5" style="min-width:200px">
                                    <h5 class="mt-0">Fremgangsmåde:</h5>
                                    <p><?php foreach(explode("\r\n", $meal['course_of_action']) as $txt) { echo $txt.'<br>'; } ?></p>
                                </div>
                                <div class="col p-5">
                                    <h5 class="mt-0">Tilberedningstid:</h5>
                                    <p><?= $meal['time'] ?> minutter</p>
                                </div>
                                <div class="col p-5">
                                  <div class="table-responsive">
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
                        <div class="form-group text-right">
                            <a href="../scripts/accept_edit_reject.php?recipeid=<?= $meal['id'] ?>" class="btn btn-primary" role="button">Godkend</a>
                            <a href="#recipe-modal<?= $meal['id'] ?>" class="btn btn-primary" role="button">Redigér</a>
                            <input type="hidden" name="recipe_id" value="<?= $meal['id'] ?>">
                            <input type="hidden" name="recipe_img" value="<?= $meal['img'] ?>">
                            <button class="btn btn-danger" type="submit" name="delete_recipe"
                                    onclick="return confirm('Er du sikker på at du vil afvise denne opskriftsanmodning?')">
                                <i class="fas fa-trash"></i> Afvis
                            </button>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>  

            <!-- Ingredient requests -->
            <div class="content">
                <h2>Ingrediensanmodninger</h2>
            </div>
            <div class="card">
                <div class="row">
                    <?php 
                        echo (count($ingredientRequests) == 0) ? '<h4 class="card-title">Der er ingen nye anmodninger</h4>': '';
                        foreach ($ingredientRequests as $i) { 
                    ?>
                    <div class="alert filled-lm m-5">
                        <form action="../scripts/accept_edit_reject.php" method="post">
                            <h4 class="card-title"><?= $i['name'] ?></h4>
                            <div class="form-group text-right">
                                <a href="../scripts/accept_edit_reject.php?ingredientid=<?= $i['id'] ?>" class="btn btn-primary" role="button">Godkend</a>
                                <a href="#ingredient-modal<?= $i['id'] ?>" class="btn btn-primary" role="button">Redigér</a>
                                <input type="hidden" name="ingredient_id" value="<?= $i['id'] ?>">
                                <button class="btn btn-danger" type="submit" name="delete_ingredient"
                                        onclick="return confirm('Er du sikker på at du vil afvise denne ingrediensanmodning?')">
                                    <i class="fas fa-trash"></i> Afvis
                                </button>
                            </div>
                        </form> 
                    </div>
                    <?php } ?>
                </div> 
            </div>

            <!-- Unit requests -->
            <div class="content">
                <h2>Måleenhedsanmodninger</h2>
            </div>
            <div class="card">
                <div class="row">
                    <?php
                        echo (count($unitRequests) == 0) ? '<h4 class="card-title">Der er ingen nye anmodninger</h4>': '';
                        foreach ($unitRequests as $u) { 
                    ?>
                        <div class="alert filled-lm m-5">
                        <form action="../scripts/accept_edit_reject.php" method="post">
                            <h4 class="card-title"><?= $u['name'] ?></h4>
                            <div class="form-group text-right">
                                <a href="../scripts/accept_edit_reject.php?unitid=<?= $u['id'] ?>" class="btn btn-primary" role="button">Godkend</a>
                                <a href="#unit-modal<?= $u['id'] ?>" class="btn btn-primary" role="button">Redigér</a>
                                <input type="hidden" name="unit_id" value="<?= $u['id'] ?>">
                                <button class="btn btn-danger" type="submit" name="delete_unit"
                                        onclick="return confirm('Er du sikker på at du vil afvise denne måleenhedsanmodning?')">
                                    <i class="fas fa-trash"></i> Afvis
                                </button>
                            </div>
                        </form> 
                    </div>
                    <?php } ?>
                </div> 
            </div>
        </div>
    </div>

<!-- Recipe modal -->
<?php 
  foreach($recipeRequests as $recipe) { 
    $recipeIngredients = getRecipeIngredients($recipe['id']);
  ?>
<div class="modal" id="recipe-modal<?= $recipe['id'] ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div id="content" class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Tilpasning af anmodet opskrift</h5>
      <form action="../scripts/accept_edit_reject.php" method="POST" enctype="multipart/form-data">
        <div id="edit-start-info<?= $recipe['id'] ?>">
        <label id="edit_error_msg<?= $recipe['id'] ?>" style="color:red;font-weight:bold"></label>
        <div class="form-group">
          <label for="image<?= $recipe['id'] ?>">Billede af retten</label>
          <input type="file" name="image<?= $recipe['id'] ?>" id="image<?= $recipe['id'] ?>" onchange="loadEditFile(event,<?= $recipe['id'] ?>)" class="form-control custom-file">
          <img id="output<?= $recipe['id'] ?>" src="../img/<?= (is_null($recipe['img'])) ? 'placeholder.png' : $recipe['img'] ?>" class="img-fluid" height="100" width="100" alt="Image">
        </div>
        <div class="form-group">
          <label for="edit_meal_name<?= $recipe['id'] ?>" class="required">Rettens navn</label>
          <input type="text" id="edit_meal_name<?= $recipe['id'] ?>" name="edit_meal_name<?= $recipe['id'] ?>" class="form-control" value="<?= $recipe['name'] ?>" required="required" >
        </div>
        <div class="form-group">
          <label for="edit_meal_time<?= $recipe['id'] ?>" class="required">Tilberedningstid (i minutter)</label>
          <input type="number" id="edit_meal_time<?= $recipe['id'] ?>" name="edit_meal_time<?= $recipe['id'] ?>" class="form-control" value="<?= $recipe['time'] ?>" required="required" min="1">
        </div>
        <div class="form-group">
        <label for="edit_count<?= $recipe['id'] ?>" class="required">Antal personer</label>
          <select class="form-control" id="edit_count<?= $recipe['id'] ?>" name="edit_count<?= $recipe['id'] ?>" required="required">
            <?php
                foreach($numberOfPeople as $number) {
                    if($recipe['count_of_people'] == $number['id']) {
                        echo "<option selected='selected' value='".$number['id']."'>".$number['count_of_people']."</option>";
                    } else {
                        echo "<option value='".$number['id']."'>".$number['count_of_people']."</option>";
                    }
                }
            ?>
          </select>
        </div>
        <a class="btn btn-primary btn-block" id="edit_next<?= $recipe['id'] ?>" onclick="edit_next_modal(<?= $recipe['id'] ?>);return false">Næste</a>
        </div>
        <div id="edit-ingredient-info<?= $recipe['id'] ?>" style="display:none">
        <label id="edit_error_ingredient<?= $recipe['id'] ?>" style="color:red;font-weight:bold"></label>
        <div class="form-group">
            <div class="row-eq-spacing">
          <label for="edit_meal_ingredients<?= $recipe['id'] ?>" class="required">Rettens Ingredienser</label>
          <select class="form-control" id="edit_meal_ingredients<?= $recipe['id'] ?>" name="edit_meal_ingredients<?= $recipe['id'] ?>">
            <option value="" selected="selected" disabled="disabled">Vælg en ingrediens</option>
            <?php
                foreach($ingredients as $ingredient) {
                    echo "<option value='".$ingredient['name']."'>".$ingredient['name']."</option>";
                }
            ?>
          </select>
        </div>
        <div class="row-eq-spacing">
        <label for="edit_amount<?= $recipe['id'] ?>" class="required">Mængden af ingrediensen</label>
            <input type="number" id="edit_amount<?= $recipe['id'] ?>" class="form-control" placeholder="Mængden af ingrediensen" min="1">
        </div>
        <div class="row-eq-spacing">
        <label for="edit_unit<?= $recipe['id'] ?>" class="required">Måleenhed</label>
          <select class="form-control" id="edit_unit<?= $recipe['id'] ?>" name="edit_unit<?= $recipe['id'] ?>">
            <option value="" selected="selected" disabled="disabled">Vælg måleenheden</option>
            <?php
                foreach($units as $unit) {
                    echo "<option value='".$unit['name']."'>".$unit['name']."</option>";
                }
            ?>
          </select>
        </div>
      </div>
        <div class="form-group">
        <a class="btn btn-primary btn-block" id="edit_add_ingredient<?= $recipe['id'] ?>" onclick="edit_add_ingredient(<?= $recipe['id'] ?>);return false">Tilføj</a>
        </div>
        <div class="form-group" id="edit_m_i<?= $recipe['id'] ?>" name="edit_m_i<?= $recipe['id'] ?>" style="max-height:15vw; overflow:auto">
          <table class="table table-inner-bordered" id="edit_ingredient_table<?= $recipe['id'] ?>" name="edit_ingredient_table<?= $recipe['id'] ?>">
          <thead>
              <tr>
                <th>Ingrediens</th>
                <th>Mængde</th>
                <th>Måleenhed</th>
                <th>#</th>
              </tr>
              </thead>
              <tbody>
            <?php 
            $counter = 1;
            foreach ($recipeIngredients as $ri) {
              echo '<tr id="edit_row'.$counter.'"><td>'.$ingredients[$ri['ingredient_id']-1]['name'].'</td>';
              echo '<td>'.$ri['amount'].'</td>';
              echo '<td>'.$units[$ri['unit_id']-1]['name'].'</td>';
              echo '<td><a onclick="edit_delete_ingredient('.$counter.','.$recipe['id'].')">Slet</a></td>';
              echo '<input type="hidden" id="hidden_edit_row'.$counter.'" name="edit_ingredient'.$counter.'" value="'.$ri['id'].'|'.$ingredients[$ri['ingredient_id']-1]['id'].'|'.$ri['amount'].'|'.$units[$ri['unit_id']-1]['id'].'"></tr>';
              $counter +=1;
             }
             echo '<input type="hidden" id="counter'.$recipe['id'].'" name="counter'.$recipe['id'].'" value="'.$counter.'">';
             ?>
            </tbody>
          </table>
        </div>
        <a class="btn btn-primary btn-block" id="edit_last<?= $recipe['id'] ?>" onclick="edit_last_modal(<?= $recipe['id'] ?>);return false">Næste</a>
      </div>
      <div id="edit-course-info<?= $recipe['id'] ?>" style="display:none">
      <div class="form-group">
          <label for="edit_course_text<?= $recipe['id'] ?>" class="required">Fremgangsmåde</label>
          <textarea id="edit_course_text<?= $recipe['id'] ?>" name="edit_course_text<?= $recipe['id'] ?>" class="form-control" style="resize:none" required="required" ><?= $recipe['course_of_action'] ?></textarea>
        </div>
        <input type="hidden" name="recipe_id" value="<?= $recipe['id'] ?>">
          <input class="btn btn-primary btn-block" type="submit" name="edit_recipe" value="Opdater opskrift">
      </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>

<!-- Ingredient modal -->
<?php foreach($ingredientRequests as $ingredient) { ?>
<div class="modal" id="ingredient-modal<?= $ingredient['id'] ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Tilpasning af anmodet ingrediens</h5>
      <form action="../scripts/accept_edit_reject.php" method="post">
        <div class="form-group">
          <input type="hidden" name="ingredient_id" value="<?= $ingredient['id'] ?>">
          <label for="ingredient" class="required">Ingrediensens navn</label>
          <input type="text" id="ingredient" name="ingredient" class="form-control" value="<?= $ingredient['name'] ?>" required="required">
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="request_ingredient" value="Tilføj ingrediens">
      </form>
    </div>
  </div>
</div>
<?php } ?>

<!-- Unit modal -->
<?php foreach($unitRequests as $unit) { ?>
<div class="modal" id="unit-modal<?= $unit['id'] ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Tilpasning af anmodet måleenhed</h5>
      <form action="../scripts/accept_edit_reject.php" method="post">
        <div class="form-group">
          <input type="hidden" name="unit_id" value="<?= $unit['id'] ?>">
          <label for="unit" class="required">Måleenhed</label>
          <input type="text" id="unit" name="unit" class="form-control" value="<?= $unit['name'] ?>" required="required">
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="request_unit" value="Tilføj måleenhed">
      </form>
    </div>
  </div>
</div>
<?php } ?>
<script>
  var loadEditFile = function(event, id) {
      var image = document.getElementById('output'+id);
      image.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
</body>
</html>