<?php
include ('headers.php');

// admin/php/edit_store.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $storeId = $_POST["store_id"];
    $newStoreName = $_POST["new_store_name"];
    $newCategory = $_POST["new_category"];
    $newDescription = $_POST["new_description"];
    $newPhoneNumber = $_POST["new_phone_number"];
    $newTiktokUrl = $_POST["new_tiktok_url"];
    $newFacebookUrl = $_POST["new_facebook_url"];
    $newWhatsappNumber = $_POST["new_whatsapp_number"];
    $newInstagramUrl = $_POST["new_instagram_url"];
    $newLocation = $_POST["new_location"];
    $newArchived = $_POST["new_archived"]; // New archived status

    // Update store information in the 'stores' table
    $updateQuery = "UPDATE stores 
                    SET store_name = ?, 
                        category_id = ?, 
                        store_description = ?, 
                        phone_number = ?, 
                        tiktok_url = ?, 
                        facebook_url = ?, 
                        whatsapp_number = ?, 
                        instagram_url = ?, 
                        location = ?, 
                        archived = ? 
                    WHERE store_id = ?";

    // Prepare the update query
    $stmt = $conn->prepare($updateQuery);

    // Bind parameters
    $stmt->bind_param("sisssssssii", $newStoreName, $newCategory, $newDescription, $newPhoneNumber, $newTiktokUrl, $newFacebookUrl, $newWhatsappNumber, $newInstagramUrl, $newLocation, $newArchived, $storeId);

    // Execute the update query
    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Store updated successfully");
    } else {
        $response = array("status" => "error", "message" => "Error updating store: " . $stmt->error);
    }

    // Close the prepared statement
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

?>