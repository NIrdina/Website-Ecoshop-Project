<?php
// payment_receipt.php

// Simulate processing time and response
sleep(1);

// Create a response with transaction details
$transaction_id = rand(100000, 999999);
$transaction_date = date("Y-m-d");

$response = [
    "status" => "success",
    "transaction_id" => $transaction_id,
    "transaction_date" => $transaction_date,
    "message" => "Thank you for your purchase!"
];

// Send response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
