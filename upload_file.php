<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    $roomCode = $_POST['room_code'];
    $ownerToken = $_POST['owner_token'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileDestination = '/uploads/' . $fileName;
    $uploadDir = 'uploads/';

    $stmt = $conn->prepare("SELECT id FROM rooms WHERE room_code = ? AND owner_token = ?");
    $stmt->bind_param("ss", $roomCode, $ownerToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (!mkdir($uploadDir, 0755, true)) {
            die("Failed to create directory '$uploadDir'");
        } else {
            echo "Upload directory created successfully.";
        }
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file: " . $_FILES['file']['error'];
            }
        } else {
            echo "Error uploading file: " . $_FILES['file']['error'];
        }

        $room = $result->fetch_assoc();
        $roomId = $room['id'];

        $stmt = $conn->prepare("INSERT INTO files (room_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $roomId, $fileName, $fileDestination);
        $result = $stmt->execute();

        if ($result)
            echo "<a href='dashboard.php'>Dashboard</a>";
        } else {
            echo "Error adding file to database.";
        }
    } else {
        echo "Invalid room code or owner token.";
    }

    $stmt->close();
?>