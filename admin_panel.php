<?php
session_start();
include 'db/config.php';

// Check if the user is an admin
if (!isset($_SESSION['admin'])) {
    header("Location: pages/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Event Nexus</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="admin_panel.php">Dashboard</a>
            <a href="admin_tickets.php">View Tickets</a>
            <a href="scan_qr.php">QR Scanner</a>
            <a href="pages/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Welcome, Admin</h2>
        <section>
            <h3>Quick Actions</h3>
            <ul>
                <li><a href="admin_tickets.php">View All Tickets</a></li>
                <li><a href="scan_qr.php">Scan QR Code for Check-in</a></li>
                <li><a href="manage_events.php">Manage Events</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Event Nexus. All Rights Reserved.</p>
    </footer>
</body>
</html>
