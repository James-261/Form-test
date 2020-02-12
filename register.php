<?php

//include config file
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  //check username
  if(empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username";
  } else {
    $sql_select = "SELECT id FROM users WHERE username = ?";
    if($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_username);
      $param_username = trim($_POST["username"]);
      if($stmt->execute()) {
        $stmt->store_result();
        if($stmt->num_rows == 1) {
          $username_err = "Username already taken";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
          echo "Reload page and try again";
      }
    }
    $stmt->close();
  }
  //check password
}






 ?>
