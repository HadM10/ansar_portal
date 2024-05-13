<?php
// admin/php/add_special_offer.php
include ('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["store_id"]) && isset($_POST["offer_title"]) && isset($_POST["offer_description"]) && isset($_POST["start_date"]) && isset($_POST["end_date"])) {
        // Retrieve offer data from the form
        $store_id = $_POST['store_id'];
        $offer_title = $_POST['offer_title'];
        $offer_description = $_POST['offer_description'];
        $startDate = date('Y-m-d', strtotime($_POST['start_date']));
        $endDate = date('Y-m-d', strtotime($_POST['end_date']));

        // Handle file upload
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image_url']['tmp_name'];
            $image_name = basename($_FILES['image_url']['name']);

            // Set the desired upload directory
            $upload_dir = 'https://ansarportal-deaa9ded50c7.herokuapp.com/assets/images/offers/';
            $upload_path = $upload_dir . $image_name;

            if (move_uploaded_file($image_tmp_name, $upload_path)) {
                // File upload successful, insert into the database
                $image_url = 'https://ansarportal-deaa9ded50c7.herokuapp.com/assets/images/offers/' . $image_name;

                // Insert special offer into the database
                $insertQuery = "INSERT INTO offers (store_id, offer_title, offer_description, start_date, end_date, image_url) 
                            VALUES ('$store_id', '$offer_title', '$offer_description', '$startDate', '$endDate', '$image_url')";

                if ($conn->query($insertQuery) === TRUE) {
                    // Success message
                    $response = array('status' => 'success', 'message' => 'Special offer added successfully');
                } else {
                    // Error message
                    $response = array('status' => 'error', 'message' => 'Error adding special offer: ' . $conn->error);
                }
            } else {
                // Error moving the uploaded file
                $response = array('status' => 'error', 'message' => 'Error moving uploaded file');
            }
        } else {
            // File upload error or no file selected
            $response = array('status' => 'error', 'message' => 'Error uploading file or no file selected');
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