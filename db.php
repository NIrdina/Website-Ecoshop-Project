<?php
// Database connection variables
$host = "localhost";  // Database server address
$username = "root";    // Database username (usually 'root' for local MySQL)
$password = "";        // Database password (blank for local MySQL)
$dbname = "user_database"; // The database name to connect to

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());  // Outputs connection error if failed
}
?>
