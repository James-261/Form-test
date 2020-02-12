<?php
// Include config file
require_once "config.php";


$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $username_err = "Username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "reload page";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords do not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "reload page";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html>
<head>
   <title>Register</title>
</head>
<body>
   <div class="wrapper">
       <h2>Register</h2>
       <p>Create account</p>
       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
               <label>Username</label>
               <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
               <span class="help-block"><?php echo $username_err; ?></span>
           </div>
           <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
               <label>Password</label>
               <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
               <span class="help-block"><?php echo $password_err; ?></span>
           </div>
           <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
               <label>Confirm Password</label>
               <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
               <span class="help-block"><?php echo $confirm_password_err; ?></span>
           </div>
           <div class="form-group">
               <input type="submit" class="btn btn-primary" value="Submit">
               <input type="reset" class="btn btn-default" value="Reset">
           </div>
           <p><a href="login.php">Login here</a>.</p>
       </form>
   </div>
</body>
</html>
