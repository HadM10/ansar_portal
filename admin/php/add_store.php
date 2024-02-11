<?php
// admin/php/add_store.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    if (isset($_POST["store_name"]) && isset($_POST["category_id"]) && isset($_POST["store_description"]) && isset($_POST["phone_number"])) {
        $storeName = $_POST["store_name"];
        $category = $_POST["category_id"];
        $description = $_POST["store_description"];
        $phone = $_POST["phone_number"];

        // Perform data validation and database insertion
        // Example: Insert data into the 'stores' table
        $insertQuery = "INSERT INTO stores (store_name, store_description, category_id, phone_number) VALUES ('$storeName', '$description', '$category', '$phone')";

        if ($conn->query($insertQuery) === TRUE) {
            $response = array("status" => "success", "message" => "Store added successfully");
        } else {
            $response = array("status" => "error", "message" => "Error adding store: " . $conn->error);
        }

        echo json_encode($response);
        exit();
    }
}
?>