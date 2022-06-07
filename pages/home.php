<?php 
  session_start();
  include_once('../api/api_calls.php');

  $data = getRecipe();
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
  <link rel="stylesheet" href="../css/halfmoon.min.css">
  <link rel="stylesheet" href="../css/fontawesome.min.css">
<!-- CSS style for numbered input field to hide arrows -->
<style>
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

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="../js/halfmoon.min.js"></script>
<script type="text/javascript">  
  function next_modal() {
    //resets the error message p tag
    document.getElementById("error_msg").innerHTML = "";
    let allAreFilled = true;
    let msg = "";
    
    //checks if all the required fields has been filled
    if (document.getElementById("meal_name").value == "") {
      allAreFilled = false;
      msg = "Angiv et navn til retten.\n";
    }
    if (document.getElementById("meal_time").value == "" || document.getElementById("meal_time").innerHTML > 0) {
      allAreFilled = false;
      msg += "Angiv en tid til retten.\n";
    }
    if (document.getElementById("count").value == "") {
      allAreFilled = false;
      msg += "Angiv antal personer til retten.";
    }
  
    if (!allAreFilled) {
      document.getElementById("error_msg").innerHTML = msg;
    } 
    else { 
      document.getElementById("ingredient-info").style.display = 'unset';
      document.getElementById("start-info").style.display = 'none';
    }
  }

function last_modal() {
    //resets the error message
    document.getElementById("error_ingredient").innerHTML = "";
    let allAreFilled = true;
    let msg = "";
    
    //checks if all the required fields has been filled
    if (document.getElementById("ingredient_table").rows.length < 1) {
      allAreFilled = false;
      msg = "Angiv minimum 1 ingrediens til retten.\n";
    }
  
    if (!allAreFilled) {
      document.getElementById("error_ingredient").innerHTML = msg;
    } 
    else { 
      document.getElementById("course-info").style.display = 'unset';
      document.getElementById("ingredient-info").style.display = 'none';
    }
}


  //adds ingredient to the ingredient table
  function add_ingredient() {
    //resets the error message 
    document.getElementById("error_ingredient").innerHTML = "";
    let allAreFilled = true;
    let msg = "";

    //checks if all the required fields has been filled
    if (document.getElementById("meal_ingredients").value == "") {
      allAreFilled = false;
      msg = "Angiv en ingrediens før du tilføjer.\n";
    }
    if (document.getElementById("amount").value == "" || document.getElementById("amount").innerHTML > 0) {
      allAreFilled = false;
      msg += "Angiv mængden af ingrediensen.\n";
    }
    if (document.getElementById("unit").value == "") {
      allAreFilled = false;
      msg += "Angiv måleenheden til ingrediensen.";
    }

    if (!allAreFilled) {
      document.getElementById("error_ingredient").innerHTML = msg;
    } 
    else { 
      var table = document.getElementById("ingredient_table");

      //adds header to the table with ingredients
      if (table.rows.length == 0) {
        var header = table.createTHead();
        var row = header.insertRow();    
        var cell1 = row.insertCell();
        cell1.innerHTML = "Ingrediens";
        var cell2 = row.insertCell();
        cell2.innerHTML = "Mængde";
        var cell3 = row.insertCell();
        cell3.innerHTML = "Måleenhed";
        var cell4 = row.insertCell();
        cell4.innerHTML = "#";
        
        //create a tbody for the table
        table.createTBody();
      }

      //checks if the ingredient already are added to the table
      var rowCount = table.rows.length;
      for(var i= rowCount - 1; i >= 0; i--) {
        var row = table.rows[i];
        var text = row.cells[0].innerHTML;
        if(text.indexOf(document.getElementById("meal_ingredients").value)!=-1){
          document.getElementById("error_ingredient").innerHTML = "Denne ingrediens er allerede tilføjet";
          exit();
        }
      }

      //adds the ingredient to the table 
      var row = table.insertRow();
      var cell1 = row.insertCell();
      cell1.innerHTML = document.getElementById("meal_ingredients").value;
      var cell2 = row.insertCell();
      cell2.innerHTML = document.getElementById("amount").value;
      var cell3 = row.insertCell();
      cell3.innerHTML = document.getElementById("unit").value;

      //adds a delete a tag to the row
      var aTag = document.createElement('a');
      aTag.setAttribute('onclick', 'delete_ingredient('+(table.rows.length-1)+')');
      aTag.innerText = "Slet";

      var cell4 = row.insertCell();
      cell4.appendChild(aTag);

      refresh_ingredient();
    }
  }

  //delete ingredient from ingredient table
  function delete_ingredient(row) {
    document.getElementById("ingredient_table").deleteRow(row);
  }

  //refresh the chosen data after it was added to the ingredient table
  function refresh_ingredient() {
    document.getElementById("meal_ingredients").value = "";
    document.getElementById("amount").value = "";
    document.getElementById("unit").value = "";
  }
</script>
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
                <?php if($_SESSION['user'] && $_SESSION['user']['isAdmin'] != true) { ?>
                    <a href="#modal-1" class="btn btn-success" role="button">Anmod om ny opskrift</a>
                <?php } ?>
            </div>
            <?php foreach ($data as $d) { ?>
            <div class="card">
              <div class="row mt-20">
                  <div class="col-3 mr-20 text-center">
                  <?php if (is_null($d['img'])) { ?>
                    <img src="../img/placeholder.png" class="img-fluid rounded-circle" alt="Image">
                    <?php } else { ?>
                    <img src="../img/<?= $d['img'] ?>" class="img-fluid rounded-circle" alt="Image">
                    <?php } ?>
                  </div>          
                  <div class="col">
                      <?php if ($d['name']) { ?>
                          <h5 class="mt-0"><?= $d['name'] ?></h5>
                      <?php } ?>
                      <p>Tilberedningstid: <?= $d['time'] ?> minutter</p>
                  </div>    
              </div>    
              <div class="text-right"> <!-- text-right = text-align: right -->
                <a href="meals.php?recipe=<?= $d['id'] ?>" class="btn">Læs mere</a>
              </div>  
            </div>  
            <?php } ?>
        </div>
    </div>
</div>

<!-- First comes the modal -->
<div class="modal" id="modal-1" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div id="content" class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Anmodning til ny opskrift</h5>
      <form action="../scripts/request_new_recipe.php" method="POST" enctype="multipart/form-data">
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
          <table class="table table-inner-bordered" id="ingredient_table">
          </table>
        </div>
        <a class="btn btn-primary btn-block" id="request_last" onclick="last_modal();return false">Næste</a>
      </div>
      <div id="course-info" style="display:none">
      <div class="form-group">
          <label for="course_text" class="required">Fremgangsmåde</label>
          <textarea id="course_text" name="course_text" class="form-control" placeholder="Fremgangsmåde" style="resize:none" required="required" ></textarea>
        </div>

        <input class="btn btn-primary btn-block" type="submit" name="request_recipe" value="Indsend Anmodning">
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
</body>
</html>