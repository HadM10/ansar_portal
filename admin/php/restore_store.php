<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Include your database connection file
include_once "db_connection.php";

// Check if the store_id parameter is set
if (isset($_POST['store_id'])) {
    $storeId = $_POST['store_id'];

    // Update the store's archived status to 0 (not archived)
    $updateQuery = "UPDATE stores SET archived = 0 WHERE store_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $storeId);

    if ($stmt->execute()) {
        // Store restored successfully
        echo json_encode(["status" => "success", "message" => "Store restored successfully"]);
    } else {
        // Error restoring store
        echo json_encode(["status" => "error", "message" => "Error restoring store"]);
    }
} else {
    // Error: store_id parameter not provided
    echo json_encode(["status" => "error", "message" => "store_id parameter not provided"]);
}

// Close the database connection
$conn->close();
?>