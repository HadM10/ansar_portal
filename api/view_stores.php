<?php
// admin/php/view_stores.php
include ('db_connection.php');

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Retrieve stores with associated images and categories
$selectQuery = "SELECT s.store_id, s.store_name, s.category_id, s.store_description, s.phone_number, s.total_likes, GROUP_CONCAT(i.image_url) as images, GROUP_CONCAT(c.category_name) as categories
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
        "category" => $row["category_id"],
        "description" => $row["store_description"],
        "phone_number" => $row["phone_number"],
        "total_likes" => $row["total_likes"],
        "images" => explode(",", $row["images"]), // Convert comma-separated images to an array
        "categories" => explode(",", $row["categories"]) // Convert comma-separated categories to an array
    );
}

header('Content-Type: application/json');
echo json_encode($stores);
$conn->close();
?>