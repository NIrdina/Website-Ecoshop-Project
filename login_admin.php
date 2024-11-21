<?php
// Include database configuration
require_once 'db.php';

session_start();

// Check if the admin is already logged in and redirect to the dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.html"); // Redirect to dashboard
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Query to fetch admin by email
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    // Check if admin exists and verify password
    if ($admin && password_verify($password, $admin['password'])) {
        // Set session variables
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['username'] = $admin['username'];

        // Redirect to dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Display error message if login fails
        $error_message = "Invalid email or password.";
    }
}
?>


