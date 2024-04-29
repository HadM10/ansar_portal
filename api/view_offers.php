<?php
// admin/php/view_offers.php
include ('db_connection.php');

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Retrieve special offers information from the database
$selectQuery = "SELECT o.offer_id, o.store_id, o.offer_title, o.offer_description, o.start_date, o.end_date, o.image_url, s.store_name
                FROM offers o
                INNER JOIN stores s ON o.store_id = s.store_id";
$result = $conn->query($selectQuery);

$offers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offers[] = array(
            "offer_id" => $row["offer_id"],
            "store_name" => $row["store_name"], // Change to store name
            "offer_title" => $row["offer_title"],
            "offer_description" => $row["offer_description"],
            "start_date" => $row["start_date"], // Include start date
            "end_date" => $row["end_date"], // Include end date
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