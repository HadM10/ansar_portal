<?php
// admin/php/add_store.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    if (isset($_POST["store_name"]) && isset($_POST["category"]) && isset($_POST["description"])) {
        $storeName = $_POST["store_name"];
        $category = $_POST["category"];
        $description = $_POST["description"];

        // Perform data validation and database insertion
        // Example: Insert data into the 'stores' table
        $insertQuery = "INSERT INTO stores (store_name, category, description) VALUES ('$storeName', '$category', '$description')";

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