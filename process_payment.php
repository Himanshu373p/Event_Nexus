<?php
session_start();
require 'db/config.php';
require 'vendor/autoload.php';

use Razorpay\Api\Api;

// Razorpay API Credentials (Replace with your actual keys)
$apiKey = "your_razorpay_key"; 
$apiSecret = "your_razorpay_secret";

$api = new Api($apiKey, $apiSecret);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
    $eventId = htmlspecialchars($_POST['event_id']);
    $attendeeName = htmlspecialchars($_POST['attendee_name']);
    $attendeeEmail = htmlspecialchars($_POST['attendee_email']);

    // Fetch event details from MySQL
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    if (!$event) {
        die(json_encode(['status' => 'error', 'message' => 'Event not found.']));
    }

    $amount = $event['price'] * 100; // Convert to paisa (for Razorpay)

    try {
        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        // Store order details in session
        $_SESSION['razorpay_order_id'] = $order['id'];
        $_SESSION['attendee_name'] = $attendeeName;
        $_SESSION['attendee_email'] = $attendeeEmail;
        $_SESSION['event_id'] = $eventId;

        echo json_encode(['status' => 'success', 'order_id' => $order['id'], 'amount' => $amount]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
