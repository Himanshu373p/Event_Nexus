<?php
session_start();
include 'db/config.php';

// Check if admin
if (!isset($_SESSION['admin'])) {
    header("Location: pages/login.php");
    exit();
}

// Get QR code from URL
if (!isset($_GET['code'])) {
    echo "Invalid QR Code!";
    exit();
}

$qr_code = $_GET['code'];

// Check if QR code exists in the database
$stmt = $db->prepare("SELECT tickets.id, users.username, events.title FROM tickets 
                      JOIN users ON tickets.user_id = users.id 
                      JOIN events ON tickets.event_id = events.id 
                      WHERE tickets.qr_code = ?");
$stmt->bindValue(1, $qr_code, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

if ($row) {
    echo "<h2>Check-In Successful!</h2>";
    echo "<p>Attendee: " . htmlspecialchars($row['username']) . "</p>";
    echo "<p>Event: " . htmlspecialchars($row['title']) . "</p>";
} else {
    echo "<h2>Invalid Ticket!</h2>";
}
?>
