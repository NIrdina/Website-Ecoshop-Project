<?php
// Database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    // SQL Query to update product in database
    $query = "UPDATE products SET name='$product_name', description='$product_description', price='$product_price' WHERE id='$product_id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Product updated successfully!";
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>
