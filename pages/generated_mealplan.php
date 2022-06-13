<?php
  include_once('../api/api_calls.php');
  if(isset($_SESSION['chosenRecipes'])) {
    $chosenRecipes = $_SESSION['chosenRecipes'];
  }

  $days = getweekdays();
  $recipes = getRecipes();

  unset($_SESSION['chosenRecipes']);
?>
<!-- First comes the modal -->
<div class="modal" id="generated_mealplan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 style="font-weight:bold;display:inline-block" class="modal-title">Lav en madplan</h5>
      <label id="generated_mealplan_error_msg" style="color:red;font-weight:bold"></label>
      <form action="../scripts/send_mealplan.php" id="generated_mealplan_form" method="POST">
        <?php 
        $counter = 0;
         foreach ($days as $day) { ?>
        <div class="form-group" style="display:contents">
          <label style="font-weight:bold"><?= $day['name'] ?></label>
          <select name="<?= $day['name'] ?>" id="generated_<?= $day['name'] ?>" required="required" class="form-control" oninvalid="this.setCustomValidity('Vælg en ret for at oprette madplan')" oninput="setCustomValidity('')">
            <option value="" selected="selected" disabled="disabled">Vælg en ret</option>
            <?php foreach ($recipes as $recipe) {                  
                if($chosenRecipes[$counter]['id'] == $recipe['id']) {
                    echo "<option selected='selected' value='".$recipe['name']."'>".$recipe['name']."</option>";
                } else {
                    echo "<option value='".$recipe['name']."'>".$recipe['name']."</option>";
                }
            }
            $counter++; ?>
          </select>
        </div>
        <?php } ?>
        <div class="form-group">
          <label>Email</label>
          <input type="email" id="mailaddress_mealplan" name="mailaddress_mealplan" class="form-control" placeholder="E-mail">
        </div>
        <input style="margin-top:1em" class="btn btn-primary btn-block" id="emailaddress" name="emailaddress" type="submit" value="Send madplan">
        <input style="margin-top:1em" class="btn btn-primary btn-block" name="add_calendar" type="submit" value="Tilføj til kalender">
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
//assures that you have written an email address before sending the mealplan
document.getElementById("emailaddress").addEventListener("click", function(event) {
    document.getElementById('generated_mealplan_error_msg').innerHTML = "";
    if (document.getElementById('mailaddress_mealplan').value == "") {
        event.preventDefault();
        document.getElementById('generated_mealplan_error_msg').innerHTML = "Tilføj en email madplanen skal sendes til";
    } else {
        document.getElementById('generated_mealplan_form').submit();
    }
});
</script>