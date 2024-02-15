<?php
// admin/php/view_offers.php
include('db_connection.php');

// Retrieve special offers information from the database
$selectQuery = "SELECT store_id, offer_title, offer_description, start_date, end_date, image_url
                FROM offers";
$result = $conn->query($selectQuery);

$offers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offers[] = array(
            "store_id" => $row["store_id"],
            "offer_title" => $row["offer_title"],
            "offer_description" => $row["offer_description"],
            "start_date" => $row["start_date"],
            "end_date" => $row["end_date"],
            "image_url" => $row["image_url"]
        );
    }
}

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($offers);
?>