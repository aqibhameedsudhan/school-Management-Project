<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if the 'id' parameter is set
if(isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    // Check if there are any related records in the teacher_subject table
    $check_sql = "SELECT * FROM teacher_subject WHERE teacher_id = $teacher_id";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // There are related records, so we cannot delete the teacher directly
        echo "<script>alert('Cannot delete teacher because there are related subjects.');</script>";
        // Redirect the user to the page displaying teacher records or any other desired page
        header("Location: ../../teachers.php");
        exit; // Stop further execution
    } else {
        // No related records found, it's safe to delete the teacher
        $delete_sql = "DELETE FROM teachers WHERE id = $teacher_id";

        if ($conn->query($delete_sql) === TRUE) {
            // Teacher deleted successfully
            header("Location: ../../teachers.php");
            echo "<script>alert('Teacher deleted successfully.');</script>";
            // Redirect the user to the page displaying teacher records or any other desired page
            exit; // Stop further execution
        } else {
            // Error occurred while deleting teacher
            echo "<script>alert('Error: Unable to delete teacher.');</script>";
            echo "<script>window.history.back();</script>"; // Go back to the previous page
            exit; // Stop further execution
        }
    }
} else {
    // 'id' parameter not set
    echo "<script>alert('Teacher ID not received.');</script>";
    echo "<script>window.history.back();</script>"; // Go back to the previous page
    exit; // Stop further execution
}

// Close database connection
$conn->close();
?>
