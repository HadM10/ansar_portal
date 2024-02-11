<?php
// admin/php/add_category.php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive category data from the request
    if (isset($_POST["category_name"])) {
        $categoryName = $_POST['category_name'];

        // Insert the new category into the database
        $insertQuery = "INSERT INTO categories (category_name) VALUES ('$categoryName')";
        if ($conn->query($insertQuery)) {
            // Respond with success message
            echo json_encode(["message" => "Category added successfully"]);
        } else {
            // Respond with database error message
            echo json_encode(["error" => "Database error"]);
        }
    } else {
        // Respond with error message for missing category_name
        echo json_encode(["error" => "Missing category_name"]);
    }
} else {
    // Respond with error for invalid request method
    echo json_encode(["error" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>