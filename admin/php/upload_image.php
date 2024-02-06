<?php
// admin/php/upload_image.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $store_id = $_POST['store_id'];

    // Check if the file was uploaded without errors
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "images/"; // Specify the directory where images will be stored
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Check if the file already exists
            if (file_exists($target_file)) {
                // Handle the case when the file already exists (you may want to rename or handle differently)
                $response = array('status' => 'error', 'message' => 'File already exists');
            } else {
                // Move the uploaded file to the specified directory
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Insert image into the database
                    $insertQuery = "INSERT INTO images (store_id, image_url) VALUES ('$store_id', '$target_file')";

                    if ($conn->query($insertQuery) === TRUE) {
                        // Success message
                        $response = array('status' => 'success', 'message' => 'Image uploaded successfully');
                    } else {
                        // Error message
                        $response = array('status' => 'error', 'message' => 'Error uploading image: ' . $conn->error);
                    }
                } else {
                    // Error moving file
                    $response = array('status' => 'error', 'message' => 'Error moving file');
                }
            }
        } else {
            // Not an image
            $response = array('status' => 'error', 'message' => 'File is not an image');
        }
    } else {
        // File upload error
        $response = array('status' => 'error', 'message' => 'Error uploading file');
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect or handle accordingly
    // (e.g., show an error message, redirect to the form page)
    header("Location: /path/to/image_upload_form.php");
    exit();
}
?>