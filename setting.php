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
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<?php
// Include database connection file
include("php/dbconnect.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Update user details in the database
    $user_id = 1; // Replace with the logged-in user's ID
    $sql_update = "UPDATE users SET name = '$name', email = '$email'";
    
    // Check if a new password is provided
    if (!empty($new_password)) {
        // Hash the new password before storing it in the database
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql_update .= ", password = '$hashed_password'";
    }
    
    $sql_update .= " WHERE id = $user_id";

    if ($conn->query($sql_update) === TRUE) {
        // Settings updated successfully
        header("Location: settings.php");
        exit();
    } else {
        // Error occurred while updating settings
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

// Retrieve user details for pre-filling the form
$user_id = 1; // Replace with the logged-in user's ID
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $name = $row_user['name'];
    $email = $row_user['email'];
} else {
    echo "User not found.";
    exit();
}

// Include header file
include("php/header.php");
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 ">
        <h1 class="h2">Settings</h1>
    </div>

    <!-- Form for updating user details -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 border rounded p-3">
            <h2 class="text-center mb-4">Update Account</h2>
                <form action="update_settings.php" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
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
