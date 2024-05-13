<?php
// admin/php/edit_news.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $news_id = $_POST['news_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url'];

    // Sanitize and validate data (Add your validation logic here)

    // Update news in the database
    $updateQuery = "UPDATE news SET title = '$title', content = '$content', image_url = '$image_url' WHERE news_id = '$news_id'";

    if ($conn->query($updateQuery) === TRUE) {
        // Success message
        $response = array('status' => 'success', 'message' => 'News updated successfully');
    } else {
        // Error message
        $response = array('status' => 'error', 'message' => 'Error updating news: ' . $conn->error);
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect or handle accordingly
    exit();
}
?>