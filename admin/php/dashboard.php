<?php
include ('headers.php');

// admin/php/dashboard.php
include ('db_connection.php');

// Retrieve counts from the database
$query = "SELECT 
            (SELECT COUNT(*) FROM useraccounts) AS total_users,
            (SELECT COUNT(*) FROM admin_users) AS total_admins,
            (SELECT COUNT(*) FROM stores) AS total_stores,
            (SELECT COUNT(*) FROM offers) AS total_offers,
            (SELECT COUNT(*) FROM news) AS total_news,
            (SELECT COUNT(*) FROM categories) AS total_categories";
$result = $conn->query($query);
$row = $result->fetch_assoc();

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($row);
?>