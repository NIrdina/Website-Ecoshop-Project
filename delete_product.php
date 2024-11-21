<?php
include 'db.php';

// Check if 'id' is provided and is numeric
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    // Check if the product exists before attempting to delete
    $id = $_POST['id'];
    $checkQuery = "SELECT COUNT(*) FROM products WHERE id = $id";
    $result = $conn->query($checkQuery);
    $row = $result->fetch_row();

    if ($row[0] == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Product not found'
        ]);
        exit;
    }

    // Prepare the SQL DELETE statement
    $deleteQuery = "DELETE FROM products WHERE id = $id";
    if ($conn->query($deleteQuery) === TRUE) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete product'
        ]);
    }
} else {
    // Return error response if 'id' is not provided or is invalid
    echo json_encode([
        'status' => 'error',
        'message' => 'No valid product ID provided'
    ]);
}

// Close the connection
$conn->close();
?>
