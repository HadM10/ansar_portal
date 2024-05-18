<?php
// like_store.php
include ('db_connection.php');
include ('headers.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"]) && isset($_POST["store_id"]) && isset($_POST["action"])) {
    $user_id = $_POST["user_id"];
    $store_id = $_POST["store_id"];
    $action = $_POST["action"]; // Action: 'like' or 'unlike'

    if ($action === 'like') {
        // Insert like into userlikes table if not already liked
        $checkQuery = "SELECT * FROM userlikes WHERE user_id = ? AND store_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ss", $user_id, $store_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // User hasn't liked the store yet, so insert like
            $insertQuery = "INSERT INTO userlikes (user_id, store_id) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $user_id, $store_id);

            if ($stmt->execute()) {
                // Increment total likes count in stores table
                $updateQuery = "UPDATE stores SET total_likes = total_likes + 1 WHERE store_id = ?";
                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param("s", $store_id);
                $stmt->execute();

                $response = array('status' => 'success', 'message' => 'Store liked successfully');
            } else {
                $response = array('status' => 'error', 'message' => 'Error liking store: ' . $stmt->error);
            }
        } else {
            $response = array('status' => 'error', 'message' => 'User has already liked the store');
        }
    } elseif ($action === 'unlike') {
        // Remove like from userlikes table if already liked
        $deleteQuery = "DELETE FROM userlikes WHERE user_id = ? AND store_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("ss", $user_id, $store_id);

        if ($stmt->execute()) {
            // Decrement total likes count in stores table
            $updateQuery = "UPDATE stores SET total_likes = total_likes - 1 WHERE store_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("s", $store_id);
            $stmt->execute();

            $response = array('status' => 'success', 'message' => 'Store unliked successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Error unliking store: ' . $stmt->error);
        }
    } else {
        // Invalid action
        $response = array('status' => 'error', 'message' => 'Invalid action');
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