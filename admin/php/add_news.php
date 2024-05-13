<?php
// news_upload.php
include ('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    // Handle image upload
    $targetDirectory = "../../assets/images/news/";
    $image_name = basename($_FILES['image']['name']);
    $upload_path = $targetDirectory . $image_name;
    $image_url = 'https://ansarportal-deaa9ded50c7.herokuapp.com/assets/images/news/' . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
        // Image uploaded successfully
        // Retrieve news data from the form
        $title = $_POST['title'];
        $content = $_POST['content'];
        $publication_date = date('Y-m-d'); // Set the current date

        // Insert the news into the database
        $query = "INSERT INTO news (title, content, publication_date, image_url) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssss", $title, $content, $publication_date, $image_url);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'News added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
    }

    $conn->close();
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

?>