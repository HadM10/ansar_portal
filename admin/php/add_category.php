<?php
// admin/php/add_category.php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive category data from the request
    $categoryName = $_POST['category_name'];

    // Insert the new category into the database
    $insertQuery = "INSERT INTO categories (category_name) VALUES ('$categoryName')";
    $conn->query($insertQuery);

    // Close the database connection
    $conn->close();

    // Respond with success message or appropriate response
    echo json_encode(["message" => "Category added successfully"]);
} else {
    // Handle invalid request method
    echo json_encode(["error" => "Invalid request method"]);
}
?>