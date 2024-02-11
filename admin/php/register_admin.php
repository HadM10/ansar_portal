<?php
// admin/php/register_admin.php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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