<?php include 'db.php' ; session_start(); if (!isset($_SESSION['room_id'])) { header("Location: index.php"); exit(); }
    $roomId=$_SESSION['room_id']; $roomId=intval($roomId); // Ensure the room ID is an integer
    $sql="SELECT file_name, file_path, uploaded_at FROM files WHERE room_id = $roomId" ; $result=$conn->query($sql);
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

            table,
            th,
            td {
                border: 1px solid white;
            }

            th,
            td {
                padding: 15px;
                text-align: left;
            }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="px-6 py-12 bg-[#1D274B] text-white">
        <div class="flex justify-between mb-6">
            <h1 class="text-3xl font-semibold">File Dashboard</h1>
            <a href="upload_file.html"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload
                File</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Uploaded At</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($stmt->fetch()) {
                    echo "<tr>
                        <td>$fileName</td>
                        <td>$uploadedAt</td>
                        <td><a href='$filePath' download>Download</a></td>
                      </tr>";
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
    </body>

    </html>