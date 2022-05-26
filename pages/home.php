<?php 
  include_once('../api/api_calls.php'); 
  include('./navbar.php');

?>
<div class="position-relative overflow-hidden p-3 p-md-1 m-md-1 text-center md-light">
  <div class="col-md-5 p-lg-5 mx-auto my-5">
    <h1 class="display-4 fw-normal">M&Ms</h1>
    <p class="lead fw-normal">Retter</p>
  </div>
  <!-- Button to open the 'add meal' -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addRecipe">Tilføj ret</button>
  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    
    <?php 
    $data = getRecipe();
    if (is_int($data)) {
      echo $data;
    } else {
      foreach ($data as $d) {
        echo $d['name'].$d['description'].$d['course_of_action'].'</br></br>';
      } 
    }?>
  </div>
</div>
</body>
</html>