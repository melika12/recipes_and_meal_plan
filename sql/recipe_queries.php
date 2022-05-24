<?php
include_once('../conn.php');
$sql = "SELECT id, name, description, course_of_action FROM recipes";
$result = $conn->query($sql);

$id = 0;
$stmt = $conn->prepare("SELECT ri.amount, u.name AS uname, i.name AS iname FROM recipe_ingredients ri INNER JOIN recipes r ON ri.recipe_id=r.id INNER JOIN ingredients i ON ri.ingredient_id=i.id INNER JOIN units u ON ri.unit_id=u.id WHERE ri.recipe_id=?");
$stmt->bind_param("i", $id);
$html = "";
if ($result->num_rows > 0) {
  $html .= "<div class='container-lg'><table class='table table-bordered rounded-3'>";
  $html .= "<tr><th scope='col'>Ret</th><th scope='col'>Kort beskrivelse</th><th scope='col'>Fremgangsmåde</th><th scope='col'>Ingredienser</th></tr>";
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $html .= "<tr><td>".$row["name"]."</td><td>".$row["description"]."</td><td>".$row["course_of_action"]."</td><td>";
    
    $id = $row["id"];
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows > 0) {
      while($r = $res->fetch_assoc()) {
        $html .= "<span class='d-block' style='white-space: nowrap;'>".$r["amount"].$r["uname"]." ".$r["iname"]."</span>";
      }
    }
    $html .= "</td></tr>";
  }
  $html .= "</table></div>";
} else {
  $html = "0 results";
}
$conn->close();
?>