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
$event = $db->querySingle("SELECT * FROM events WHERE id = $event_id", true);

if (!$event) {
    echo "Event not found!";
    exit();
}

// Update event details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['event_date'];
    $price = $_POST['price'];

    $stmt = $db->prepare("UPDATE events SET title = ?, description = ?, event_date = ?, price = ? WHERE id = ?");
    $stmt->bindValue(1, $title, SQLITE3_TEXT);
    $stmt->bindValue(2, $description, SQLITE3_TEXT);
    $stmt->bindValue(3, $date, SQLITE3_TEXT);
    $stmt->bindValue(4, $price, SQLITE3_FLOAT);
    $stmt->bindValue(5, $event_id, SQLITE3_INTEGER);
    
    if ($stmt->execute()) {
        header("Location: manage_events.php");
        exit();
    } else {
        echo "Failed to update event!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Edit Event</h1>
        <nav>
            <a href="admin_panel.php">Dashboard</a>
            <a href="manage_events.php">Back to Events</a>
            <a href="pages/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <form method="POST">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>

            <label>Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea>

            <label>Date:</label>
            <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" required>

            <label>Price ($):</label>
            <input type="number" name="price" value="<?php echo $event['price']; ?>" step="0.01" required>

            <button type="submit">Update Event</button>
        </form>
    </main>
</body>
</html>
