<?php
// admin/php/delete_image.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $store_id = $_POST['store_id'];
    $image_url = $_POST['image_url'];

    // Sanitize and validate data (Add your validation logic here)

    // Delete image from the database
    $deleteQuery = "DELETE FROM images WHERE store_id = '$store_id' AND image_url = '$image_url'";

    if ($conn->query($deleteQuery) === TRUE) {
        // Success message
        $response = array('status' => 'success', 'message' => 'Image deleted successfully');
    } else {
        // Error message
        $response = array('status' => 'error', 'message' => 'Error deleting image: ' . $conn->error);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect or handle accordingly
    // (e.g., show an error message, redirect to the form page)
    header("Location: /path/to/image_delete_form.php");
    exit();
}
?>