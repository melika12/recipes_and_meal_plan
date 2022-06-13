<?php
  include_once('../api/api_calls.php');
  $recipes = getRecipes();
  $days = getweekdays();
  $ingredients = getIngredients();
?>
<!-- First comes the modal -->
<div class="modal" id="mealplan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 style="font-weight:bold;display:inline-block" class="modal-title">Lav en madplan</h5>
      <input class="btn btn-primary" type="button" id="randomMealplan" value="Generere madplan" style="float:right">
      <p class="text-left">Vil du generere din madplan ud fra ingredienser du allerede har i hjemmet? Så tryk 
        <a data-target="#ingredient_mealplan" data-toggle="modal" href="#ingredient_mealplan">her</a>
      </p>
      <label id="mealplan_error_msg" style="color:red;font-weight:bold"></label>
      <form action="../scripts/send_mealplan.php" id="mealplan_form" method="POST">
        <?php foreach ($days as $day) { ?>
        <div class="form-group" style="display:contents">
          <label style="font-weight:bold"><?= $day['name'] ?></label>
          <select name="<?= $day['name'] ?>" id="<?= $day['name'] ?>" required="required" class="form-control" oninvalid="this.setCustomValidity('Vælg en ret for at oprette madplan')" oninput="setCustomValidity('')">
            <option value="" selected="selected" disabled="disabled">Vælg en ret</option>
            <?php foreach ($recipes as $recipe) { ?>
            <option value="<?= $recipe['name'] ?>"><?= $recipe['name'] ?></option>
            <?php } ?>
          </select>
        </div>
        <?php } ?>
        <div class="form-group">
          <label for="mail">Email</label>
          <input type="email" id="mailaddress" name="mail" class="form-control" placeholder="E-mail">
        </div>
        <input style="margin-top:1em" class="btn btn-primary btn-block" id="email" name="email" type="submit" value="Send madplan">
        <input style="margin-top:1em" class="btn btn-primary btn-block" name="calendar" type="submit" value="Tilføj til kalender">
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal" id="ingredient_mealplan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 style="font-weight:bold;display:inline-block" class="modal-title">Vælg de ingredienser du har</h5>
      <label id="mealplan_ingredient_error_msg" style="color:red;font-weight:bold"></label>
      <form action="../scripts/generate_mealplan.php" id="ingredient_mealplan_form" method="POST">
        <div class="form-group">
          <label for="ingredients" class="required">Ingredienser</label>
          <select name="ingredients" id="ingredients" class="form-control">
            <option value="" selected="selected" disabled="disabled">Vælg en ingrediens</option>
            <?php foreach ($ingredients as $ingredient) { ?>
            <option value="<?= $ingredient['name'] ?>"><?= $ingredient['name'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group">
        <a class="btn btn-primary btn-block" id="add_ingredient" onclick="add_ingredient_mealplan();return false">Tilføj</a>
        </div>
        <div class="form-group" id="i" name="i" style="max-height:15vw; overflow:auto">
          <table class="table table-inner-bordered" id="ingredient_mealplan_table" name="ingredient_mealplan_table">
          </table>
          <input type="hidden" id="ingredient_counter" name="ingredient_counter">
        </div>
        <div class="form-group">
          <input style="margin-top:1em" class="btn btn-primary btn-block" name="generate_mealplan" name="generate_mealplan" type="submit" value="Generere madplan">
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../js/mealplan.js"></script>
<script type="text/javascript">
  //randomizes the recipes on the week days
  document.getElementById("randomMealplan").addEventListener("click", function() {
    //resets error message
    document.getElementById('mealplan_error_msg').innerHTML = "";
    var weekdays = <?= json_encode($days); ?>;
    var alreadyChosen = [];
    var items = document.getElementById('Mandag').getElementsByTagName('option');
    var length = items.length-1;
    //checks if there is less than 7 recipes
    if (length < 7) {
      document.getElementById('mealplan_error_msg').innerHTML = "Der er ikke nok opskrifter til at generere en madplan";
    } else {
      //getting each week day and randomizes the recipe
      weekdays.forEach(day => {
        var select = document.getElementById(day['name']);
        var index = Math.floor(Math.random() * length) + 1;
        //checks if the recipe has already been chosen and keeps randomizing till it lands on one that has not beenh chosen
        while (alreadyChosen.includes(index)) {
          index = Math.floor(Math.random() * length) + 1;
        }
        alreadyChosen.push(index);
        select.selectedIndex = index;
      });
    }
  });
</script>