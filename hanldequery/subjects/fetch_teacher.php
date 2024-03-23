<?php
// Include database connection file
include("../../php/dbconnect.php");

// Fetch classes from the database
$sql = "SELECT id, title FROM classes";
$result = $conn->query($sql);

// Check if classes are fetched successfully
if ($result->num_rows > 0) {
    // Output options for each class
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
    }
} else {
    // No classes found
    echo "<option value=''>No Classes Found</option>";
}

// Close the database connection
$conn->close();
?>
