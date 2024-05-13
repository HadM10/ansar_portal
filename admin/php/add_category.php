<?php
// admin/php/add_category.php
include ('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive category data including the image file from the request
    if (isset($_POST["category_name"]) && isset($_FILES['category_image'])) {
        $categoryName = $_POST['category_name'];
        $categoryImage = $_FILES['category_image']['name'];

        // Move the uploaded image file to a desired location (you may want to add error handling)
        $targetDirectory = "../../assets/images/categories/";
        $uploadPath = $targetDirectory . $categoryImage;
        move_uploaded_file($_FILES['category_image']['tmp_name'], $uploadPath);

        // Construct the URL for the uploaded image
        $baseUrl = "https://ansarportal-deaa9ded50c7.herokuapp.com/";
        $imageRelativePath = str_replace("../../", "", $uploadPath);
        $imageUrl = $baseUrl . $imageRelativePath;

        // Insert the new category into the database with the correct image path
        $insertQuery = "INSERT INTO categories (category_name, category_image) VALUES (?, ?)";
        if ($stmt = $conn->prepare($insertQuery)) {
            $stmt->bind_param("ss", $categoryName, $imageUrl);
            if ($stmt->execute()) {
                // Respond with success message
                echo json_encode(["status" => "success", "message" => "Category added successfully"]);
            } else {
                // Respond with database error message
                echo json_encode(["status" => "error", "message" => $stmt->error]);
            }
        } else {
            // Respond with database error message
            echo json_encode(["status" => "error", "message" => $conn->error]);
        }
    } else {
        // Respond with error message for missing category_name or category_image
        echo json_encode(["status" => "error", "message" => "Missing category_name or category_image"]);
    }
} else {
    // Respond with error for invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>