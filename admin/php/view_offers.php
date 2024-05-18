<?php
include ('headers.php');

// admin/php/view_offers.php
include ('db_connection.php');

// Retrieve special offers information from the database
$selectQuery = "SELECT o.offer_id, o.store_id, o.offer_title, o.offer_description, o.start_date, o.end_date, o.image_url, s.store_name
                FROM offers o
                JOIN stores s ON o.store_id = s.store_id";
$result = $conn->query($selectQuery);

$offers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $start_date = date('d-m-Y', strtotime($row["start_date"]));
        $end_date = date('d-m-Y', strtotime($row["end_date"]));

        // Check if the end date is today's date
        $today_date = date('d-m-Y');
        if ($end_date == $today_date) {
            // Delete the offer from the database
            $offer_id = $row["offer_id"];
            $deleteQuery = "DELETE FROM offers WHERE offer_id = $offer_id";
            $conn->query($deleteQuery);
        } else {
            $offers[] = array(
                "offer_id" => $row["offer_id"],
                "store_id" => $row["store_id"],
                "store_name" => $row["store_name"], // Include store name
                "offer_title" => $row["offer_title"],
                "offer_description" => $row["offer_description"],
                "start_date" => $start_date,
                "end_date" => $end_date,
                "image_url" => $row["image_url"]
            );
        }
    }
}

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($offers);
?>