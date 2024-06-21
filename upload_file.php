<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Display file information for debugging
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    
    $roomCode = $_POST['room_code'];
    $ownerToken = $_POST['owner_token'];
    $fileName = basename($_FILES['file']['name']);
    $fileTmpName = $_FILES['file']['tmp_name'];
    $uploadDir = __DIR__ . '/uploads';
    $fileDestination = $uploadDir . '/' . $fileName;

    // Check if the room code and owner token are valid
    $stmt = $conn->prepare("SELECT id FROM rooms WHERE room_code = ? AND owner_token = ?");
    $stmt->bind_param("ss", $roomCode, $ownerToken);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        // Ensure the upload directory exists
        if (!file_exists($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            die("Failed to create upload directory.");
        }

        // Handle file upload errors
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            switch ($_FILES['file']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "File size exceeds the allowed limit.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "File was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "No file was uploaded.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Missing a temporary folder.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Failed to write file to disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "File upload stopped by extension.";
                    break;
                default:
                    echo "Unknown upload error.";
                    break;
            }
            exit;
        }

        // Handle file name conflicts by renaming the file if it already exists
        $fileCount = 1;
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);

        while (file_exists($fileDestination)) {
            $fileName = $fileBaseName . '_' . $fileCount . '.' . $fileExtension;
            $fileDestination = $uploadDir . '/' . $fileName;
            $fileCount++;
        }

        // Move the uploaded file
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error moving uploaded file.";
            exit;
        }

        // Insert file information into the database
        $room = $result->fetch_assoc();
        $roomId = $room['id'];

        $stmt = $conn->prepare("INSERT INTO files (room_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $roomId, $fileName, $fileDestination);

        if ($stmt->execute()) {
            echo "<a href='dashboard.php'>Dashboard</a>";
        } else {
            echo "Error adding file to database.";
        }
    } else {
        echo "Invalid room code or owner token.";
    }

    // Close the statement
    $stmt->close();
}
?>
