<?php
// admin/php/view_news.php
include('db_connection.php');

// Retrieve all news items from the database
$selectQuery = "SELECT * FROM news";
$result = $conn->query($selectQuery);

$newsItems = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $newsItems[] = array(
            "news_id" => $row["news_id"],
            "title" => $row["title"],
            "content" => $row["content"],
            "image_url" => $row["image_url"]
        );
    }
}

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($newsItems);
?>