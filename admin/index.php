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
                </ul>
            </li>
            <li><a href="#">Categories</a>
                <ul>
                    <li><a href="#" id="viewCategoriesBtn">View Categories</a></li>
                    <li><a href="#" id="addCategoriesBtn">Add Category</a></li>
                </ul>
            </li>
            <li><a href="#">Special Offers</a>
                <ul>
                    <li><a href="#" id="viewOffersBtn">View Special Offers</a></li>
                    <li><a href="#" id="addOffersBtn">Add Special Offer</a></li>
                </ul>
            </li>
            <li><a href="#">News</a>
                <ul>
                    <li><a href="#" id="viewNewsBtn">View News</a></li>
                    <li><a href="#" id="addNewsBtn">Add News</a></li>
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
                    <li><a href="#" id="viewImagesBtn">View Images</a></li>
                    <li><a href="#" id="uploadImagesLink">Upload Image</a></li>
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

        <!-- Add an empty list with id "categoryList" where the categories will be displayed -->
        <ul id="categoryList"></ul>

        <!-- Add Category Form -->
        <div id="addCategoryFormContainer">
            <h2>Add Category</h2>
            <form id="addCategoryForm" action="#" method="post" enctype="multipart/form-data">
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" required>

                <label for="category_image">Category Image:</label>
                <input type="file" id="category_image" name="category_image" accept="image/*" required>

                <button type="submit">Add Category</button>
            </form>
        </div>

        <ul id="offerList"></ul>

        <!-- Add Offer Form -->
        <div id="addOfferFormContainer">
            <h2>Add Offer</h2>
            <form id="addOfferForm" action="#" method="post" enctype="multipart/form-data">
                <!-- Other fields... -->
                <label for="store_id">Select Store:</label>
                <select id="store_id" name="store_id" required>
                    <!-- Options will be dynamically added using JavaScript -->
                </select>

                <label for="offer_title">Offer Title:</label>
                <input type="text" id="offer_title" name="offer_title" required>

                <label for="offer_description">Offer Description:</label>
                <textarea id="offer_description" name="offer_description" required></textarea>

                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <label for="image_url">Image:</label>
                <input type="file" id="image_url" name="image_url" accept="image/*" required>

                <button type="submit">Add Offer</button>
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

        <!-- Upload image -->

        <form id="uploadImagesForm" enctype="multipart/form-data" method="post">
            <div>
                <label for="storeSelect">Select Store:</label>
                <select id="storeSelect" required></select>
            </div>

            <div>
                <label for="imageFiles">Upload Images:</label>
                <input type="file" id="imageFiles" name="imageFiles[]" multiple accept="image/*" required>
            </div>

            <button type="submit" id="uploadImagesBtn">Upload Images</button>
        </form>
        <ul id="uploadedImagesList"></ul>


    </div>

    <!-- Your admin panel content goes here -->

    <script src="js/admin_script.js"></script>
</body>

</html>