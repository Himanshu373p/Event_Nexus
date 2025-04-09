<?php
require 'vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (!isset($_GET['ticket_id'])) {
    die("Ticket ID is missing.");
}

$ticket_id = htmlspecialchars($_GET['ticket_id']);

// Generate QR Code
$qrCode = QrCode::create($ticket_id)
    ->setSize(300)
    ->setMargin(10);
$writer = new PngWriter();
$result = $writer->write($qrCode);

// Output QR Code Image
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
?>
