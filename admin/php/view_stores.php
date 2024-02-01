<?php
// admin/php/view_stores.php
include('db_connection.php');

// Retrieve stores with associated images
$selectQuery = "SELECT s.store_id, s.store_name, s.category, s.description, GROUP_CONCAT(i.image_url) as images
                FROM stores s
                LEFT JOIN images i ON s.store_id = i.store_id
                GROUP BY s.store_id";
$result = $conn->query($selectQuery);

$stores = array();

while ($row = $result->fetch_assoc()) {
    $stores[] = array(
        "store_id" => $row["store_id"],
        "store_name" => $row["store_name"],
        "category" => $row["category"],
        "description" => $row["description"],
        "images" => explode(",", $row["images"]) // Convert comma-separated images to an array
    );
}

echo json_encode($stores);
$conn->close();
?>