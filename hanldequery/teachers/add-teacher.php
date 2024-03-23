<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $name = $_POST['name']; // Assuming 'name' corresponds to the teacher's name
    $status = $_POST['status']; // Assuming 'status' corresponds to the teacher's status

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO teachers (name, status, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
    
    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $status);

    // Execute the statement
    if ($stmt->execute()) {
        // Data inserted successfully
        echo "<script>alert('Teacher added successfully.');</script>";
        header("Location: ../../teachers.php"); // Redirect to the page displaying teachers
        exit; // Stop further execution
    } else {
        // Error occurred while inserting data
        echo "<script>alert('Error: Unable to add teacher.');</script>";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
