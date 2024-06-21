<?php
$host = "localhost";
$db = "FileTransfer";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("error while connecting to database, error: " . $conn->connect_error);
}

// $sql = "CREATE TABLE rooms (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     room_code VARCHAR(255) UNIQUE NOT NULL,
//     owner_token VARCHAR(255) NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )";

// $conn->query($sql);

// $sql = "CREATE TABLE files (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     room_id INT NOT NULL,
//     file_name VARCHAR(255) NOT NULL,
//     file_path VARCHAR(255) NOT NULL,
//     uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (room_id) REFERENCES rooms(id)
// )";

// $conn->query($sql);
?>