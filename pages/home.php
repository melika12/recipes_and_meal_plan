<?php 
  session_start();
  include_once('../api/api_calls.php');
  include('generated_mealplan.php');

  $data = getRecipes();
  if(isset($_SESSION['searchedList'])) {
        $data = $_SESSION['searchedList'];
  }
  unset($_SESSION['searchedList']);

  $ingredients = getIngredients();
  $units = getUnits();
  $numberOfPeople = getNumberOfPeople();
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
  body {
  overflow: hidden; /* Hide scrollbars */
}
  #content {
    width: 30%;
  }
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
  <title>M&M Retter</title>
</head>
<body class="with-custom-webkit-scrollbars with-custom-css-scrollbars" data-dm-shortcut-enabled="true"
      data-set-preferred-mode-onload="true">

<div class="page-wrapper with-navbar">
    <?php require_once('./navbar.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="content">
                <h2>Retter</h2>
            </div>
            <div class="content text-right">
              <?php if ($_SESSION['user']) { ?>
              <a href="#modal-1" class="btn btn-primary" role="button"><?= ($_SESSION['user']['isAdmin']) ? 'Tilføj ny opskrift' : 'Anmodning om ny opskrift' ?></a>
              <?php } ?>
            </div>
            <?php foreach ($data as $d) { ?>
            <div class="card">
              <div class="row mt-20">
                  <div class="col-3 mr-20 text-center">
                    <img src="../img/<?= (is_null($d['img'])) ? 'placeholder.png' : $d['img'] ?>" class="img-fluid rounded-circle" height="100" width="100" name="image" alt="Image">
                  </div>          
                  <div class="col">
                    <div class="text-right"> 
                      <?php if ($_SESSION['user']['isAdmin']) { ?>
                        <a href="#recipe-modal<?= $d['id'] ?>" class="btn btn-primary" style="display:inline-block" role="button">Redigér</a>
                        <form action="../scripts/delete.php" style="display:inline" method="post">
                          <input type="hidden" name="recipe_id" value="<?= $d['id'] ?>">
                          <input type="hidden" name="recipe_img" value="<?= $d['img'] ?>">
                          <button class="btn btn-danger" type="submit" name="delete_recipe" onclick="return confirm('Er du sikker på at du vil slette denne opskrift?')">
                            <i class="fas fa-user-times"></i> Slet
                          </button>                            
                        </form>
                      <?php } ?>
                    </div>  
                      <?php if ($d['name']) { ?>
                          <h5 class="mt-0"><?= $d['name'] ?></h5>
                      <?php } ?>
                      <p>Tilberedningstid: <?= $d['time'] ?> minutter</p>
                  </div>    
              </div>    
              <div class="text-right"> 
                <a href="meals.php?recipe=<?= $d['id'] ?>" class="btn">Læs mere</a>
              </div>  
            </div>  
            <?php } ?>
        </div>
    </div>
</div>

<!-- Add recipe modal -->
<div class="modal" id="modal-1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div id="content" class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title"><?= ($_SESSION['user']['isAdmin']) ? 'Tilføj ny opskrift' : 'Anmodning til ny opskrift' ?></h5>
      <form action="../scripts/request_or_add.php" method="POST" enctype="multipart/form-data">
        <div id="start-info">
        <label id="error_msg" style="color:red;font-weight:bold"></label>
        <div class="form-group">
          <label for="image">Billede af retten</label>
          <input type="file" name="image" id="image" onchange="loadFile(event)" class="form-control custom-file">
          <img id="output" class="img-fluid rounded" width="100" height="100" />
        </div>
        <div class="form-group">
          <label for="meal_name" class="required">Rettens navn</label>
          <input type="text" id="meal_name" name="meal_name" class="form-control" placeholder="Navn" required="required" >
        </div>
        <div class="form-group">
          <label for="meal_time" class="required">Tilberedningstid (i minutter)</label>
          <input type="number" id="meal_time" name="meal_time" class="form-control" placeholder="Tilberedningstid" required="required" min="1">
        </div>
        <div class="form-group">
        <label for="count" class="required">Antal personer</label>
          <select class="form-control" id="count" name="count" required="required">
            <option value="" selected="selected" disabled="disabled">Vælg antal personer retten passer til</option>
            <?php
                foreach($numberOfPeople as $number) {
                    echo "<option value='".$number['id']."'>".$number['count_of_people']."</option>";
                }
            ?>
          </select>
        </div>
        <a class="btn btn-primary btn-block" id="request_next" onclick="next_modal();return false">Næste</a>
        </div>
        <div id="ingredient-info" style="display:none">
        <label id="error_ingredient" style="color:red;font-weight:bold"></label>
        <div class="form-group">
            <div class="row-eq-spacing">
          <label for="meal_ingredients" class="required">Rettens Ingredienser</label>
          <select class="form-control" id="meal_ingredients" name="meal_ingredients">
            <option value="" selected="selected" disabled="disabled">Vælg en ingrediens</option>
            <?php
                foreach($ingredients as $ingredient) {
                    echo "<option value='".$ingredient['name']."'>".$ingredient['name']."</option>";
                }
            ?>
          </select>
        </div>
        <div class="row-eq-spacing">
        <label for="amount" class="required">Mængden af ingrediensen</label>
            <input type="number" id="amount" class="form-control" placeholder="Mængden af ingrediensen" min="1">
        </div>
        <div class="row-eq-spacing">
        <label for="unit" class="required">Måleenhed</label>
          <select class="form-control" id="unit" name="unit">
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
        <a class="btn btn-primary btn-block" id="request_add_ingredient" onclick="add_ingredient();return false">Tilføj</a>
        </div>
        <div class="form-group" id="m_i" name="m_i" style="max-height:15vw; overflow:auto">
          <table class="table table-inner-bordered" id="ingredient_table" name="ingredient_table">
          </table>
          <input type="hidden" id="counter" name="counter" value="0">
        </div>
        <a class="btn btn-primary btn-block" id="request_last" onclick="last_modal();return false">Næste</a>
      </div>
      <div id="course-info" style="display:none">
      <div class="form-group">
          <label for="course_text" class="required">Fremgangsmåde</label>
          <textarea id="course_text" name="course_text" class="form-control" placeholder="Fremgangsmåde" style="resize:none" required="required" ></textarea>
        </div>
          <input class="btn btn-primary btn-block" type="submit" name="request_recipe" value="<?= ($_SESSION['user']['isAdmin']) ? 'Tilføj opskrift' : 'Indsend Anmodning'?>">
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit recipe modal -->
<?php 
  foreach($data as $recipe) { 
    $recipeIngredients = getRecipeIngredients($recipe['id']);
  ?>
<div class="modal" id="recipe-modal<?= $recipe['id'] ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div id="content" class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Tilpasning af opskrift</h5>
      <form action="../scripts/edit_recipe_data.php" method="POST" enctype="multipart/form-data">
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

<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    var loadEditFile = function(event, id) {
        var image = document.getElementById('output'+id);
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
</body>
</html>