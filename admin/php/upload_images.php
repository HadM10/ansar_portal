<?php
// upload_images.php
include ('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["store_id"]) && isset($_FILES["imageFiles"])) {
    $store_id = $_POST["store_id"];
    $uploadedImages = array();

    foreach ($_FILES["imageFiles"]["tmp_name"] as $index => $tmp_name) {
        $image_name = basename($_FILES["imageFiles"]["name"][$index]);
        $targetDirectory = "../../assets/images/stores/";
        $uploadPath = $targetDirectory . $image_name;

        // Construct the URL for the uploaded image
        $baseUrl = "https://ansarportal-deaa9ded50c7.herokuapp.com/";
        $imageRelativePath = str_replace("../../", "", $uploadPath);
        $image_url = $baseUrl . $imageRelativePath;

        if (move_uploaded_file($tmp_name, $uploadPath)) {
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
        } else {
            // Error moving the uploaded file
            $response = array('status' => 'error', 'message' => 'Error moving uploaded file');

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
    $query = "SELECT store_name FROM stores WHERE store_id = '$store_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["store_name"];
    }

    return '';
}
?>