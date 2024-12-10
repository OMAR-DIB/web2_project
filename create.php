<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id'];

    $filePath = null;
    if (!empty($_FILES['file']['name'])) {
        $fileName = time() . "_" . basename($_FILES['file']['name']); // Add timestamp for unique file names
        $targetDir = "uploads/";
        $filePath = $targetDir . $fileName;

        // Move file and check for success
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            echo "Error uploading file.";
            exit();
        }
    }

    $query = "INSERT INTO items (name, description, file_path, user_id) 
              VALUES ('$name', '$description', '$filePath', $user_id)";
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
    <link rel="stylesheet" href="./style/createe.css">
    <title>Create Item</title>
</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Item Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="file">
        <button type="submit">Create</button>
    </form>
</body>

</html>
