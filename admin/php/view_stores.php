<?php
// admin/php/view_stores.php
include ('db_connection.php');

// Retrieve stores with associated images
$selectQuery = "SELECT s.store_id, s.store_name, s.category_id, s.store_description, s.phone_number, s.total_likes, s.tiktok_url, s.facebook_url, s.whatsapp_number, s.instagram_url, s.location, GROUP_CONCAT(i.image_url) as images
                FROM stores s
                LEFT JOIN storeimages i ON s.store_id = i.store_id
                GROUP BY s.store_id";
$result = $conn->query($selectQuery);

$stores = array();

while ($row = $result->fetch_assoc()) {
    $stores[] = array(
        "store_id" => $row["store_id"],
        "store_name" => $row["store_name"],
        "category" => $row["category_id"],
        "description" => $row["store_description"],
        "phone_number" => $row["phone_number"],
        "total_likes" => $row["total_likes"],
        "tiktok_url" => $row["tiktok_url"],
        "facebook_url" => $row["facebook_url"],
        "whatsapp_number" => $row["whatsapp_number"],
        "instagram_url" => $row["instagram_url"],
        "location" => $row["location"],
        "images" => explode(",", $row["images"]) // Convert comma-separated images to an array
    );
}

header('Content-Type: application/json');
echo json_encode($stores);
$conn->close();
?>