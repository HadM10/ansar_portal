<?php

require_once 'db_connection.php';

include ('headers.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username already exists
    $checkUsernameStmt = $conn->prepare("SELECT username FROM useraccounts WHERE username = ?");
    $checkUsernameStmt->bind_param("s", $username);
    $checkUsernameStmt->execute();
    $checkUsernameStmt->store_result();

    if ($checkUsernameStmt->num_rows > 0) {
        // If the username already exists, send an error message
        http_response_code(409); // HTTP status code 409 Conflict
        echo json_encode(["error" => "Username already exists"]);
        $checkUsernameStmt->close();
        exit;
    }

    // Check if the email already exists
    $checkEmailStmt = $conn->prepare("SELECT email FROM useraccounts WHERE email = ?");
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if ($checkEmailStmt->num_rows > 0) {
        // If the email already exists, send an error message
        http_response_code(409); // HTTP status code 409 Conflict
        echo json_encode(["error" => "Email already exists"]);
        $checkEmailStmt->close();
        exit;
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to insert user into the database
    $stmt = $conn->prepare("INSERT INTO useraccounts (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $passwordHash);

    if ($stmt->execute()) {
        // Sign up successful
        http_response_code(201); // HTTP status code 201 Created
        echo json_encode(["message" => "Signup successful"]);
    } else {
        // Sign up failed
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Error creating new user: " . $stmt->error]);
    }

    // Close all statements
    $stmt->close();
    $checkEmailStmt->close();
    $checkUsernameStmt->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed"]);
}

?>