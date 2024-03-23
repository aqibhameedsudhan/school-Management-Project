<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Prepare and execute SQL query to insert data into timetable table
    $insert_query = "INSERT INTO timetable (class_id, teacher_id, subject_id, day_of_week, start_time, end_time) 
                     VALUES ('$class_id', '$teacher_id', '$subject_id', '$day_of_week', '$start_time', '$end_time')";
    if ($conn->query($insert_query) === TRUE) {
        // Data inserted successfully
        header("Location: ../../time-table.php"); // Redirect to timetable page after insertion
        exit();
    } else {
        // Error in SQL query
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    // If the form is not submitted via POST method, redirect to the timetable page
    header("Location: ../../time-table.php");
    exit();
}
?>
