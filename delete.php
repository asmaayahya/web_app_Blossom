<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "blossomdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the AJAX request
$productId = $_POST['product_id'];

if (!$productId) {
    echo "Product ID is missing";
    exit;
}

// Prepare a SQL statement to delete the product
$sql = "DELETE FROM products WHERE ProductID = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    exit;
}
$stmt->bind_param("i", $productId);

// Execute the statement
if ($stmt->execute()) {
    echo "Product deleted successfully";
} else {
    echo "Error deleting product: " . $conn->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
