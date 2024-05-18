<?php
// admin/php/view_stores.php
include ('db_connection.php');

include ('headers.php');

// Retrieve stores with associated images and category names
$selectQuery = "SELECT s.store_id, s.store_name, c.category_name, s.store_description, s.phone_number, s.total_likes, s.tiktok_url, s.facebook_url, s.whatsapp_number, s.instagram_url, s.location, s.archived, GROUP_CONCAT(i.image_url) as images
                FROM stores s
                LEFT JOIN storeimages i ON s.store_id = i.store_id
                LEFT JOIN categories c ON s.category_id = c.category_id
                GROUP BY s.store_id";
$result = $conn->query($selectQuery);

$stores = array();

while ($row = $result->fetch_assoc()) {
    $stores[] = array(
        "store_id" => $row["store_id"],
        "store_name" => $row["store_name"],
        "categories" => array($row["category_name"]), // Change field name to "categories" and wrap the category name in an array
        "description" => $row["store_description"],
        "phone_number" => $row["phone_number"],
        "total_likes" => $row["total_likes"],
        "tiktok_url" => $row["tiktok_url"],
        "facebook_url" => $row["facebook_url"],
        "whatsapp_number" => $row["whatsapp_number"],
        "instagram_url" => $row["instagram_url"],
        "location" => $row["location"],
        "archived" => (bool) $row["archived"],
        "images" => explode(",", $row["images"])
    );
}


header('Content-Type: application/json');
echo json_encode($stores);
$conn->close();

?>