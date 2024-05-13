<?php
// admin/php/db_connection.php
include ('https://ansarportal-deaa9ded50c7.herokuapp.com/admin/php/config/database_config.php');  // Adjust the path based on your project structure

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>