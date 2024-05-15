<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/delete_offer.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["offer_id"])) {
        // Retrieve offer ID from the form
        $offer_id = $_POST['offer_id'];

        // Delete the special offer from the database
        $deleteQuery = "DELETE FROM offers WHERE offer_id = $offer_id";

        if ($conn->query($deleteQuery) === TRUE) {
            // Success message
            $response = array('status' => 'success', 'message' => 'Special offer deleted successfully');
        } else {
            // Error message
            $response = array('status' => 'error', 'message' => 'Error deleting special offer: ' . $conn->error);
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

        // Close the database connection
        $conn->close();
    } else {
        // If the offer ID is not provided, send an error response
        $response = array('status' => 'error', 'message' => 'Offer ID not provided');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
} else {
    // If the form is not submitted, send an error response
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>