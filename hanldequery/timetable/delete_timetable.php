<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID parameter is set in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Prepare SQL statement to delete the record from the database
    $sql = "DELETE FROM timetable WHERE id = $id";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Record deleted successfully
        echo "<script>alert('Record deleted successfully.');</script>";
    } else {
        // Error occurred while deleting the record
        echo "<script>alert('Error: Unable to delete record.');</script>";
    }
} else {
    // ID parameter is missing or empty
    echo "<script>alert('Error: Invalid request.');</script>";
}

// Close database connection
$conn->close();

// Redirect back to the previous page or any desired page
header("Location: ../../time-table.php");
exit; // Stop further execution
?>
