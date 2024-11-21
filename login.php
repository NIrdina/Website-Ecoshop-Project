<?php
session_start();
include 'db.php';  // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query to select user based on email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to website.html after successful login
        header("Location: website.html");
        exit;
    } else {
        echo "Invalid email or password.";
    }
}
?>
