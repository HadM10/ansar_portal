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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["category_name"]) && isset($_FILES['category_image'])) {
        $categoryName = $_POST['category_name'];
        $categoryImage = $_FILES['category_image']['name'];
        $categoryImageTmpPath = $_FILES['category_image']['tmp_name'];

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
        $blobName = "categories/" . basename($categoryImage);

        // Upload file as a block blob
        try {
            $content = fopen($categoryImageTmpPath, "r");
            $options = new CreateBlockBlobOptions();
            $options->setContentType($_FILES['category_image']['type']);

            $blobClient->createBlockBlob($containerName, $blobName, $content, $options);

            // Construct the URL for the uploaded image
            $imageUrl = "https://ansarportal.blob.core.windows.net/$containerName/$blobName";

            // Insert the new category into the database with the correct image path
            $insertQuery = "INSERT INTO categories (category_name, category_image) VALUES (?, ?)";
            if ($stmt = $conn->prepare($insertQuery)) {
                $stmt->bind_param("ss", $categoryName, $imageUrl);
                if ($stmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "Category added successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => $stmt->error]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => $conn->error]);
            }
        } catch (ServiceException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing category_name or category_image"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

$conn->close();
?>