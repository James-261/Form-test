<?php
//config file
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $pass_err = $confirm_password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    //Validation
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($conn, $sql)) {
          mysqli_stmt_bind_param($stmt, "s", $param_username);

          $param_username = trim($_POST["username"]);

          if(mysqli_stmt_execute($stmt)) {
              mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1) {
                $username_err = "This username is already taken";
            } else {
                $username = trim($_POST["username"]);
            }
          } else {
              echo "Reload page and try again";
          }
        }

        mysqli_stmt_close($stmt);
    }

    //validate password
    if(empty(trim($_POST["password"]))) {
        $pass_err = "Please enter a password";
    } elseif(strlen(trim($_POST["password"])) < 8) {
        $pass_err = "Password must be longer than 8 characters";
    } else {
        $password = trim($_POST["password"]);
    }

    //validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($pass_err) && ($password != $confirm_password)) {
          $confirm_password_err = "Passwords don't match";
        }
    }
}
























 ?>
