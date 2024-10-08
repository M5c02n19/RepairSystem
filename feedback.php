<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $satisfaction_level = $_POST['satisfaction_level'];
    $feedback_text = $_POST['feedback_text'];

    $query = "INSERT INTO feedback (request_id, satisfaction_level, feedback_text) 
              VALUES ('$request_id', '$satisfaction_level', '$feedback_text')";
    $conn->query($query);
    echo "Feedback submitted.";
}

$request_id = $_GET['request_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
</head>
<body>
    <h1>Submit Feedback for Request ID: <?= $request_id ?></h1>
    <form action="feedback.php" method="POST">
        <input type="hidden" name="request_id" value="<?= $request_id ?>">
        <label for="satisfaction_level">Satisfaction Level (1-5)</label>
        <input type="number" name="satisfaction_level" min="1" max="5" required>
        <br>
        <label for="feedback_text">Feedback</label>
        <textarea name="feedback_text" required></textarea>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
