<?php
// admin/php/view_all_users.php
include ('db_connection.php');

// Retrieve user information from the database
$selectQuery = "SELECT user_id, username, email, google_id, created_at FROM useraccounts";
$result = $conn->query($selectQuery);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user = array(
            "user_id" => $row["user_id"],
            "username" => isset($row["username"]) ? $row["username"] : null,
            "email" => $row["email"],
            "google_id" => isset($row["google_id"]) ? $row["google_id"] : null,
            "created_at" => $row["created_at"]
        );
        $users[] = $user;
    }
}

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($users);
?>