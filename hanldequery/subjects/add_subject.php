<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $_POST['title'];
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $status = $_POST['status'];

    // Prepare and execute the SQL statement to insert data into the subjects table
    $insert_query = "INSERT INTO subjects (title, class_id, teacher_id, status) VALUES ('$title', '$class_id', '$teacher_id', '$status')";
    if ($conn->query($insert_query) === TRUE) {
        // If the insertion is successful, redirect back to the subjects page
        header("Location: ../../subjects.php");
        exit();
    } else {
        // If an error occurs, display an error message
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
} else {
    // If the form is not submitted, redirect back to the subjects page
    header("Location: subjects.php");
    exit();
}
?>
