<?php
session_start();
include 'db/config.php';

// Check if the user is an admin
if (!isset($_SESSION['admin'])) {
    header("Location: pages/login.php");
    exit();
}

// Fetch all events
$result = $db->query("SELECT * FROM events ORDER BY event_date ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Admin</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Manage Events</h1>
        <nav>
            <a href="admin_panel.php">Dashboard</a>
            <a href="admin_tickets.php">View Tickets</a>
            <a href="scan_qr.php">QR Scanner</a>
            <a href="pages/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Event List</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                    <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                    <td>
                        <a href="edit_event.php?id=<?php echo $row['id']; ?>">Edit</a> |
                        <a href="delete_event.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>
</html>
