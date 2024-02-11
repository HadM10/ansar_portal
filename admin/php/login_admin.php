<?php
// admin/php/login_admin.php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve hashed password from the database
    $selectQuery = "SELECT * FROM admin_users WHERE username='$username'";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the entered password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            echo json_encode(array("message" => "Login successful"));
        } else {
            echo json_encode(array("error" => "Invalid password"));
        }
    } else {
        echo json_encode(array("error" => "Admin not found"));
    }

    $conn->close();
}
?>