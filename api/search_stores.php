<?php
// admin/php/search_stores.php
include ('db_connection.php');

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Check if search query parameter exists
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Prepare the SQL query to search for stores
    $searchQuery = "SELECT s.store_id, s.store_name, s.category_id, s.store_description, s.phone_number, s.total_likes, GROUP_CONCAT(i.image_url) as images
                    FROM stores s
                    LEFT JOIN storeimages i ON s.store_id = i.store_id
                    WHERE s.store_name LIKE '%$query%'
                    OR s.store_description LIKE '%$query%'
                    OR s.category_id IN (
                        SELECT category_id FROM categories WHERE category_name LIKE '%$query%'
                    )
                    GROUP BY s.store_id";

    $result = $conn->query($searchQuery);

    $stores = array();

    while ($row = $result->fetch_assoc()) {
        $stores[] = array(
            "store_id" => $row["store_id"],
            "store_name" => $row["store_name"],
            "category" => $row["category_id"],
            "description" => $row["store_description"],
            "phone_number" => $row["phone_number"],
            "total_likes" => $row["total_likes"],
            "images" => explode(",", $row["images"]) // Convert comma-separated images to an array
        );
    }

    // Return JSON response with search results
    header('Content-Type: application/json');
    echo json_encode($stores);
} else {
    // If no search query parameter is provided
    echo "No search query provided.";
}
$conn->close();
?>