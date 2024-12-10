<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure the item ID is provided
if (isset($_GET['id'])) {
    $item_id = intval($_GET['id']); // Get the item ID from the URL
    $user_id = $_SESSION['user_id'];

    // Delete the specific item for the logged-in user
    $query = "DELETE FROM items WHERE id = $item_id AND user_id = $user_id";
    mysqli_query($conn, $query);
}

// Redirect back to the main page
header("Location: index.php");
exit();
?>
