<?php
require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->load();

// Start or resume the session
session_start();

// Check if the user is not authenticated (not logged in or session timeout)
if (!isset($_SESSION['user_id']) || (time() - $_SESSION['login_time'] > 1800)) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: php/login.php");
    exit();
}

?>

<!-- Your HTML -->
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
                    <li><a href="#" id="viewStoresBtn">View Stores</a></li>
                    <li><a href="#" id="addStoresBtn">Add Store</a></li>
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
                    <li><a id="viewNewsBtn">View News</a></li>
                    <li><a id="addNewsBtn">Add News</a></li>
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
        <h1 id="admin-welcome">Welcome to the Admin Panel</h1>

        <!-- Add an empty list with id "storeList" where the stores will be displayed -->
        <ul id="storeList"></ul>

        <!-- Add Store Form -->
        <div id="addStoreFormContainer">
            <h2>Add Store</h2>
            <form id="addStoreForm" action="#" method="post">
                <label for="store_name">Store Name:</label>
                <input type="text" id="store_name" name="store_name" required>

                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>

                </select>

                <label for="store_description">Store Description:</label>
                <textarea id="store_description" name="store_description" required></textarea>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" required>

                <button type="submit">Add Store</button>
            </form>
        </div>

        <!-- Add an empty list with id "newsList" where the news will be displayed -->
        <ul id="newsList"></ul>

        <!-- Add News Form -->
        <div id="addNewsFormContainer">
            <h2>Add News</h2>
            <form id="addNewsForm" action="#" method="post" enctype="multipart/form-data">
                <label for="title">News Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="content">News Content:</label>
                <textarea id="content" name="content" required></textarea>

                <label for="image">Image File:</label>
                <input type="file" id="image" name="image" accept="image/*" required>

                <button type="submit">Add News</button>
            </form>

        </div>

    </div>

    <!-- Your admin panel content goes here -->

    <script src="js/admin_script.js"></script>
</body>

</html>