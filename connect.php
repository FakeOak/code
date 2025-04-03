<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "phpmyadmin"; // แก้ให้เป็นฐานข้อมูลจริง

// เชื่อมต่อฐานข้อมูล
global $conn;
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die(json_encode(["message" => "Database connection failed: " . mysqli_connect_error()]));
}
?>
