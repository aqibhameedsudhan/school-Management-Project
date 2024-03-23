<?php
// Include database connection file
include("../php/dbconnect.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $title = $_POST['title'];
    $status = $_POST['status'];

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO classes (title, status, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $status);

    // Execute the statement
    if ($stmt->execute()) {
        // Data inserted successfully
        echo "<script>alert('Class added successfully.');</script>";
        header("Location: ../classes.php");
    } else {
        // Error occurred while inserting data
        echo "<script>alert('Error: Unable to add class.');</script>";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
