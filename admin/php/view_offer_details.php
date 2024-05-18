<?php
include ('headers.php');

// Include database connection
include 'db_connection.php';

// Check if offer_id is provided
if (isset($_GET['offer_id'])) {
    $offer_id = $_GET['offer_id'];

    // Query to fetch offer details based on offer_id
    $query = "SELECT offer_id, store_id, offer_title, offer_description, start_date, end_date, image_url FROM offers WHERE offer_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $offer_id);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch offer details as an associative array
        $offerDetails = $result->fetch_assoc();

        // Map each field explicitly
        $offerDetailsMapped = [
            'offer_id' => $offerDetails['offer_id'],
            'store_id' => $offerDetails['store_id'],
            'offer_title' => $offerDetails['offer_title'],
            'offer_description' => $offerDetails['offer_description'],
            'start_date' => $offerDetails['start_date'],
            'end_date' => $offerDetails['end_date'],
            'image_url' => $offerDetails['image_url']
        ];

        // Close the prepared statement
        $stmt->close();

        // Close the database connection
        $conn->close();

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($offerDetailsMapped);
    } else {
        // Offer not found
        echo json_encode(array('status' => 'error', 'message' => 'Offer not found'));
    }
} else {
    // offer_id parameter not provided
    echo json_encode(array('status' => 'error', 'message' => 'Offer ID not provided'));
}
?>