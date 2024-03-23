<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allied school management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/styles.css">
</head>
<body>
<?php
// Include database connection file
include("../../php/dbconnect.php");

// Check if the 'id' parameter is set
if(isset($_GET['id'])) {
    $timetable_id = $_GET['id'];

    // Fetch timetable details from the database based on the received timetable ID
    $sql = "SELECT * FROM timetable WHERE id = $timetable_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Timetable record found, fetch details
        $timetable_data = $result->fetch_assoc();
    } else {
        // Timetable record not found
        echo "Timetable not found.";
        exit; // Stop further execution
    }
} else {
    // 'id' parameter not set
    echo "Timetable ID not received";
    exit; // Stop further execution
}

// Fetch class list
$sql_class = "SELECT * FROM classes";
$result_class = $conn->query($sql_class);

// Fetch teacher list
$sql_teacher = "SELECT * FROM teachers";
$result_teacher = $conn->query($sql_teacher);

// Fetch subject list
$sql_subject = "SELECT * FROM subjects";
$result_subject = $conn->query($sql_subject);

// Check if form is submitted for updating timetable details
if(isset($_POST['submit'])) {
    // Sanitize and validate form input data
    // Here you would sanitize and validate user input to prevent SQL injection and other vulnerabilities
    
    // Extract submitted form data
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $subject_id = $_POST['subject_id'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];

    // Prepare SQL statement to update timetable details in the database
    $update_sql = "UPDATE timetable SET class_id = '$class_id', teacher_id = '$teacher_id', subject_id = '$subject_id', day_of_week = '$day_of_week', start_time = '$start_time', end_time = '$end_time', status = '$status' WHERE id = $timetable_id";

    // Execute the SQL statement
    if ($conn->query($update_sql) === TRUE) {
        // Timetable details updated successfully
        echo "<script>alert('Timetable details updated successfully.');</script>";
        // Redirect the user to the page displaying timetable records or any other desired page
        header("Location: ../../time-table.php");
        exit; // Stop further execution
    } else {
        // Error occurred while updating timetable details
        echo "<script>alert('Error: Unable to update timetable details.');</script>";
    }
}

// Close database connection
$conn->close();
?>
<?php
// Include header file
include("../../php/head.php");
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <!-- Form for editing timetable details -->
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row horizontally -->
            <div class="col-md-8 mt-2 border rounded p-4"> <!-- Added border, rounded, margin-top, and padding classes -->
                <h1 class="h3 text-center mb-4">Update Timetable</h1>
                <form method="POST" action="">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="class_id">Class</label>
                            <select class="form-control" id="class_id" name="class_id" required>
                                <?php
                                if ($result_class->num_rows > 0) {
                                    while ($row = $result_class->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "' " . ($row['id'] == $timetable_data['class_id'] ? 'selected' : '') . ">" . $row['title'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="teacher_id">Teacher</label>
                            <select class="form-control" id="teacher_id" name="teacher_id" required>
                                <?php
                                if ($result_teacher->num_rows > 0) {
                                    while ($row = $result_teacher->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "' " . ($row['id'] == $timetable_data['teacher_id'] ? 'selected' : '') . ">" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="subject_id">Subject</label>
                            <select class="form-control" id="subject_id" name="subject_id" required>
                                <?php
                                if ($result_subject->num_rows > 0) {
                                    while ($row = $result_subject->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "' " . ($row['id'] == $timetable_data['subject_id'] ? 'selected' : '') . ">" . $row['title'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="day_of_week">Day of Week</label>
                            <input type="text" class="form-control" id="day_of_week" name="day_of_week" value="<?php echo isset($timetable_data['day_of_week']) ? $timetable_data['day_of_week'] : ''; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="start_time">Start Time</label>
                            <input type="text" class="form-control" id="start_time" name="start_time" value="<?php echo isset($timetable_data['start_time']) ? $timetable_data['start_time'] : ''; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_time">End Time</label>
                            <input type="text" class="form-control" id="end_time" name="end_time" value="<?php echo isset($timetable_data['end_time']) ? $timetable_data['end_time'] : ''; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" <?php echo isset($timetable_data['status']) && $timetable_data['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo isset($timetable_data['status']) && $timetable_data['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update Timetable</button>
                </form>
            </div>
        </div>
    </div>
</main>


<footer class="text-center mt-4">
    <div class="container">
        <p>Online Allied School Management System | Developed By: Aqib Hameed</p>
    </div>
</footer>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script>
    // Add an event listener to the menu item
    document.getElementById('addClassLink').addEventListener('click', function(event) {
        // Prevent the default behavior of the link (i.e., navigating to another page)
        event.preventDefault();
        
        // Get the modal element
        var modal = document.getElementById('addClassModal');
        
        // Open the modal
        $(modal).modal('show');
    });

</script>
</body>
</html>
                           
