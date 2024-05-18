<?php
include ('headers.php');

require __DIR__ . '/../../vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

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

            // Retrieve the Azure Storage account connection string from environment variables
            $connectionString = getenv('AZURE_STORAGE_CONNECTION_STRING');
            if (!$connectionString) {
                echo json_encode(["status" => "error", "message" => "Azure Storage connection string is not set."]);
                exit;
            }

            // Create blob client.
            $blobClient = BlobRestProxy::createBlobService($connectionString);

            // Set the container name
            $containerName = "images"; // Make sure this container exists in your Azure storage

            // Set the blob name
            $blobName = "offers/" . basename($image_name);

            // Upload file as a block blob
            try {
                $content = fopen($image_tmp_name, "r");
                $options = new CreateBlockBlobOptions();
                $options->setContentType($_FILES['image_url']['type']);

                $blobClient->createBlockBlob($containerName, $blobName, $content, $options);

                // Construct the URL for the uploaded image
                $imageUrl = "https://ansarportal.blob.core.windows.net/$containerName/$blobName";

                // Insert special offer into the database
                $insertQuery = "INSERT INTO offers (store_id, offer_title, offer_description, start_date, end_date, image_url) 
                            VALUES (?, ?, ?, ?, ?, ?)";

                if ($stmt = $conn->prepare($insertQuery)) {
                    $stmt->bind_param("isssss", $store_id, $offer_title, $offer_description, $startDate, $endDate, $imageUrl);
                    if ($stmt->execute()) {
                        // Success message
                        $response = array('status' => 'success', 'message' => 'Special offer added successfully');
                    } else {
                        // Error message
                        $response = array('status' => 'error', 'message' => 'Error adding special offer: ' . $stmt->error);
                    }
                } else {
                    // Error message
                    $response = array('status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error);
                }
            } catch (ServiceException $e) {
                $response = array('status' => 'error', 'message' => $e->getMessage());
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