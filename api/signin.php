<?php

require_once 'db_connection.php';

include ('headers.php');

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to fetch user from the database using prepared statement
    $stmt = $conn->prepare("SELECT * FROM useraccounts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Sign in successful, respond with the user ID
            http_response_code(200);
            echo $user['user_id'];
        } else {
            // Incorrect password
            http_response_code(400);
            echo 'Incorrect password';
        }
    } else {
        // User not found
        http_response_code(404);
        echo 'User not found';
    }

    // Close statement
    $stmt->close();
} else {
    http_response_code(405); // Method Not Allowed
}

?>