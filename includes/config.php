
<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "food_delivery";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database Connection Error: " . $conn->connect_error, 3, __DIR__ . "/db_error.log");
    die("Database connection failed. Please try again later.");
}

// Optional: Set character set
$conn->set_charset("utf8mb4");
?>

