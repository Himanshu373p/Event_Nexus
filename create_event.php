<?php
session_start();
include 'db/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];

    $db->exec("INSERT INTO events (title, description, event_date, price, user_id) 
               VALUES ('$title', '$description', '$event_date', '$price', '$user_id')");

    $message = "Event created successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Create New Event</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="user_panel.php">Dashboard</a>
            <a href="pages/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h2>Enter Event Details</h2>
        <?php if ($message) echo "<p class='success'>$message</p>"; ?>
        <form action="" method="POST">
            <label>Event Title:</label>
            <input type="text" name="title" required>
            
            <label>Description:</label>
            <textarea name="description" required></textarea>
            
            <label>Date:</label>
            <input type="date" name="event_date" required>
            
            <label>Ticket Price ($):</label>
            <input type="number" name="price" step="0.01" required>
            
            <button type="submit">Create Event</button>
        </form>
    </main>
</body>
</html>
