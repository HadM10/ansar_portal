<?php
// Include headers and any necessary initializations
include ('headers.php');

// Include database connection
include ('db_connection.php');

// Check if category_id is provided
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Query to fetch category details based on category_id
    $query = "SELECT category_id, category_name, category_image FROM categories WHERE category_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch category details as an associative array
        $categoryDetails = $result->fetch_assoc();

        // Close the prepared statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($categoryDetails);
    } else {
        // Category not found
        echo json_encode(array('status' => 'error', 'message' => 'Category not found'));
    }
} else {
    // category_id parameter not provided
    echo json_encode(array('status' => 'error', 'message' => 'Category ID not provided'));
}
?>