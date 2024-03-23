<?php
session_start();

// Database connection parameters
$host = "localhost"; // Change this if your database is hosted on a different server
$username = "u101827917_aqibhameedproj"; // Change this to your MySQL username
$password = "aqibhameed1234@aqibHameed"; // Change this to your MySQL password
$database = "u101827917_schoolmanagemt"; // Change this to your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query to check if the user exists with the provided email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User exists, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, login successful
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: ../dashboard.php");
            exit;
        } else {
            // Incorrect password
            header("Location: error fine "); // Redirect back to the login page with an error message indicating incorrect credentials
            exit;
        }
    } else {
        // User does not exist
        header("Location: login.php?error=UserNotFound"); // Redirect back to the login page with an error message indicating user not found
        exit;
    }
}
?>
