<?php
session_start();
if (!isset($_SESSION['razorpay_order_id'])) {
    die("Invalid access.");
}

// Razorpay API credentials
$razorpayKey = "your_razorpay_key"; 
$amount = $_SESSION['amount']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h2>Processing Payment...</h2>
    <script>
        var options = {
            "key": "<?php echo $razorpayKey; ?>",
            "amount": "<?php echo $amount; ?>",
            "currency": "INR",
            "name": "Event Nexus",
            "description": "Event Ticket Purchase",
            "order_id": "<?php echo $_SESSION['razorpay_order_id']; ?>",
            "handler": function (response){
                window.location.href = "success.php?payment_id=" + response.razorpay_payment_id;
            },
            "theme": {
                "color": "#528FF0"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();
    </script>
</body>
</html>
