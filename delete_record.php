<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM records WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
