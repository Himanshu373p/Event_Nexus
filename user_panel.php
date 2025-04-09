<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Event Nexus</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>User Dashboard</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="pages/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Welcome, User!</h2>

        <?php if ($role === 'user'): ?>
            <h3>Your Created Events</h3>
            <a href="create_event.php" class="btn">Create New Event</a>
            <div class="event-list">
                <?php
                $result = $db->query("SELECT * FROM events WHERE user_id = $user_id");
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    echo "<div class='event-card'>";
                    echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Date:</strong> " . $row['event_date'] . "</p>";
                    echo "<p><strong>Price:</strong> $" . $row['price'] . "</p>";
                    echo "<a href='event.php?id=" . $row['id'] . "' class='btn'>View</a>";
                    echo "</div>";
                }
                ?>
            </div>
        <?php endif; ?>

        <h3>Your Tickets</h3>
        <div class="ticket-list">
            <?php
            $result = $db->query("SELECT events.title, tickets.qr_code FROM tickets JOIN events ON tickets.event_id = events.id WHERE tickets.user_id = $user_id");
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                echo "<div class='ticket-card'>";
                echo "<h4>Event: " . htmlspecialchars($row['title']) . "</h4>";
                echo "<img src='generate_qr.php?code=" . urlencode($row['qr_code']) . "' alt='QR Code'>";
                echo "</div>";
            }
            ?>
        </div>
    </main>
</body>
</html>
