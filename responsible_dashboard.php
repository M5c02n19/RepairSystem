<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'responsible') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM repair_requests WHERE assigned_user_id = $user_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsible Dashboard</title>
</head>
<body>
    <h1>Responsible Dashboard</h1>
    <h2>Assigned Repair Requests</h2>
    <table border="1">
        <tr>
            <th>Building Name</th>
            <th>Defect Details</th>
            <th>Start Date</th>
            <th>SLA Due Date</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['building_name'] ?></td>
            <td><?= $row['defect_details'] ?></td>
            <td><?= $row['start_date'] ?></td>
            <td><?= $row['sla_due_date'] ?></td>
            <td>
                <a href="upload_photo.php?request_id=<?= $row['id'] ?>">Upload Photo</a> | 
                <a href="close_request.php?request_id=<?= $row['id'] ?>">Close Request</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
