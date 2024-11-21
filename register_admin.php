<?php
// Include database configuration
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = mysqli_real_escape_string($conn, htmlspecialchars($_POST['username'])); // Prevent XSS and SQL Injection
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Check if email or username already exists 
    $sql = "SELECT COUNT(*) FROM admins WHERE email = ? OR username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    $stmt_result = mysqli_stmt_get_result($stmt);
    $existingUser = mysqli_fetch_array($stmt_result)[0];

    if ($existingUser) {
        echo "Error: Email or Username already exists. Please choose a different one.";
    } else {
        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new admin into the database
        $sql = "INSERT INTO admins (email, username, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $email, $username, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect to admin dashboard after successful registration
            header("Location: admin_dashboard.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn); // Output more meaningful error message
        }
    }
}
?>
