<?php
// admin/php/edit_store.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $storeId = $_POST["store_id"];
    $newStoreName = $_POST["new_store_name"];
    $newCategory = $_POST["new_category"];
    $newDescription = $_POST["new_description"];

    // Update store information in the 'stores' table
    $updateQuery = "UPDATE stores SET store_name = '$newStoreName', category_id = '$newCategory', store_description = '$newDescription' WHERE store_id = $storeId";

    if ($conn->query($updateQuery) === TRUE) {
        $response = array("status" => "success", "message" => "Store updated successfully");
    } else {
        $response = array("status" => "error", "message" => "Error updating store: " . $conn->error);
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>