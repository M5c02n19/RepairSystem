<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'responsible') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['photo'])) {
    $request_id = $_POST['request_id'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO repair_photos (request_id, photo_path) VALUES ('$request_id', '$target_file')";
        $conn->query($query);
        echo "Photo uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}

$request_id = $_GET['request_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo</title>
</head>
<body>
    <h1>Upload Photo for Request ID: <?= $request_id ?></h1>
    <form action="upload_photo.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="request_id" value="<?= $request_id ?>">
        <input type="file" name="photo" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
