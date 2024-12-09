<?php
include 'connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM items WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // File upload
    $filePath = $item['file_path'];
    if (!empty($_FILES['file']['name'])) {
        $fileName = basename($_FILES['file']['name']);
        $targetDir = "uploads/";
        $filePath = $targetDir . $fileName;

        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }

    $query = "UPDATE items SET name = '$name', description = '$description', file_path = '$filePath' WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/update.css">
    <title>Document</title>
</head>

<body>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= $item['name'] ?>" required>
        <textarea name="description" required><?= $item['description'] ?></textarea>
        <input type="file" name="file">
        <button type="submit">Update</button>
    </form>
</body>

</html>