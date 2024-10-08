<?php
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบผู้ใช้งาน
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // แยกการเข้าสู่ระบบของแต่ละ role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: responsible_dashboard.php");
            }
        } else {
            echo "Password incorrect.";
        }
    } else {
        echo "User not found.";
    }
}
?>
