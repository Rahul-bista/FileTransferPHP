<?php
include 'db.php';

// Ensure the uploads directory exists
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    if (!mkdir($targetDir, 0777, true)) {
        die("Failed to create upload directory.");
    }
}

$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check for errors
if ($_FILES["file"]["error"] > 0) {
    die("Error: " . $_FILES["file"]["error"]);
}

// Allowed file formats
$allowedFormats = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
if (!in_array($fileType, $allowedFormats)) {
    die("Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed.");
}

// Try to upload file
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    // Insert file details into database (assuming $conn is your database connection)
    session_start();
    $roomId = $_SESSION['room_id'];
    $fileName = basename($_FILES["file"]["name"]);
    $filePath = $targetFile;

    $stmt = $conn->prepare("INSERT INTO files (room_id, file_name, file_path, uploaded_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $roomId, $fileName, $filePath);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        die("Error inserting file into database: " . $stmt->error);
    }
} else {
    die("Sorry, there was an error uploading your file.");
}
?>
