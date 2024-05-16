<?php
// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require __DIR__ . '/../../vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

include ('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["store_id"]) && isset($_FILES["imageFiles"])) {
    $store_id = $_POST["store_id"];
    $uploadedImages = array();

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

    foreach ($_FILES["imageFiles"]["tmp_name"] as $index => $tmp_name) {
        $image_name = basename($_FILES["imageFiles"]["name"][$index]);

        // Set the blob name
        $blobName = "stores/" . basename($image_name);

        // Upload file as a block blob
        try {
            $content = fopen($tmp_name, "r");
            $options = new CreateBlockBlobOptions();
            $options->setContentType($_FILES['imageFiles']['type'][$index]);

            $blobClient->createBlockBlob($containerName, $blobName, $content, $options);

            // Construct the URL for the uploaded image
            $image_url = "https://ansarportal.blob.core.windows.net/$containerName/$blobName";

            $insertQuery = "INSERT INTO storeimages (store_id, image_url) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $store_id, $image_url);

            if ($stmt->execute()) {
                $uploadedImages[] = array(
                    "image_url" => $image_url,
                    "store_name" => getStoreName($conn, $store_id)
                );
            } else {
                // Error inserting image details
                $response = array('status' => 'error', 'message' => 'Error inserting image details: ' . $stmt->error);

                // Send JSON response
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            }
        } catch (ServiceException $e) {
            // Error uploading file to Azure
            $response = array('status' => 'error', 'message' => $e->getMessage());

            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    // Success message with uploaded images
    $response = array('status' => 'success', 'message' => 'Images uploaded successfully', 'uploadedImages' => $uploadedImages);

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request');

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Function to get store name
function getStoreName($conn, $store_id)
{
    $query = "SELECT store_name FROM stores WHERE store_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["store_name"];
    }

    return '';
}
?>