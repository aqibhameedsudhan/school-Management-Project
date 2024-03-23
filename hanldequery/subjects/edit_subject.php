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

// Check if ID parameter is set in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch subject details based on the ID
    $sql_subject = "SELECT * FROM subjects WHERE id = $id";
    $result_subject = $conn->query($sql_subject);

    // Check if subject exists
    if ($result_subject->num_rows > 0) {
        $row_subject = $result_subject->fetch_assoc();
        $subject_id = $row_subject['id'];
        $subject_title = $row_subject['title'];
        $class_id = $row_subject['class_id'];
        $teacher_id = $row_subject['teacher_id'];
        $status = $row_subject['status'];
    } else {
        // Redirect or show error message if subject doesn't exist
        echo "Subject not found.";
        exit();
    }
} else {
    // Redirect or show error message if ID parameter is missing
    echo "Invalid request.";
    exit();
}

// Fetch class options
$sql_classes = "SELECT id, title FROM classes";
$result_classes = $conn->query($sql_classes);

// Fetch teacher options
$sql_teachers = "SELECT id, name FROM teachers";
$result_teachers = $conn->query($sql_teachers);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subject_id = $_POST['subject_id'];
    $subject_title = $_POST['title'];
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];
    $status = $_POST['status'];

    // Update subject details in the database
    $sql_update = "UPDATE subjects SET title = '$subject_title', class_id = '$class_id', teacher_id = '$teacher_id', status = '$status' WHERE id = $subject_id";

    if ($conn->query($sql_update) === TRUE) {
        // Subject details updated successfully
        header("Location: ../../subjects.php");
        exit();
    } else {
        // Error occurred while updating subject details
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

// Include header file
include("../../php/head.php");
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">
    </div>

    <!-- Form for editing subject details -->
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row horizontally -->
            <div class="col-md-6 border rounded p-3"> <!-- Added border, rounded, margin-top, and padding classes -->
                <h1 class="h3 text-center p-1">Update Subject</h1>
                <form method="POST" action="">
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                    <div class="form-group">
                        <label for="title">Subject Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $subject_title; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="class_id">Class:</label>
                        <select class="form-control" id="class_id" name="class_id" required>
                            <?php
                            // Output class options
                            if ($result_classes->num_rows > 0) {
                                while ($row_class = $result_classes->fetch_assoc()) {
                                    echo "<option value='" . $row_class['id'] . "'";
                                    if ($row_class['id'] == $class_id) {
                                        echo " selected";
                                    }
                                    echo ">" . $row_class['title'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher_id">Teacher:</label>
                        <select class="form-control" id="teacher_id" name="teacher_id" required>
                            <?php
                            // Output teacher options
                            if ($result_teachers->num_rows > 0) {
                                while ($row_teacher = $result_teachers->fetch_assoc()) {
                                    echo "<option value='" . $row_teacher['id'] . "'";
                                    if ($row_teacher['id'] == $teacher_id) {
                                        echo " selected";
                                    }
                                    echo ">" . $row_teacher['name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" <?php if($status == 'active') echo 'selected'; ?>>Active</option>
                            <option value="inactive" <?php if($status == 'inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Subject</button>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="text-center mt-4">
    <div class="container">
        <p>Online Allied school management System | Developed By: Aqib Hameed</p>
    </div>
</footer>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
