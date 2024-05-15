<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/add_store.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    if (isset($_POST["store_name"]) && isset($_POST["category_id"]) && isset($_POST["store_description"]) && isset($_POST["phone_number"]) && isset($_POST["tiktok"]) && isset($_POST["facebook"]) && isset($_POST["whatsapp"]) && isset($_POST["instagram"]) && isset($_POST["location"])) {
        $storeName = $_POST["store_name"];
        $category = $_POST["category_id"];
        $description = $_POST["store_description"];
        $phone = $_POST["phone_number"];
        $tiktokUrl = $_POST["tiktok"];
        $facebookUrl = $_POST["facebook"];
        $whatsappNumber = $_POST["whatsapp"];
        $instagramUrl = $_POST["instagram"];
        $location = $_POST["location"];

        // Set archived status to not archived (0) by default
        $archived = 0;

        // Perform data validation and database insertion
        // Example: Insert data into the 'stores' table
        $insertQuery = "INSERT INTO stores (store_name, store_description, category_id, phone_number, tiktok_url, facebook_url, whatsapp_number, instagram_url, location, archived) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the insert query
        $stmt = $conn->prepare($insertQuery);

        // Bind parameters
        $stmt->bind_param("ssissssssi", $storeName, $description, $category, $phone, $tiktokUrl, $facebookUrl, $whatsappNumber, $instagramUrl, $location, $archived);

        // Execute the insert query
        if ($stmt->execute()) {
            $response = array("status" => "success", "message" => "Store added successfully");
        } else {
            $response = array("status" => "error", "message" => "Error adding store: " . $stmt->error);
        }

        // Close the prepared statement
        $stmt->close();

        echo json_encode($response);
        exit();
    }
}

?>