<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/delete_category.php
include ('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive category ID from the request
    $categoryId = $_POST['category_id'];

    // Delete the category from the database
    $deleteQuery = "DELETE FROM categories WHERE category_id = $categoryId";
    $conn->query($deleteQuery);

    // Close the database connection
    $conn->close();

    // Respond with success message or appropriate response
    echo json_encode(["message" => "Category deleted successfully"]);
} else {
    // Handle invalid request method
    echo json_encode(["error" => "Invalid request method"]);
}
?>