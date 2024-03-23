<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentName = $_POST['studentName'];
    $classId = $_POST['classId'];
    $studentStatus = $_POST['studentStatus'];

    // Prepare SQL statement to insert the new student into the database
$sql = "INSERT INTO students (name, class_id, status, created_at, updated_at) 
VALUES ('$studentName', '$classId', '$studentStatus', NOW(), NOW())";


    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect to the student page after successful insertion
        header("Location: ../../student.php");
        exit;
    } else {
        // Error occurred while inserting the student
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
