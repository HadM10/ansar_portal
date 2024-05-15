<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include ('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $selectQuery = "SELECT * FROM admin_users WHERE username='$username'";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Authentication successful
            session_start();
            $_SESSION['user_id'] = $row['admin_id'];
            $_SESSION['login_time'] = time();  // Set login timestamp
            echo json_encode(array("message" => "Sign in successfully"));

        } else {
            echo json_encode(array("error" => "Invalid password"));
        }
    } else {
        echo json_encode(array("error" => "Admin not found"));
    }

    $conn->close();
}
?>