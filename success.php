<?php
session_start();
require 'db/config.php';
require 'vendor/autoload.php';

use Razorpay\Api\Api;

// Razorpay API Credentials
$apiKey = "your_razorpay_key"; 
$apiSecret = "your_razorpay_secret";

$api = new Api($apiKey, $apiSecret);

if (!isset($_GET['payment_id'])) {
    die("Invalid payment request.");
}

$paymentId = $_GET['payment_id'];
$orderId = $_SESSION['razorpay_order_id'];

try {
    $payment = $api->payment->fetch($paymentId);

    if ($payment->status === "captured") {
        $stmt = $conn->prepare("INSERT INTO transactions (event_id, attendee_name, attendee_email, payment_id, amount, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $_SESSION['event_id'], $_SESSION['attendee_name'], $_SESSION['attendee_email'], $paymentId, $payment->amount, $payment->status);
        $stmt->execute();

        echo "<h2>Payment Successful!</h2>";
    } else {
        echo "<h2>Payment Failed!</h2>";
    }
} catch (Exception $e) {
    echo "Payment verification failed: " . $e->getMessage();
}
?>
