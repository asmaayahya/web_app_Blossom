<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "blossomdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_POST['product_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$category = $_POST['category'];
$image_url = $_POST['image_url'];

$sql = "UPDATE products SET Name=?, Description=?, Price=?, Stock=?, CategoryID=?, ImageURL=? WHERE ProductID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdissi", $name, $description, $price, $stock, $category, $image_url, $product_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Product updated successfully";
} else {
    echo "Error updating product";
}

$stmt->close();
$conn->close();
?>

