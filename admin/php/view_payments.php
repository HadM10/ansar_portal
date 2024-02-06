<?php
// admin/php/view_payments.php
include('db_connection.php');

// Retrieve payment information from the database
$selectQuery = "SELECT store_id, amount, payment_date
                FROM payments";
$result = $conn->query($selectQuery);

$payments = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payments[] = array(
            "store_id" => $row["store_id"],
            "amount" => $row["amount"],
            "payment_date" => $row["payment_date"]
        );
    }
}

// Close the database connection
$conn->close();

// Output JSON response
header('Content-Type: application/json');
echo json_encode($payments);
?>