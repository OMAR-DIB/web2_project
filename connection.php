<?php
// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "web2";
$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>