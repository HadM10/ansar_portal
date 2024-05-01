<?php
// Include your database connection file
include_once "db_connection.php";

// Check if the store_id parameter is set
if (isset($_GET['store_id'])) {
    $storeId = $_GET['store_id'];

    // Query to fetch store details
    $storeQuery = "SELECT store_id, store_name, store_description, category_id, phone_number FROM stores WHERE store_id = ?";

    // Prepare and execute the query
    $stmt = $conn->prepare($storeQuery);
    $stmt->bind_param("i", $storeId);
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($storeId, $storeName, $storeDescription, $category_id, $phoneNumber);

    // Fetch store details
    if ($stmt->fetch()) {
        $storeDetails = [
            'store_id' => $storeId,
            'store_name' => $storeName,
            "category_id" => $category_id,
            'store_description' => $storeDescription,
            'phone_number' => $phoneNumber
        ];
        // Encode the array as JSON and output
        echo json_encode($storeDetails);
    } else {
        // Store not found
        echo json_encode(['error' => 'Store not found']);
    }
} else {
    // Error: store_id parameter not provided
    echo json_encode(['error' => 'store_id parameter not provided']);
}

// Close the database connection
$conn->close();
?>