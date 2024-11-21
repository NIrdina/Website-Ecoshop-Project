<?php
include 'db.php';  // Include database connection

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and fetch form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Email is already registered.";
        exit;
    }

    // Hash the password before inserting into the database
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL query to insert a new user
    $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$passwordHash')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to website.html after successful registration
        header("Location: website.html");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
