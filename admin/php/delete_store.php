<?php
include ('headers.php');

// admin/php/delete_store.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $storeId = $_POST["store_id"];

    // Delete store from the 'stores' table
    $deleteQuery = "DELETE FROM stores WHERE store_id = $storeId";

    if ($conn->query($deleteQuery) === TRUE) {
        // Also delete associated images
        $deleteImagesQuery = "DELETE FROM storeimages WHERE store_id = $storeId";
        $conn->query($deleteImagesQuery);

        $response = array("status" => "success", "message" => "Store and associated images deleted successfully");
    } else {
        $response = array("status" => "error", "message" => "Error deleting store: " . $conn->error);
    }

    header('Content-Type: application/json'); // Set JSON header
    echo json_encode($response);
    exit();
}
?>