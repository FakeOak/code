<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'connect.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบตัวแปร $conn
if (!isset($conn) || !$conn) {
    echo json_encode(["message" => "Database connection failed!"]);
    exit;
}

try {
    $query = "SELECT 'Backend connected successfully!' AS message";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(["message" => $row['message']]);
    } else {
        echo json_encode(["message" => "Query failed: " . mysqli_error($conn)]);
    }
} catch (Exception $e) {
    echo json_encode(["message" => "Error: " . $e->getMessage()]);
}

mysqli_close($conn);
?>
