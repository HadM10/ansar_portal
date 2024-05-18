<?php

// Add CORS and security headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");

include ('db_connection.php');

$response = array('status' => 'error', 'message' => 'Invalid request method');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                // Authentication successful
                session_start();
                session_regenerate_id(true); // Regenerate session ID to prevent session fixation
                $_SESSION['user_id'] = $row['admin_id'];
                $_SESSION['login_time'] = time();  // Set login timestamp

                $response = array('status' => 'success', 'message' => 'Sign in successfully');
            } else {
                $response = array('status' => 'error', 'message' => 'Invalid password');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Admin not found');
        }
        $stmt->close();
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>