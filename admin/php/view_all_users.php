<?php
// admin/php/view_all_users.php
include('db_connection.php');

// Retrieve user information from the database
$selectQuery = "SELECT user_id, username, email, created_at FROM useraccounts";
$result = $conn->query($selectQuery);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = array(
            "user_id" => $row["user_id"],
            "username" => $row["username"],
            "email" => $row["email"],
            "created_at" => $row["created_at"]
        );
    }
}

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($users);
?>