<?php
// admin/php/store_details.php
include ('db_connection.php');

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Check if store_id is provided in the request
if (isset($_GET['store_id'])) {
    $storeId = $_GET['store_id'];
    // Retrieve store details with associated category name, images, and social media URLs
    $selectQuery = "SELECT s.store_id, s.store_name, c.category_name, s.store_description, s.phone_number, s.total_likes, GROUP_CONCAT(i.image_url) as images,
                    s.facebook_url, s.instagram_url, s.whatsapp_number, s.tiktok_url, s.location
                    FROM stores s
                    LEFT JOIN storeimages i ON s.store_id = i.store_id
                    LEFT JOIN categories c ON s.category_id = c.category_id
                    WHERE s.store_id = $storeId
                    GROUP BY s.store_id";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storeDetails = array(
            "store_id" => $row["store_id"],
            "store_name" => $row["store_name"],
            "category_name" => $row["category_name"],
            "description" => $row["store_description"],
            "phone_number" => $row["phone_number"],
            "total_likes" => $row["total_likes"],
            "images" => explode(",", $row["images"]), // Convert comma-separated images to an array
            "facebook_url" => $row["facebook_url"],
            "instagram_url" => $row["instagram_url"],
            "whatsapp_number" => $row["whatsapp_number"],
            "tiktok_url" => $row["tiktok_url"],
            "location" => $row["location"]
        );
        header('Content-Type: application/json');
        echo json_encode($storeDetails);
    } else {
        echo json_encode(array("error" => "Store not found"));
    }
} else {
    echo json_encode(array("error" => "Store ID is required"));
}

$conn->close();
?>