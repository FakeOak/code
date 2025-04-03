<?php
header('Content-Type: application/json');
require_once 'connect.php'; // ใช้ไฟล์ connect.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'])) {
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit;
    }

    $id = intval($data['id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting user: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
