<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// เชื่อมต่อฐานข้อมูล (เปลี่ยนค่าตามเซิร์ฟเวอร์ของคุณ)
$servername = "localhost";
$username = "root"; // เปลี่ยนตามฐานข้อมูลของคุณ
$password = ""; // เปลี่ยนตามฐานข้อมูลของคุณ
$dbname = "phpmyadmin"; // เปลี่ยนเป็นชื่อฐานข้อมูลของคุณ

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error]));
}

// รับค่าจากฟอร์ม
$user = isset($_POST['username']) ? trim($_POST['username']) : '';
$pass = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($user) || empty($pass)) {
    echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
    exit();
}

// เข้ารหัสรหัสผ่าน
$hashed_password = password_hash($pass, PASSWORD_BCRYPT);

// ตรวจสอบว่ามีผู้ใช้ซ้ำหรือไม่
$checkUser = $conn->prepare("SELECT id FROM users WHERE username = ?");
$checkUser->bind_param("s", $user);
$checkUser->execute();
$checkUser->store_result();

if ($checkUser->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "ชื่อผู้ใช้นี้มีอยู่แล้ว"]);
    exit();
}

// เพิ่มผู้ใช้ใหม่
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $user, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "ลงทะเบียนสำเร็จ!"]);
} else {
    echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด โปรดลองอีกครั้ง"]);
}

$stmt->close();
$conn->close();
?>
