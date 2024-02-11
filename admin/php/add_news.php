<?php
// admin/php/add_news.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve news data from the form

    if (isset($_POST["title"]) && isset($_POST["content"]) && isset($_POST["image_url"])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image_url = $_POST['image_url'];

        // Sanitize and validate data (Add your validation logic here)

        // Insert news into the database
        $insertQuery = "INSERT INTO news (title, content, image_url) VALUES ('$title', '$content', '$image_url')";

        if ($conn->query($insertQuery) === TRUE) {
            // Success message
            $response = array('status' => 'success', 'message' => 'News added successfully');
        } else {
            // Error message
            $response = array('status' => 'error', 'message' => 'Error adding news: ' . $conn->error);
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

        // Close the database connection
        $conn->close();
    } else {
        // If the form is not submitted, redirect or handle accordingly
        // (e.g., show an error message, redirect to the form page)
        header("Location: /path/to/news_form.php");
        exit();
    }
}
?>