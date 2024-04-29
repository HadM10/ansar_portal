<?php
// fetch_user_likes.php
include ('db_connection.php');

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];

    // Query to fetch liked stores for the user
    $query = "SELECT store_id FROM userlikes WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $liked_stores = [];
        while ($row = $result->fetch_assoc()) {
            $liked_stores[] = $row['store_id'];
        }
        $response = array('status' => 'success', 'liked_stores' => $liked_stores);
    } else {
        // No liked stores found for the user
        $response = array('status' => 'success', 'liked_stores' => []);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request');

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>