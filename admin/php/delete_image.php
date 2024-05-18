<?php
include ('headers.php');

// admin/php/delete_image.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $image_id = $_POST['image_id'];
    $store_id = $_POST['store_id'];

    // Sanitize and validate data (Add your validation logic here)

    // Delete image from the database
    $deleteQuery = "DELETE FROM storeimages WHERE image_id = '$image_id' AND store_id = '$store_id'";

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

    exit();
}

?>