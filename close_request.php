<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'responsible') {
    header("Location: login.php");
    exit;
}

$request_id = $_GET['request_id'];
$query = "UPDATE repair_status SET status='completed' WHERE request_id = $request_id";
$conn->query($query);

header("Location: responsible_dashboard.php");
