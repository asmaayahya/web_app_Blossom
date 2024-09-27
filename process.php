<?php
// process.php
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

// Check if the user is logged in and UserID is set in the session
if (!isset($_SESSION['UserID'])) {
    die('User not logged in.');
}

$userid = $_SESSION['UserID'];

// Get the form data
$fullname = $_POST['full_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

// Validate form data
if (empty($fullname) || empty($address) || empty($phone)) {
    die('All fields are required.');
}

// Prepare an SQL statement to update the user's information
$sql = "UPDATE users SET FullName = ?, Address = ?, Phone = ? WHERE UserID = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind the variables to the prepared statement
    $stmt->bind_param("sssi", $fullname, $address, $phone, $userid);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Your details have been updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the connection
$conn->close();
?>

