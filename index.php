<?php
// event_nexus/index.php
session_start();
include 'db/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Nexus</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Event Nexus</h1>
        <nav>
        <a href="index.php">Home</a>
    <a href="events.php">Events</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="user_panel.php">Dashboard</a>
        <a href="pages/logout.php">Logout</a>
    <?php else: ?>
        <a href="pages/login.php">Login</a>
        <a href="pages/register.php">Register</a>
    <?php endif; ?>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h2>Discover & Book Amazing Events</h2>
            <p>Join the best events near you with seamless ticket booking.</p>
        </section>
        <section class="events">
            <h3>Upcoming Events</h3>
            <div class="event-list">
                <?php
                $db = new SQLite3(__DIR__ . '/db/event_nexus.db');
                $result = $db->query("SELECT * FROM events ORDER BY event_date ASC LIMIT 5");
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    echo "<div class='event-card'>";
                    echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><strong>Date:</strong> " . $row['event_date'] . "</p>";
                    echo "<p><strong>Price:</strong> $" . $row['price'] . "</p>";
                    echo "<a href='event.php?id=" . $row['id'] . "' class='btn'>View Event</a>";
                    echo "</div>";
                }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Event Nexus. All Rights Reserved.</p>
    </footer>
</body>
</html>