<?php
session_start();
include 'db/config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$event_id = $_GET['id'];
$result = $db->query("SELECT * FROM events WHERE id = $event_id");
$event = $result->fetchArray(SQLITE3_ASSOC);

if (!$event) {
    echo "Event not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($event['title']); ?></h1>
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
        <p><?php echo htmlspecialchars($event['description']); ?></p>
        <p><strong>Date:</strong> <?php echo $event['event_date']; ?></p>
        <p><strong>Price:</strong> $<?php echo $event['price']; ?></p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="checkout.php?event_id=<?php echo $event['id']; ?>" class="btn">Buy Ticket</a>
        <?php else: ?>
            <p><a href="pages/login.php">Login</a> to purchase a ticket.</p>
        <?php endif; ?>
    </main>
</body>
</html>
