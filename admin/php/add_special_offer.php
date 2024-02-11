<?php
// admin/php/add_special_offer.php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["store_id"]) && isset($_POST["offer_title"]) && isset($_POST["offer_description"]) && isset($_POST["start_date"]) && isset($_POST["end_date"]) && isset($_POST["image_url"])) {
        // Retrieve offer data from the form
        $store_id = $_POST['store_id'];
        $offer_title = $_POST['offer_title'];
        $offer_description = $_POST['offer_description'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $image_url = $_POST['image_url'];

        // Sanitize and validate data (Add your validation logic here)

        // Insert special offer into the database
        $insertQuery = "INSERT INTO offers (store_id, offer_title, offer_description, start_date, end_date, image_url) 
                    VALUES ('$store_id', '$offer_title', '$offer_description', '$start_date', '$end_date', '$image_url')";

        if ($conn->query($insertQuery) === TRUE) {
            // Success message
            $response = array('status' => 'success', 'message' => 'Special offer added successfully');
        } else {
            // Error message
            $response = array('status' => 'error', 'message' => 'Error adding special offer: ' . $conn->error);
        }

        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);

        // Close the database connection
        $conn->close();
    } else {
        // If the form is not submitted, redirect or handle accordingly
        // (e.g., show an error message, redirect to the form page)
        // header("Location: /path/to/special_offer_form.php");
        exit();
    }
}
?>