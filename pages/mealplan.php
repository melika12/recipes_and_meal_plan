<?php
  include_once('../api/api_calls.php');
  $recipes = getRecipe();
  $days = getweekdays();
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
      <form action="../scripts/send_mealplan.php" method="POST">
        <?php foreach ($days as $day) { ?>
        <div class="form-group" style="display:contents">
          <label style="font-weight:bold"><?= $day['name'] ?></label>
          <select name="<?= $day['name'] ?>" id="<?= $day['name'] ?>" required="required" class="form-control" oninvalid="this.setCustomValidity('Vælg en ret for at oprette madplan')" oninput="setCustomValidity('')">
            <option value="" selected="selected" disabled="disabled">Vælg en ret</option>
            <?php foreach ($recipes as $recipe) { ?>
            <option id="<?= $recipe['id'] ?>" value="<?= $recipe['name'] ?>"><?= $recipe['name'] ?></option>
            <?php } ?>
          </select>
        </div>
        <?php } ?>
        <div class="form-group">
          <label for="mail" class="required">Email</label>
          <input type="email" name="mail" class="form-control" placeholder="E-mail" required="required">
        </div>
        <input style="margin-top:1em" class="btn btn-primary btn-block" type="submit" value="Send madplan">
      </form>
    </div>
  </div>
</div>

<script src="../js/halfmoon.min.js"></script>
<script type="text/javascript">
  //randomizes the recipes on the week days
  document.getElementById("randomMealplan").addEventListener("click", function() {
    var weekdays = <?= json_encode($days); ?>;
    var alreadyChosen = [];
    //getting each week day and randomizes the recipe
    weekdays.forEach(day => {
      var select = document.getElementById(day['name']);
      var items = select.getElementsByTagName('option');
      var length = items.length-1;
      var index = Math.floor(Math.random() * length) + 1;
      //checks if the recipe has already been chosen and keeps randomizing till it lands on one that has not beenh chosen
      while (alreadyChosen.includes(index)) {
        index = Math.floor(Math.random() * length) + 1;
      }
      alreadyChosen.push(index);
      select.selectedIndex = index;
    });
  });
</script>