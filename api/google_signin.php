<?php

require_once 'db_connection.php';

session_start(); // Start the session

include ('headers.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $googleId = $_POST['google_id'];
    $email = $_POST['email'];

    // Check if the Google ID exists in the database
    $stmt = $conn->prepare("SELECT * FROM useraccounts WHERE google_id = ?");
    $stmt->bind_param("s", $googleId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Google user already exists, retrieve user ID and store in session
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];

        // Respond to the client
        http_response_code(200);
        echo json_encode(['status' => 'success', 'user_id' => $_SESSION['user_id']]);
    } else {
        // Google user does not exist, insert new user record
        $stmt = $conn->prepare("INSERT INTO useraccounts (email, google_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $googleId);

        if ($stmt->execute()) {
            // New user record inserted successfully, retrieve user ID and store in session
            $_SESSION['user_id'] = $stmt->insert_id;

            // Respond to the client
            http_response_code(200);
            echo json_encode(['status' => 'success', 'user_id' => $_SESSION['user_id']]);
        } else {
            // Error inserting new user record
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error creating new user']);
        }
    }
    // Close statement
    $stmt->close();
} else {
    http_response_code(405); // Method Not Allowed
}

?>