<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = $_GET['id']; // Get item ID from URL

// Fetch the specific item
$query = "SELECT * FROM items WHERE id = $item_id AND user_id = $user_id";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    echo "Item not found or unauthorized access.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $filePath = $item['file_path']; // Keep the old file path by default
    if (!empty($_FILES['file']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file']['name']);
        $targetDir = "uploads/";
        $filePath = $targetDir . $fileName;

        if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            echo "Error uploading file.";
            exit();
        }
    }

    // Update query
    $query = "UPDATE items SET name = '$name', description = '$description', file_path = '$filePath' 
              WHERE id = $item_id AND user_id = $user_id";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/update.css">
    <title>Update Item</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
        <textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea>
        <input type="file" name="file">
        <button type="submit">Update</button>
    </form>
</body>

</html>
