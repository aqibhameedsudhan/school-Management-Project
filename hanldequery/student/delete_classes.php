<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if the 'id' parameter is set
if(isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Prepare SQL statement to delete the record from the database
    $sql = "DELETE FROM students WHERE id = $student_id";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Record deleted successfully
        header("Location: ../../student.php");
        exit;
    } else {
        // Error occurred while deleting the record
        echo "Error: " . $conn->error;
    }
} else {
    // ID parameter is missing or empty
    echo "Error: Invalid request.";
}

// Close database connection
$conn->close();
?>
