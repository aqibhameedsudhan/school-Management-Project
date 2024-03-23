<?php
//error_reporting(0);
ob_start();
session_start();

// DEFINE constants
define("DB_HOST", "localhost");
define("DB_USER", "u101827917_aqibhameedproj"); // Change this to your MySQL username
define("DB_PSWD", "aqibhameed1234@aqibHameed"); // Change this to your MySQL password
define("DB_NAME", "u101827917_schoolmanagemt"); // Change this to your database name

// Database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
if ($conn->connect_error) {
    die("Failed to connect to database: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Calcutta');
?>

