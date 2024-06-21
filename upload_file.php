<?php
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    if (!mkdir($targetDir, 0777, true)) {
        die("Failed to create upload directory.");
    }
}

$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

if ($_FILES["file"]["error"] > 0) {
    die("Error: " . $_FILES["file"]["error"]);
}

$allowedFormats = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];
if (!in_array($fileType, $allowedFormats)) {
    die("Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed.");
}

// Try to upload file
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
} else {
    die("Sorry, there was an error uploading your file.");
}
?>
