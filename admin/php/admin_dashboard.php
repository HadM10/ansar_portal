<?php

// Add CORS headers
header("Access-Control-Allow-Origin: *"); // Replace * with your allowed origins
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// admin/php/admin_dashboard.php
include ('db_connection.php');

// Retrieve total number of stores
$totalStoresQuery = "SELECT COUNT(*) as total_stores FROM stores";
$totalStoresResult = $conn->query($totalStoresQuery);
$totalStores = $totalStoresResult->fetch_assoc()['total_stores'];

// Retrieve total number of special offers
$totalOffersQuery = "SELECT COUNT(*) as total_offers FROM offers";
$totalOffersResult = $conn->query($totalOffersQuery);
$totalOffers = $totalOffersResult->fetch_assoc()['total_offers'];

// Retrieve total number of payments
$totalPaymentsQuery = "SELECT COUNT(*) as total_payments FROM payments";
$totalPaymentsResult = $conn->query($totalPaymentsQuery);
$totalPayments = $totalPaymentsResult->fetch_assoc()['total_payments'];

// Retrieve total number of users
$totalUsersQuery = "SELECT COUNT(*) as total_users FROM useraccounts";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];

// Retrieve total number of news
$totalNewsQuery = "SELECT COUNT(*) as total_news FROM news";
$totalNewsResult = $conn->query($totalNewsQuery);
$totalNews = $totalNewsResult->fetch_assoc()['total_news'];

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode(
    array(
        "total_stores" => $totalStores,
        "total_offers" => $totalOffers,
        "total_payments" => $totalPayments,
        "total_users" => $totalUsers,
        "total_news" => $totalNews
    )
);
?>