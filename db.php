<?php
$host = "localhost";
$db = "FileTransfer";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("error while connecting to database, error: " . $conn->connect_error);
}


?>