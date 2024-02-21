<?php
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve news data from the form
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Handle image upload
    if (isset($_FILES['image'])) {
        $targetDirectory = "../../assets/images/news/";
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);

        // Check if the file was successfully uploaded
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Image uploaded successfully
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload image.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Image not provided.']);
        exit;
    }

    // Add publication_date to the data
    $publication_date = date('Y-m-d'); // Set the current date

    // Insert the news into the database
    $query = "INSERT INTO news (title, content, publication_date, image_url) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssss", $title, $content, $publication_date, $targetFile);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'News added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }

    $conn->close();
} else {
    // If the form is not submitted, redirect or handle accordingly
    // (e.g., show an error message, redirect to the form page)
    exit();
}
?>