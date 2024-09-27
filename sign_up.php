<?php
session_start();

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



if ($conn) {


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Define variables and initialize with empty values
        $username = $password = $email = "";

        // Processing form data when form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate username
            $input_username = trim($_POST["username"]);
            if (empty($input_username)) {
                $username_err = "Please enter a username.";
            } else {
                $username = $input_username;
            }

            // Validate password
            $input_password = trim($_POST["password"]);
            if (empty($input_password)) {
                $password_err = "Please enter a password.";
            } else {
                $password = $input_password;
            }

            // Validate email
            $input_email = trim($_POST["email"]);
            if (empty($input_email)) {
                $email_err = "Please enter an email.";
            } else {
                $email = $input_email;
            }

            // Check input errors before inserting in database
            if (empty($username_err) && empty($password_err) && empty($email_err)) {
                // Prepare an insert statement
                $sql = "INSERT INTO users (Username, Password, Email) VALUES (?, ?, ?)";

                if ($stmt = $conn->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("sss", $param_username, $param_password, $param_email);

                    // Set parameters
                    $param_username = $username;
                    $param_password = $password;
                    $param_email = $email;

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // Redirect to login page
                        header("location: sign_in_up.html");
                        exit();
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close statement
                    $stmt->close();
                }
            }

            // Close connection
            $conn->close();
        }
    }



}

?>