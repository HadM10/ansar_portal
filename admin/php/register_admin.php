<?php
include ('db_connection.php');
include ('headers.php');

// Retrieve the registration code from the environment variables
$registrationCode = getenv('REGISTRATION_CODE');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the registration code is correct
    if ($_POST['registration_code'] !== $registrationCode) {
        echo json_encode(array("error" => "Incorrect registration code. Please try again."));
        exit();
    }

    // Proceed with user registration
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

    // Insert admin into the database
    $insertQuery = "INSERT INTO admin_users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($insertQuery) === TRUE) {
        echo json_encode(array("message" => "Admin registered successfully"));
    } else {
        echo json_encode(array("error" => "Error: " . $conn->error));
    }

    $conn->close();
}
?>