<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "DELETE FROM items WHERE user_id = $user_id";
mysqli_query($conn, $query);

header("Location: index.php");
?>
