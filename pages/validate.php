<?php
include_once('../conn.php');
// define variables and set to empty values
$username = $password = $repeatedPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $password = test_input($_POST["password"]);
  $repeatedPassword = test_input($_POST["repeatedPassword"]);
} 

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($password == $repeatedPassword && $password != "" && $username != "") {
    $sql = "SELECT username FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0 && strpos($result, $username)) {
        header("Location: ./login.php");
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("s", $username);
        $stmt->bind_param("s", $password);
        $stmt->execute();
    }
    header("Location: ./home.php");
} 

header("Location: ./login.php");

?>