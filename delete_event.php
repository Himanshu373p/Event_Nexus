<?php
session_start();
include 'db/config.php';

// Check if the user is an admin
if (!isset($_SESSION['admin'])) {
    header("Location: pages/login.php");
    exit();
}

// Check if event ID is provided
if (!isset($_GET['id'])) {
    header("Location: manage_events.php");
    exit();
}

$event_id = $_GET['id'];

// Delete event from database
$stmt = $db->prepare("DELETE FROM events WHERE id = ?");
$stmt->bindValue(1, $event_id, SQLITE3_INTEGER);

if ($stmt->execute()) {
    header("Location: manage_events.php");
    exit();
} else {
    echo "Failed to delete event!";
}
?>
