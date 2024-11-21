<?php
// admin_dashboard.php
include 'db.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($searchTerm)) {
    // Prepare the SQL statement with placeholders for secure searching
    $stmt = $conn->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ?");
    $searchTermWildcard = "%" . $searchTerm . "%";
    $stmt->bind_param("ss", $searchTermWildcard, $searchTermWildcard);
} else {
    // Retrieve all records if no search term is provided
    $stmt = $conn->prepare("SELECT * FROM users");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!-- The following block outputs HTML for each row, assuming it is embedded in `admin_dashboard.html` -->

<tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><a href='edit_record.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_record.php?id=" . $row['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No records found.</td></tr>";
    }
    ?>
</tbody>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
