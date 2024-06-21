<?php
include 'db.php';
session_start();

if (!isset($_SESSION['room_id'])) {
    header("Location: index.php");
    exit();
}

$roomId = intval($_SESSION['room_id']); // Ensure the room ID is an integer
$sql = "SELECT file_name, file_path, uploaded_at FROM files WHERE room_id = $roomId";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        .preview {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin-bottom: 5px;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="px-6 py-12 bg-[#1D274B] text-white">
    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-semibold">File Dashboard</h1>
        <div>
            <a href="upload_file.html" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload File</a>
            <a href="logout.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">Logout</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>File</th>
                <th>Uploaded At</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                $fileName = htmlspecialchars($row['file_name']);
                $uploadedAt = htmlspecialchars($row['uploaded_at']);
                $filePath = htmlspecialchars($row['file_path']);
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

                echo "<tr>
                        <td>";

                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<img src='uploads/$fileName' alt='$fileName' class='preview'><br>";
                } elseif (in_array($fileExtension, ['pdf'])) {
                    echo "<embed src='uploads/$fileName' type='application/pdf' class='preview'><br>";
                } else {
                    echo "<span>No preview available</span><br>";
                }

                echo "$fileName</td>
                        <td>$uploadedAt</td>
                        <td><a href='uploads/$fileName' download>Download</a></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
