<?php

$db_servername = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "myDB";
$error = null;

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
$successful = false;

// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>
