<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow requests from any origin
header('Access-Control-Allow-Methods: POST, OPTIONS'); // Allow POST and OPTIONS methods
header('Access-Control-Allow-Headers: Content-Type'); // Allow specific headers

require_once 'connect.php'; // ใช้ไฟล์ connect.php

try {
    // Handle preflight OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    // Check if the request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
        exit;
    }

    // Handle JSON or form data
    if (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
        $data = json_decode(file_get_contents("php://input"), true);
    } else {
        $data = $_POST;
    }

    // Validate input
    if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
        echo json_encode(["success" => false, "message" => "กรุณากรอกข้อมูลให้ครบถ้วน"]);
        exit;
    }

    $name = $conn->real_escape_string($data['name']);
    $email = $conn->real_escape_string($data['email']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash the password

    // Insert user into the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "ลงทะเบียนสำเร็จ!"]);
    } else {
        echo json_encode(["success" => false, "message" => "เกิดข้อผิดพลาด: " . $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Unexpected error: " . $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>