<?php

require_once 'db_connection.php';
// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to insert user into the database using prepared statement
    $stmt = $conn->prepare("INSERT INTO useraccounts (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $passwordHash);

    if ($stmt->execute()) {
        // Sign up successful
        http_response_code(200);
        echo 'Signup successful';
    } else {
        // Sign up failed
        http_response_code(500);
        echo 'Error: ' . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    http_response_code(405); // Method Not Allowed
}

?>