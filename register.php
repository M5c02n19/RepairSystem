<?php
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // รับรหัสผ่านยืนยัน
    $role = $_POST['role'];

    // ตรวจสอบว่าชื่อผู้ใช้มีอยู่แล้วหรือไม่
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        // ตรวจสอบว่ารหัสผ่านและรหัสผ่านยืนยันตรงกัน
        if ($password === $confirm_password) {
            // แฮชรหัสผ่าน
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // เพิ่มผู้ใช้ใหม่
            $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
            if ($conn->query($insert_query) === TRUE) {
                echo "Registration successful!";
                header("Location: login.html"); // ส่งกลับไปยังหน้า Login
                exit;
            } else {
                echo "Error: " . $insert_query . "<br>" . $conn->error;
            }
        } else {
            echo "Passwords do not match."; // แจ้งเตือนเมื่อรหัสผ่านไม่ตรงกัน
        }
    }
}
?>
