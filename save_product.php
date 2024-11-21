<?php
// Save product details to the database

include('db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    // Initialize $image_path
    $image_path = '';

    // Check if an image file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_path = 'uploads/' . basename($image_name); // Define the path where image will be stored

        // Move the uploaded file to the desired directory
        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
            exit;
        }
    }

    // Update or insert into the database depending on whether $id exists
    if ($id) {
        // Update the product
        if ($image_path == '') {
            // If no image was uploaded, use the existing image path
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ? WHERE id = ?");
            $stmt->bind_param("ssdsd", $name, $description, $price, $category, $id);
        } else {
            // If a new image was uploaded, update the image path as well
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("ssdsds", $name, $description, $price, $category, $image_path, $id);
        }
    } else {
        // Insert a new product with the image
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsd", $name, $description, $price, $category, $image_path);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save the product']);
    }

    $stmt->close();
    $conn->close();
}
?>
