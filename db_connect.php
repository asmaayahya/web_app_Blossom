<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "blossomdb";

$conn = null;

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    // Optionally, you can remove this line or comment it out
    // echo "Connected successfully";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>