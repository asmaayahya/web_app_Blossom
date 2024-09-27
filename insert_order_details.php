<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blossomdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the request data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is valid
if (isset($data) && is_array($data)) {
    foreach ($data as $item) {
        // Prepare and execute the SQL statement to insert the order details
        $t = $item['quantity'] * $item['price'];

        $stmt = $conn->prepare("INSERT INTO orderdetails (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $item['orderID'], $item['productID'], $item['quantity'], $t);
        $stmt->execute();
        $stmt->close();
    }
    // Return success message
    echo json_encode(array("success" => true));
} else {
    // Return error message
    echo json_encode(array("success" => false, "message" => "Invalid data"));
}

$conn->close();
?>
