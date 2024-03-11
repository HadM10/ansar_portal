<?php
// view_uploaded_images.php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Fetch all uploaded images along with store information from the storeimages and stores tables
    $query = "SELECT si.image_id, si.image_url, si.store_id, s.store_name 
              FROM storeimages si
              JOIN stores s ON si.store_id = s.store_id";

    $result = $conn->query($query);

    if ($result) {
        $imagesData = array();

        while ($row = $result->fetch_assoc()) {
            $imagesData[] = array(
                "image_id" => $row["image_id"],
                "image_url" => $row["image_url"],
                "store_id" => $row["store_id"],
                "store_name" => $row["store_name"]
            );
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($imagesData);
    } else {
        // Error fetching images
        $error_message = 'Error fetching images: ' . $conn->error;

        // Log the error for debugging (you can customize this based on your logging system)
        error_log($error_message);

        // Send a generic error response
        $response = array('status' => 'error', 'message' => 'Error fetching images');

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request');

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>