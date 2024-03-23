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
    $teacher_id = $_GET['id'];

    // Fetch teacher details from the database based on the received teacher ID
    $sql = "SELECT * FROM teachers WHERE id = $teacher_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Teacher record found, fetch details
        $teacher_data = $result->fetch_assoc();
    } else {
        // Teacher record not found
        echo "Teacher not found.";
        exit; // Stop further execution
    }
} else {
    // 'id' parameter not set
    echo "Teacher ID not received";
    exit; // Stop further execution
}

// Check if form is submitted for updating teacher details
if(isset($_POST['submit'])) {
    // Sanitize and validate form input data
    // Here you would sanitize and validate user input to prevent SQL injection and other vulnerabilities
    
    // Extract submitted form data
    $name = $_POST['name'];
    $status = $_POST['status'];

    // Prepare SQL statement to update teacher details in the database
    $update_sql = "UPDATE teachers SET name = '$name', status = '$status' WHERE id = $teacher_id";

    // Execute the SQL statement
    if ($conn->query($update_sql) === TRUE) {
        // Teacher details updated successfully
        echo "<script>alert('Teacher details updated successfully.');</script>";
        // Redirect the user to the page displaying teacher records or any other desired page
        header("Location: ../../teachers.php");
        exit; // Stop further execution
    } else {
        // Error occurred while updating teacher details
        echo "<script>alert('Error: Unable to update teacher details.');</script>";
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
    <!-- Your existing HTML content for updating teacher details -->

    <!-- Form for editing teacher details -->
    <div class="container">
        <div class="row justify-content-center"> <!-- Center the row horizontally -->
            <div class="col-md-6 mt-5 border rounded p-5"> <!-- Added border, rounded, margin-top, and padding classes -->
                <h1 class="h3 text-center p-1">Update Teacher</h1>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Teacher Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($teacher_data['name']) ? $teacher_data['name'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" <?php echo isset($teacher_data['status']) && $teacher_data['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo isset($teacher_data['status']) && $teacher_data['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Update Teacher</button>
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
