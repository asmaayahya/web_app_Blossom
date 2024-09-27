<?php
session_start();

$servername = "localhost";
$username = "root";
$password = '';
$dbname = "blossomdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // User is not logged in, show a message or redirect to the login page
    echo 'Please login to place an order.';
    exit;
}

// Validate the request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Method not allowed, show an error message
    echo 'Method not allowed.';
    exit;
}

// Include your database connection code
// Replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials
$conn = new mysqli('your_host', 'your_username', 'your_password', 'your_database');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the user ID from the session
$userID = $_SESSION['UserID'];

// Get the total cost of the order
$totalCost = $_POST['totalCost'];

// Get the cart items from the request
$cartItems = $_POST['cartItems'];

// Insert the order into the orders table
$orderDate = date('Y-m-d H:i:s');
$sql = "INSERT INTO orders (UserID, OrderDate, TotalAmount) VALUES ('$userID', '$orderDate', '$totalCost')";
if ($conn->query($sql) === TRUE) {
    $orderID = $conn->insert_id; // Get the ID of the inserted order
    // Insert each item in the cart into the orderdetails table
    foreach ($cartItems as $item) {
        $productID = $item['ProductID'];
        $quantity = $item['Quantity'];
        $price = $item['Price'];
        $sql = "INSERT INTO orderdetails (OrderID, ProductID, Quantity, Price) VALUES ('$orderID', '$productID', '$quantity', '$price')";
        $conn->query($sql);
    }
    echo 'Order placed successfully.';
} else {
    echo 'Error placing order: ' . $conn->error;
}

// Close the database connection
$conn->close();
?>

