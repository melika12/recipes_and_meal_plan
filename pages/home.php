<?php 
  session_start();
  include_once('../api/api_calls.php');

  $data = getRecipe();
  if(isset($_SESSION['searchedList'])) {
        $data = $_SESSION['searchedList'];
  }
  unset($_SESSION['searchedList']);

  $ingredients = getIngredients();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
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
                  <div class="col-1 mr-20 text-center">
                      <img src="https://www.pngkey.com/png/full/73-730477_first-name-profile-image-placeholder-png.png"
                            class="img-fluid rounded-circle" alt="Image" style="height: 75px; width: 75px;">
                  </div>          
                  <div class="col">
                      <?php if ($d['name']) { ?>
                          <h5 class="mt-0"><?= $d['name'] ?></h5>
                      <?php } ?>
                      <p><?= $d['description'] ?></p>
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
    <div class="modal-content">
      <a href="#" class="btn close" role="button" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </a>
      <h5 class="modal-title">Anmodning til ny opskrift</h5>
      <form action="../scripts/request_new_recipe.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="file">Billede af retten</label>
          <input type="file" name="file" id="file" onchange="loadFile(event)" class="form-control custom-file">
          <img id="output" class="img-fluid rounded" width="100" />
        </div>
        <div class="form-group">
          <label for="meal_name" class="required">Rettens navn</label>
          <input type="text" id="meal_name" name="meal_name" class="form-control" placeholder="Navn" required="required">
        </div>
        <div class="form-group">
          <label for="meal_ingredients" class="required">Rettens Ingredienser</label>
          <select class="form-control" id="meal_ingredients" name="meal_ingredients">
            <option value="" selected="selected" disabled="disabled">Vælg en ingrediens</option>
            <?php
                foreach($ingredients as $ingredient) {
                    echo "<option value='".$ingredient['name']."'>".$ingredient['name']."</option>";
                }
            ?>
          </select>
          <!-- <input type="text" id="meal_ingredients" class="form-control" placeholder="Ingredienser" required="required"> -->
        </div>
        <div class="form-group" id="m_i" name="m_i">
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="request_recipe" value="Indsend Anmodning">
      </form>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="../js/halfmoon.min.js"></script>
<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };


    function appendButton(elementId, val){
        // var buttonEl = document.createElement("button");
        // buttonEl.href = url;
        var buttonTextEl = document.createElement("span");
        // buttonTextEl.className = "btn btn-primary";
        buttonTextEl.classList.add('btn', 'btn-primary', 'disabled');
        buttonTextEl.innerText = val;
        buttonTextEl.style.margin = "3px";

        document.getElementById(elementId).appendChild(buttonTextEl);
   }


    $('#meal_ingredients').on('change', function(e) {
        // $('#m_i').append($(this).val());
        appendButton('m_i', $(this).val());
    });
</script>
</body>
</html>