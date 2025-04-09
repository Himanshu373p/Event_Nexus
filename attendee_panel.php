<?php
session_start();
include 'db/config.php';

// Connect to SQLite database
$db = new SQLite3(__DIR__ . '/db/event_nexus.db');

// Fetch available events
$eventsQuery = $db->query("SELECT * FROM events");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendee Panel - Event Nexus</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>🎟️ Attendee Panel - Event Nexus</h2>

    <h3>Available Events</h3>
    <table border="1">
        <tr>
            <th>Event Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Location</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php while ($event = $eventsQuery->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($event['name']) ?></td>
                <td><?= htmlspecialchars($event['description']) ?></td>
                <td><?= htmlspecialchars($event['date']) ?></td>
                <td><?= htmlspecialchars($event['location']) ?></td>
                <td>₹<?= htmlspecialchars($event['price']) ?></td>
                <td>
                    <form action="process_payment.php" method="POST">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        <input type="text" name="attendee_name" placeholder="Your Name" required>
                        <input type="email" name="attendee_email" placeholder="Your Email" required>
                        <button type="submit">Buy Ticket</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Check Your Ticket</h3>
    <form action="view_ticket.php" method="POST">
        <input type="email" name="attendee_email" placeholder="Enter your email" required>
        <button type="submit">Check Ticket</button>
    </form>
</body>
</html>
