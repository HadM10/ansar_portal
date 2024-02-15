<?php
require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->load();

// Start or resume the session
session_start();

// Check if the user is not authenticated (not logged in)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: html/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Ansar Portal</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <aside class="sidebar">
        <h1>Admin Panel</h1>
        <ul>
            <li><a href="#">Stores</a>
                <ul>
                    <li><a href="../admin/php/view_stores.php">View Stores</a></li>
                    <li><a href="../admin/php/add_store.php">Add Store</a></li>
                    <li><a href="../admin/php/delete_store.php">Delete Store</a></li>
                    <li><a href="../admin/php/edit_store.php">Edit Store</a></li>
                </ul>
            </li>
            <li><a href="#">Categories</a>
                <ul>
                    <li><a href="../admin/php/view_categories.php">View Categories</a></li>
                    <li><a href="../admin/php/add_category.php">Add Category</a></li>
                    <li><a href="../admin/php/delete_category.php">Delete Category</a></li>
                    <li><a href="../admin/php/edit_category.php">Edit Category</a></li>
                </ul>
            </li>
            <li><a href="#">Special Offers</a>
                <ul>
                    <li><a href="../admin/php/view_special_offers.php">View Special Offers</a></li>
                    <li><a href="../admin/php/add_special_offer.php">Add Special Offer</a></li>
                    <li><a href="../admin/php/delete_special_offer.php">Delete Special Offer</a></li>
                    <li><a href="../admin/php/edit_special_offer.php">Edit Special Offer</a></li>
                </ul>
            </li>
            <li><a href="#">News</a>
                <ul>
                    <li><a href="../admin/php/view_news.php">View News</a></li>
                    <li><a href="../admin/php/add_news.php">Add News</a></li>
                    <li><a href="../admin/php/delete_news.php">Delete News</a></li>
                    <li><a href="../admin/php/edit_news.php">Edit News</a></li>
                </ul>
            </li>
            <li><a href="#">Users</a>
                <ul>
                    <li><a href="../admin/php/view_users.php">View Users</a></li>
                    <li><a href="../admin/php/view_user_likes.php">View User Likes</a></li>
                </ul>
            </li>
            <li><a href="#">Payments</a>
                <ul>
                    <li><a href="../admin/php/view_payments.php">View Payments</a></li>
                </ul>
            </li>
            <li><a href="#">Images</a>
                <ul>
                    <li><a href="../admin/php/upload_image.php">Upload Image</a></li>
                    <li><a href="../admin/php/delete_image.php">Delete Image</a></li>
                </ul>
            </li>
            <li><a href="#" id="logoutBtn">Logout</a></li>
        </ul>
    </aside>

    <div class="content">
        <!-- Your admin panel content goes here -->
        <h1>Welcome to the Admin Panel</h1>
    </div>

    <script src="js/admin_script.js"></script>
</body>

</html>