<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $building_name = $_POST['building_name'];
    $defect_details = $_POST['defect_details'];
    $assigned_user_id = $_POST['assigned_user_id'];
    $start_date = $_POST['start_date'];
    $sla_due_date = $_POST['sla_due_date'];

    $query = "INSERT INTO repair_requests (building_name, defect_details, assigned_user_id, start_date, sla_due_date) 
              VALUES ('$building_name', '$defect_details', '$assigned_user_id', '$start_date', '$sla_due_date')";
    $conn->query($query);

    header("Location: admin_dashboard.php");
}

$users_query = "SELECT * FROM users WHERE role='responsible'";
$users_result = $conn->query($users_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h2>Create Repair Request</h2>
    <form action="" method="POST">
        <label for="building_name">Building Name</label>
        <input type="text" name="building_name" required>
        
        <label for="defect_details">Defect Details</label>
        <textarea name="defect_details" required></textarea>

        <label for="assigned_user_id">Assign to</label>
        <select name="assigned_user_id" required>
            <?php while($row = $users_result->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['username'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" required>

        <label for="sla_due_date">SLA Due Date</label>
        <input type="date" name="sla_due_date" required>

        <button type="submit">Create Request</button>
    </form>
    <h2>Monitor Repair Requests</h2>
<table border="1">
    <tr>
        <th>Building Name</th>
        <th>Defect Details</th>
        <th>Assigned User</th>
        <th>Start Date</th>
        <th>SLA Due Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php
    $query = "SELECT rr.*, u.username, rs.status 
              FROM repair_requests rr
              JOIN users u ON rr.assigned_user_id = u.id
              JOIN repair_status rs ON rr.id = rs.request_id";
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= $row['building_name'] ?></td>
        <td><?= $row['defect_details'] ?></td>
        <td><?= $row['username'] ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['sla_due_date'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><a href="feedback.php?request_id=<?= $row['id'] ?>">Submit Feedback</a></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
