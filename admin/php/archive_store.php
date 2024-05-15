<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/archive_store.php
include ('db_connection.php');

// Check if the store_id parameter is provided
if (isset($_POST['store_id'])) {
    $storeId = $_POST['store_id'];

    // Update the store's archived status in the database
    $updateQuery = "UPDATE stores SET archived = 1 WHERE store_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $storeId);
    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Store archived successfully");
    } else {
        $response = array("status" => "error", "message" => "Failed to archive store");
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Error: store_id parameter not provided
    $response = array("status" => "error", "message" => "store_id parameter not provided");
}

// Close the database connection
$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>