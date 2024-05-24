<?php
include ('headers.php');

require __DIR__ . '/../../vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

include ('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
    // Retrieve news data from the form
    $title = $_POST['title'];
    $news_content = $_POST['content'];
    $publication_date = date('Y-m-d'); // Set the current date

    $image_name = basename($_FILES['image']['name']);
    $image_tmp_path = $_FILES['image']['tmp_name'];

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
    $blobName = "news/" . basename($image_name);

    // Upload file as a block blob
    try {
        $content = fopen($image_tmp_path, "r");
        $options = new CreateBlockBlobOptions();
        $options->setContentType($_FILES['image']['type']);

        $blobClient->createBlockBlob($containerName, $blobName, $content, $options);

        // Construct the URL for the uploaded image
        $imageUrl = "https://ansarportal.blob.core.windows.net/$containerName/$blobName";

        // Insert the news into the database with the correct image path
        $query = "INSERT INTO news (title, content, publication_date, image_url) VALUES (?, ?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssss", $title, $news_content, $publication_date, $imageUrl);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'News added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => $conn->error]);
        }
    } catch (ServiceException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $conn->close();
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>