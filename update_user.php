<?php
header('Content-Type: application/json');
require_once 'connect.php'; // ใช้ไฟล์ connect.php

// Get input data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id']) || !isset($data['name']) || !isset($data['email'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$id = $conn->real_escape_string($data['id']);
$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);

// Update user query
$sql = "UPDATE users SET name='$name', email='$email' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "User updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating user: " . $conn->error]);
}

$conn->close();
?>