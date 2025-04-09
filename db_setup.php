<?php
// Ensure the database directory exists
if (!is_dir(__DIR__ . '/db')) {
    mkdir(__DIR__ . '/db', 0777, true);
}

// Database file path
$dbPath = __DIR__ . '/db/event_nexus.db';

// Create SQLite database connection
$db = new SQLite3($dbPath);

// Create Events Table
$query = "CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT,
    date TEXT NOT NULL,
    location TEXT NOT NULL,
    price REAL NOT NULL
)";
$db->exec($query);

// Create Users Table
$query = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT CHECK(role IN ('admin', 'user')) NOT NULL DEFAULT 'user'
)";
$db->exec($query);

// Create Tickets Table
$query = "CREATE TABLE IF NOT EXISTS tickets (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    event_id INTEGER NOT NULL,
    attendee_name TEXT NOT NULL,
    attendee_email TEXT NOT NULL,
    qr_code TEXT NOT NULL,
    payment_status TEXT CHECK(payment_status IN ('pending', 'paid')) NOT NULL DEFAULT 'pending',
    FOREIGN KEY (event_id) REFERENCES events(id)
)";
$db->exec($query);

echo "✅ Database and tables have been set up successfully.";
?>
