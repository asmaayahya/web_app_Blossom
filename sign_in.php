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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Please fill in all fields.";
    } else {
        $sql = "SELECT UserID, Password FROM Users WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($userID, $hashedPassword);
                $stmt->fetch();

                if ($password === $hashedPassword) {
                    $_SESSION['UserID'] = $userID;

                    if ($username === 'asmaa') {
                        header("Location: home_admin_page.html");
                    } else {
                        header("Location: home_page.html");
                    }
                    exit();
                } else {
                    echo "Incorrect password.";
                }
            } else {
                echo "No user found with that username.";
            }

            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement.";
        }
    }
}

$conn->close();
?>
