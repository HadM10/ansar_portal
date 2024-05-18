<?php
include ('headers.php');

// Include database connection
include ('db_connection.php');

// Function to handle payment submission
function submitPayment($conn, $store_id, $payment_date)
{
    // Validate input data
    if (empty($store_id) || empty($payment_date)) {
        return "Please provide all required fields.";
    }

    // Set constant amount
    $amount = 10;

    // SQL query to insert payment into payments table
    $sql = "INSERT INTO payments (store_id, amount, payment_date) VALUES ('$store_id', '$amount', '$payment_date')";

    if ($conn->query($sql) === TRUE) {
        return "Payment submitted successfully.";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $store_id = $_POST["store_id"];
    $payment_date = $_POST["payment_date"];

    // Submit payment
    $result = submitPayment($conn, $store_id, $payment_date);

    // Output result
    echo $result;
} else {
    echo "Invalid request."; // Handle if request method is not POST
}

// Close database connection
$conn->close();
?>