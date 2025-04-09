<?php
session_start();
include 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ticket_id'])) {
    $ticketId = htmlspecialchars($_POST['ticket_id']);

    // Connect to SQLite database
    $db = new SQLite3(__DIR__ . '/db/event_nexus.db');

    // Check if the ticket exists
    $stmt = $db->prepare("SELECT * FROM tickets WHERE ticket_id = :ticket_id");
    $stmt->bindValue(':ticket_id', $ticketId, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($ticket = $result->fetchArray(SQLITE3_ASSOC)) {
        echo json_encode(['status' => 'success', 'message' => 'Ticket is valid!', 'attendee' => $ticket['attendee_name']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Ticket!']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code - Event Nexus</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
</head>
<body>
    <h2>Scan QR Code</h2>
    <div id="reader"></div>
    <p id="result"></p>

    <script>
        function onScanSuccess(decodedText) {
            fetch('scan_qr.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ticket_id=' + encodeURIComponent(decodedText)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('result').innerText = data.message;
            })
            .catch(error => console.error('Error:', error));
        }

        let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
