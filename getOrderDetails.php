<?php
$servername = "localhost"; // Change this to your MySQL server name
$username = "root"; // Change this to your MySQL username
$password = ''; // Change this to your MySQL password
$dbname = "blossomdb"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$orderID = $_GET['orderID'];
$sql = "SELECT products.Name, products.Description, products.ImageURL, orderdetails.Quantity, orderdetails.Price
        FROM orderdetails
        INNER JOIN products ON orderdetails.ProductID = products.ProductID
        WHERE orderdetails.OrderID = $orderID";

$result = $conn->query($sql);

$orderDetails = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }
}

echo json_encode($orderDetails);

$conn->close();
?>

