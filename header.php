<?php $Time = date("H:i"); ?>

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {font: 14px sans-serif; text-align: center; background: grey;}
        h2 {padding-top: 0px; font-size: 40px; font-family: Monospace; font-weight: lighter;}
        .box {width: 500px; border: 15px solid #A9A9A9; padding: 50px; margin: auto; margin-top: 150px; clear: both; border-radius: 50px;}
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
<body>
</body>
