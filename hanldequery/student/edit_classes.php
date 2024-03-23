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
    $student_id = $_GET['id'];

    // Fetch student details from the database based on the received student ID
    $sql = "SELECT * FROM students WHERE id = $student_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Student record found, fetch details
        $student_data = $result->fetch_assoc();
    } else {
        // Student record not found
        echo "Student not found.";
        exit; // Stop further execution
    }
} else {
    // 'id' parameter not set
    echo "Student ID not received";
    exit; // Stop further execution
}

// Check if form is submitted for updating student details
if(isset($_POST['submit'])) {
    // Sanitize and validate form input data
    // Here you would sanitize and validate user input to prevent SQL injection and other vulnerabilities
    
    // Extract submitted form data
    $studentName = $_POST['studentName'];
    $classId = $_POST['classId'];
    $studentStatus = $_POST['studentStatus'];

    // Prepare SQL statement to update student details in the database
    $update_sql = "UPDATE students SET name = '$studentName', class_id = '$classId', status = '$studentStatus' WHERE id = $student_id";

    // Execute the SQL statement
    if ($conn->query($update_sql) === TRUE) {
        // Student details updated successfully
        echo "<script>alert('Student details updated successfully.');</script>";
        // Redirect the user to the page displaying student records or any other desired page
        header("Location: ../../student.php");
        exit; // Stop further execution
    } else {
        // Error occurred while updating student details
        echo "<script>alert('Error: Unable to update student details.');</script>";
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
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">      
    </div>

    <!-- Form for editing student details -->
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row horizontally -->  
            <div class="col-md-6 mt-5 border rounded p-5"> <!-- Added border, rounded, margin-top, and padding classes -->
                <h1 class="h3 text-center p-1">Update Student</h1>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="studentName">Student Name</label>
                        <input type="text" class="form-control" id="studentName" name="studentName" value="<?php echo isset($student_data['name']) ? $student_data['name'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="classId">Class</label>
                        <select class="form-control" id="classId" name="classId" required>
                            <option value="">Select Class</option>
                            <!-- Populate options dynamically -->
                            <?php
                            // Include the PHP code to fetch and generate class options
                            include("fetch_classes.php");
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="studentStatus">Status</label>
                        <select class="form-control" id="studentStatus" name="studentStatus" required>
                            <option value="active" <?php echo isset($student_data['status']) && $student_data['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo isset($student_data['status']) && $student_data['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update Student</button>
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
