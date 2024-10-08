CREATE DATABASE repair_system;
USE repair_system;

-- ตารางผู้ใช้งาน (Admin, ผู้รับผิดชอบงาน)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'responsible') NOT NULL
);

-- ตารางใบแจ้งซ่อม
CREATE TABLE repair_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    building_name VARCHAR(255),
    defect_details TEXT,
    assigned_user_id INT,
    start_date DATE,
    sla_due_date DATE,
    FOREIGN KEY (assigned_user_id) REFERENCES users(id)
);

-- ตารางภาพถ่ายการซ่อม
CREATE TABLE repair_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT,
    photo_path VARCHAR(255),
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES repair_requests(id)
);

-- ตารางสถานะงานซ่อม
CREATE TABLE repair_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT,
    status ENUM('pending', 'approved', 'in_progress', 'completed') DEFAULT 'pending',
    FOREIGN KEY (request_id) REFERENCES repair_requests(id)
);

-- ตารางการประเมินความพอใจ
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT,
    satisfaction_level INT, -- คะแนน 1-5
    feedback_text TEXT,
    FOREIGN KEY (request_id) REFERENCES repair_requests(id)
);
