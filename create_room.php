<?php
include 'db.php';

function generateRoomCode($length = 2)
{
    return bin2hex(random_bytes($length));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomCode = generateRoomCode();
    $ownerToken = generateRoomCode();

    $sql = "INSERT INTO rooms (room_code, owner_token) VALUES ('$roomCode', '$ownerToken')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script>
</head>

<body class="bg-[#1D274B] text-white">
    <form class="mt-20 flex items-center justify-center w-full h-full" action="" method="POST">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create
            Room</button>
    </form>
    <div class="flex flex-col items-center justify-center mt-12 space-y-8">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ?>
            <!-- Room Code -->
            <div class="w-full max-w-sm">
                <div class="mb-2 flex justify-between items-center">
                    <label for="room-code" class="text-sm font-medium text-gray-900 dark:text-white">Room Code:</label>
                </div>
                <div class="flex items-center">
                    <span
                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-600 dark:text-white dark:border-gray-600">COPY</span>
                    <div class="relative w-full">
                        <input id="room-code" type="text" value="<?php echo $roomCode ?>" readonly
                            class="bg-gray-50 border border-e-0 border-gray-300 text-gray-900 text-sm rounded-none rounded-end-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <button id="copy-room-btn"
                        class="flex-shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-e-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 border border-blue-700 dark:border-blue-600"
                        type="button" onclick="copyToClipboard('room-code', 'copy-room-btn')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Owner Token -->
            <div class="w-full max-w-sm">
                <div class="mb-2 flex justify-between items-center">
                    <label for="owner-token" class="text-sm font-medium text-gray-900 dark:text-white">Owner Token:</label>
                </div>
                <div class="flex items-center">
                    <span
                        class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-600 dark:text-white dark:border-gray-600">COPY</span>
                    <div class="relative w-full">
                        <input id="owner-token" type="text" value="<?php echo $ownerToken ?>" readonly
                            class="bg-gray-50 border border-e-0 border-gray-300 text-gray-900 text-sm rounded-none rounded-end-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                    </div>
                    <button id="copy-owner-btn"
                        class="flex-shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-blue-700 rounded-e-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 border border-blue-700 dark:border-blue-600"
                        type="button" onclick="copyToClipboard('owner-token', 'copy-owner-btn')">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- QR Code Display -->
            <div class="flex items-center justify-center mt-8">
                <div>
                    <div class="flex items-center justify-center">
                        <canvas id="qrcode"></canvas>
                    </div>
                    <p class="mt-8">(Scan the QR Code to directly get acess to room)</p>
                </div>
            </div>

            <!-- Download QR Code -->
            <div class="flex items-center justify-center">
                <button id="download-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    onclick="downloadQRCode()">Download QR Code</button>
            </div>

            <a href="index.html">Log in?</a>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const roomCode = "<?php echo $roomCode ?>";
                    console.log(roomCode);
                    const qrCodeContainer = document.getElementById("qrcode");
                    QRCode.toCanvas(qrCodeContainer, roomCode, function (error) {
                        if (error) console.error(error);
                        console.log('QR code generated!');
                    });
                });
            </script>
            <?php
        }
        ?>
    </div>

    <script>
        function copyToClipboard(inputId, buttonId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(input.value);

            const copyBtn = document.getElementById(buttonId);
            copyBtn.innerHTML = '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>';
            setTimeout(() => {
                copyBtn.innerHTML = '<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/></svg>';
            }, 2000);
        }

        function downloadQRCode() {
            const canvas = document.getElementById('qrcode');
            const url = canvas.toDataURL(); // Convert canvas to data URL
            const a = document.createElement('a');
            a.href = url;
            a.download = 'qrcode.png'; // Set file name
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    </script>
</body>

</html>