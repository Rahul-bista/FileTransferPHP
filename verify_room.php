<?php
include 'db.php';

$roomCode = $_POST['room_code'];
$roomCode = $conn->real_escape_string($roomCode);

$sql = "SELECT id FROM rooms WHERE room_code = '$roomCode'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    session_start();
    $row = $result->fetch_assoc();
    $_SESSION['room_id'] = $row['id'];
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid room code.";
}
?>
