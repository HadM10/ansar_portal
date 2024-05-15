<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/edit_category.php
include ('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive category data from the request
    $categoryId = $_POST['category_id'];
    $newCategoryName = $_POST['new_category_name'];

    // Update the category in the database
    $updateQuery = "UPDATE categories SET category_name = '$newCategoryName' WHERE category_id = $categoryId";
    $conn->query($updateQuery);

    // Close the database connection
    $conn->close();

    // Respond with success message or appropriate response
    echo json_encode(["message" => "Category updated successfully"]);
} else {
    // Handle invalid request method
    echo json_encode(["error" => "Invalid request method"]);
}
?>