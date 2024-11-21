<?php
// add_to_cart.php

// Start the session
session_start();

// Include your database connection file
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Validate product_id and quantity inputs
$product_id = isset($_POST['product_id']) && is_numeric($_POST['product_id']) ? $_POST['product_id'] : null;
$quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0 ? $_POST['quantity'] : 1;

if (!$product_id) {
    header("Location: shop.html?status=error&message=" . urlencode("Invalid product ID."));
    exit();
}

// Check if the item is already in the cart
$query = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    header("Location: shop.html?status=error&message=" . urlencode("Database error."));
    exit();
}

$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if product is already in the cart
    $query = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $quantity, $user_id, $product_id);
} else {
    // Insert new record if product is not in the cart
    $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $user_id, $product_id, $quantity);
}

// Execute query and handle errors
if ($stmt->execute()) {
    // Redirect to the shop page with a success message
    header("Location: shop.html?status=success&message=" . urlencode("Item added to cart"));
} else {
    // Redirect with an error message
    header("Location: shop.html?status=error&message=" . urlencode("Failed to add item to cart"));
}

// Close statement and connection
$stmt->close();
$conn->close();
exit;
?>