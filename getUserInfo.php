<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blossomdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_GET['userID'];
$sql = "SELECT Username, Email, FullName, Address, Phone FROM users WHERE UserID = $userID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo "User not found";
}

$conn->close();
?>
