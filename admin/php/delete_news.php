<?php
include ('headers.php');

// admin/php/delete_news.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["news_id"])) {
        // Retrieve data from the form
        $news_id = $_POST['news_id'];

        // Sanitize and validate data (Add your validation logic here)

        // Delete news from the database
        $deleteQuery = "DELETE FROM news WHERE news_id = '$news_id'";

        if ($conn->query($deleteQuery) === TRUE) {
            // Success message
            $response = array('status' => 'success', 'message' => 'News deleted successfully');
        } else {
            // Error message
            $response = array('status' => 'error', 'message' => 'Error deleting news: ' . $conn->error);
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

        // Close the database connection
        $conn->close();
    } else {
        // If the offer ID is not provided, send an error response
        $response = array('status' => 'error', 'message' => 'News ID not provided');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
} else {
    // If the request method is not POST, return an error response
    header('Content-Type: application/json');
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>