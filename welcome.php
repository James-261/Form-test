<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php $Time = date("H:i"); ?>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {font: 14px sans-serif; text-align: left; background: grey;}
        h2 {padding-top: 0px; font-size: 40px; font-family: Monospace; font-weight: lighter;}
        .box {width: auto; border: 15px solid #A9A9A9; padding: 20px; margin: 15px; clear: both; border-radius: 50px;}
        .grey {background-color: #DCDCDC;}
        .time {float: right; padding-top: 14px; font-size: 20px; padding-left: 1500px;}
    </style>
</head>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="">FormTest</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Form</a></li>
      <li><a href="register.php">Register</a></li>
      <li><a href="login.php">Login</a></li>
      <div class="time">
        <?= $Time ?>
      </div>
    </ul>
  </div>
</nav>
  <style>
  </style>
<body>
    <div class="box grey">
        <h1>Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="logout.php" class="btn btn-danger">Log Out</a>
    </div>
</body>
</html>
