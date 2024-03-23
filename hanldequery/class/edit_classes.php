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
    $class_id = $_GET['id'];

    // Fetch class details from the database based on the received class ID
    $sql = "SELECT * FROM classes WHERE id = $class_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Class record found, fetch details
        $class_data = $result->fetch_assoc();
    } else {
        // Class record not found
        echo "Class not found.";
        exit; // Stop further execution
    }
} else {
    // 'id' parameter not set
    echo "Class ID not received";
    exit; // Stop further execution
}

// Check if form is submitted for updating class details
if(isset($_POST['submit'])) {
    // Sanitize and validate form input data
    // Here you would sanitize and validate user input to prevent SQL injection and other vulnerabilities
    
    // Extract submitted form data
    $title = $_POST['title'];
    $status = $_POST['status'];

    // Prepare SQL statement to update class details in the database
    $update_sql = "UPDATE classes SET title = '$title', status = '$status' WHERE id = $class_id";

    // Execute the SQL statement
    if ($conn->query($update_sql) === TRUE) {
        // Class details updated successfully
        echo "<script>alert('Class details updated successfully.');</script>";
        // Redirect the user to the page displaying class records or any other desired page
        header("Location: ../../classes.php");
        exit; // Stop further execution
    } else {
        // Error occurred while updating class details
        echo "<script>alert('Error: Unable to update class details.');</script>";
    }
}

// Close database connection
$conn->close();
?><?php
// Include header file
include("../../php/head.php");
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">
                
        
    </div>


<!-- Form for editing class details -->
<div class="container">
    <div class="row justify-content-center"> <!-- Center the row horizontally -->
        
    <div class="col-md-6 mt-5 border rounded p-5"> <!-- Added border, rounded, margin-top, and padding classes -->
    <h1 class="h3 text-center p-1">Update Class</h1>
 
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Class Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($class_data['title']) ? $class_data['title'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" <?php echo isset($class_data['status']) && $class_data['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo isset($class_data['status']) && $class_data['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update Class</button>
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
