<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpmyadmin";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error]));
}

// รับข้อมูลจากฟอร์ม
$user = isset($_POST['username']) ? trim($_POST['username']) : '';
$pass = isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($user) || empty($pass)) {
    echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
    exit();
}

// ค้นหาผู้ใช้ในฐานข้อมูล
$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"]);
    exit();
}

$stmt->bind_result($id, $hashed_password);
$stmt->fetch();

// ตรวจสอบรหัสผ่าน
if (!password_verify($pass, $hashed_password)) {
    echo json_encode(["success" => false, "message" => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"]);
    exit();
}
$_SESSION['username'] = $user;
echo json_encode(["success" => true, "message" => "เข้าสู่ระบบสำเร็จ!"]);

$stmt->close();
$conn->close();
?>
