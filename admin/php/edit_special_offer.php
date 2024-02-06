<?php
// admin/php/edit_special_offers.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $offer_id = $_POST['offer_id'];
    $offer_title = $_POST['offer_title'];
    $offer_description = $_POST['offer_description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $image_url = $_POST['image_url'];

    // Sanitize and validate data (Add your validation logic here)

    // Update special offer in the database
    $updateQuery = "UPDATE offers SET offer_title = '$offer_title', offer_description = '$offer_description', 
                    start_date = '$start_date', end_date = '$end_date', image_url = '$image_url' WHERE offer_id = '$offer_id'";

    if ($conn->query($updateQuery) === TRUE) {
        // Success message
        $response = array('status' => 'success', 'message' => 'Special offer updated successfully');
    } else {
        // Error message
        $response = array('status' => 'error', 'message' => 'Error updating special offer: ' . $conn->error);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect or handle accordingly
    // (e.g., show an error message, redirect to the form page)
    header("Location: /path/to/special_offer_edit_form.php");
    exit();
}
?>