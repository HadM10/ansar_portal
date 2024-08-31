<?php
// admin/php/store_details.php
include('db_connection.php');
include('headers.php');

// Check if store_id is provided in the request
if (isset($_GET['store_id'])) {
    $storeId = $_GET['store_id'];

    // Increase GROUP_CONCAT max length for the session
    $conn->query("SET SESSION group_concat_max_len = 1000000");

    // Retrieve store details with associated category name, images, and social media URLs
    $selectQuery = "
        SELECT 
            s.store_id, 
            s.store_name, 
            c.category_name, 
            s.store_description, 
            s.phone_number, 
            s.total_likes, 
            GROUP_CONCAT(i.image_url SEPARATOR ',') as images,
            s.facebook_url, 
            s.instagram_url, 
            s.whatsapp_number, 
            s.tiktok_url, 
            s.location
        FROM stores s
        LEFT JOIN storeimages i ON s.store_id = i.store_id
        LEFT JOIN categories c ON s.category_id = c.category_id
        WHERE s.store_id = $storeId
        GROUP BY s.store_id
    ";

    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Convert comma-separated images to an array
        $imagesArray = explode(",", $row["images"]);

        // Format the images array (optional, if you want to check contents)
        $imagesArray = array_map('trim', $imagesArray); // Trim any extra spaces

        $storeDetails = array(
            "store_id" => $row["store_id"],
            "store_name" => $row["store_name"],
            "category_name" => $row["category_name"],
            "description" => $row["store_description"],
            "phone_number" => $row["phone_number"],
            "total_likes" => $row["total_likes"],
            "images" => $imagesArray, // Converted image URLs
            "facebook_url" => $row["facebook_url"],
            "instagram_url" => $row["instagram_url"],
            "whatsapp_number" => $row["whatsapp_number"],
            "tiktok_url" => $row["tiktok_url"],
            "location" => $row["location"]
        );

        header('Content-Type: application/json');
        echo json_encode($storeDetails, JSON_PRETTY_PRINT); // Pretty print for better readability
    } else {
        echo json_encode(array("error" => "Store not found"));
    }
} else {
    echo json_encode(array("error" => "Store ID is required"));
}

$conn->close();
?>