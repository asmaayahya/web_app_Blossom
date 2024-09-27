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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['UserID'])) {
        $userID = $_SESSION['UserID'];
        $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 2;
        $opinion = isset($_POST['opinion']) ? trim($_POST['opinion']) : '';

        if ($rating >= 1 && $rating <= 5 && !empty($opinion)) {
            $stmt = $conn->prepare("INSERT INTO Feedback (UserID, FeedbackText, Stars, FeedbackDate) VALUES (?, ?, ?, NOW())");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $bind = $stmt->bind_param("isi", $userID, $opinion, $rating);
            if ($bind === false) {
                die('Bind failed: ' . htmlspecialchars($stmt->error));
            }

            $exec = $stmt->execute();
            if ($exec === false) {
                die('Execute failed: ' . htmlspecialchars($stmt->error));
            } else {
                echo "Feedback submitted successfully!";
            }

            $stmt->close();
        } else {
            echo "Invalid input!";
        }
    } else {
        echo "You must be logged in to submit feedback.";
    }
}

$conn->close();
?>
