<?php
  include_once('../api/api_calls.php');
  // define variables and set to empty values

  //taget fra recipes.php og kan evt genbruge noget herfra
//   $nameErr = $courseErr = "";
//   $name = $desc = $course = "";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   if (empty($_POST["name"])) {
//     $nameErr = "Navn på retten er påkrævet";
//   } else {
//     $name = test_input($_POST["name"]);
//     // check if name only contains letters and whitespace
//     if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
//       $nameErr = "Kun bogstaver og mellemrum er tilladt";
//     }
//   }

//   if (empty($_POST["course"])) {
//     $courseErr = "Fremgangsmåde er påkrævet";
//   } else {
//     $course = test_input($_POST["course"]);
//   }

//   if (empty($_POST["desc"])) {
//     $desc = "";
//   } else {
//     $desc = test_input($_POST["desc"]);
//   }
// }

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tilføj ret</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            Det her er en madplan og indstillinger
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
