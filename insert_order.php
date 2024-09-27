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

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the POST data
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if the data is valid
    if (isset($data["userID"]) && isset($data["orderDate"]) && isset($data["totalAmount"])) {

        // Prepare and execute the SQL statement to insert the order
        $stmt = $conn->prepare("INSERT INTO orders (UserID, OrderDate, TotalAmount) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $data["userID"], $data["orderDate"], $data["totalAmount"]);

        if ($stmt->execute()) {
            // Return the inserted order ID
            $response = array("success" => true, "orderID" => $conn->insert_id);
            echo json_encode($response);
            exit; // Stop execution after sending the response
        } else {
            // Return an error message
            echo json_encode(array("success" => false, "message" => "Failed to insert order"));
            exit; // Stop execution after sending the response
        }

        $stmt->close();
    } else {
        // Return an error message if the data is not valid
        echo json_encode(array("success" => false, "message" => "Invalid data"));
        exit; // Stop execution after sending the response
    }
} else {
    // Return an error message if the request method is not POST
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
    exit; // Stop execution after sending the response
}
?>
