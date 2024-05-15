<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/edit_special_offer.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["offer_id"]) && isset($_POST["store_id"]) && isset($_POST["offer_title"]) && isset($_POST["offer_description"]) && isset($_POST["start_date"]) && isset($_POST["end_date"])) {
        // Retrieve offer data from the form
        $offer_id = $_POST['offer_id'];
        $storeId = $_POST["store_id"];
        $offer_title = $_POST['offer_title'];
        $offer_description = $_POST['offer_description'];
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));

        // Check if an image file is uploaded
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image_file']['tmp_name'];
            $image_name = basename($_FILES['image_file']['name']);

            // Set the desired upload directory
            $targetDirectory = "../../assets/images/offers/";
            $uploadPath = $targetDirectory . $image_name;

            if (move_uploaded_file($image_tmp_name, $uploadPath)) {
                // Construct the URL for the uploaded image
                $baseUrl = "https://ansarportal-deaa9ded50c7.herokuapp.com/";
                $imageRelativePath = str_replace("../../", "", $uploadPath);
                $imageUrl = $baseUrl . $imageRelativePath;

                // Update special offer in the database with the new image URL
                $updateQuery = "UPDATE offers SET store_id = ?, offer_title = ?, offer_description = ?, start_date = ?, end_date = ?, image_url = ? WHERE offer_id = ?";

                if ($stmt = $conn->prepare($updateQuery)) {
                    $stmt->bind_param("isssssi", $storeId, $offer_title, $offer_description, $start_date, $end_date, $imageUrl, $offer_id);
                    if ($stmt->execute()) {
                        // Success message
                        $response = array('status' => 'success', 'message' => 'Special offer updated successfully');
                    } else {
                        // Error message
                        $response = array('status' => 'error', 'message' => 'Error updating special offer: ' . $stmt->error);
                    }
                } else {
                    // Error message
                    $response = array('status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error);
                }
            } else {
                // Error moving the uploaded file
                $response = array('status' => 'error', 'message' => 'Error moving uploaded file');
            }
        } else {
            // No new image file uploaded, update other fields in the database
            $updateQuery = "UPDATE offers SET store_id = ?, offer_title = ?, offer_description = ?, start_date = ?, end_date = ? WHERE offer_id = ?";

            if ($stmt = $conn->prepare($updateQuery)) {
                $stmt->bind_param("issssi", $storeId, $offer_title, $offer_description, $start_date, $end_date, $offer_id);
                if ($stmt->execute()) {
                    // Success message
                    $response = array('status' => 'success', 'message' => 'Special offer updated successfully');
                } else {
                    // Error message
                    $response = array('status' => 'error', 'message' => 'Error updating special offer: ' . $stmt->error);
                }
            } else {
                // Error message
                $response = array('status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error);
            }
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

        // Close the database connection
        $conn->close();
    } else {
        // If the form is not submitted correctly, handle accordingly
        $response = array('status' => 'error', 'message' => 'Invalid form data');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
?>