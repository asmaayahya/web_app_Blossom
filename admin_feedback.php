<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="home_page.css">
    <link rel="stylesheet" href="about_us.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="admin_feedback.css">
</head>
<body>
<!--header section start -->
<header>
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
    <a href="#" class="logo"><i class='fas fa-seedling' style='font-size:25px; color: #ccc7c3; ' ></i>Blossom </a>
    <nav class="navbar">
        <a href="home_admin_page.html">Home</a>
        <a href="dispaly.php">Shop</a>
        <a href="contact_admin.html">Contact us</a>
        <a href="about_us_admin.html">About</a>
        <a href="admin_feedback.php">Feedback</a>
        <a href="admin_btns.html">Admin</a>
    </nav>
    <div class="icons">
        <a href="wishlist_admin.html" class="fas fa-heart"></a>
        <a  href="cart_admin.html" class="fas fa-shopping-cart"></a>
        <a href="sign_in_up_admin.html" class="fas fa-user"></a>
    </div>
</header>
<!--header section end -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blossomdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

// Fetch feedback data along with user names
$sql = "SELECT f.FeedbackID, f.UserID, f.FeedbackText, f.Stars, f.FeedbackDate, u.FullName
FROM feedback f
JOIN users u ON f.UserID = u.UserID
ORDER BY f.FeedbackDate DESC";
$result = $conn->query($sql);
?>
<div class="first_div" style="height: 120px" >
    <h1>Customer Feedbacks</h1>
</div>
<div class="feedback-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $stars = intval($row['Stars']);
            $empty_stars = 5 - $stars;
            echo '<div class="feedback-card">';
            echo '<div class="feedback-header">';
            echo '<h3>' . htmlspecialchars($row['FullName']) . '</h3>';
            echo '<div class="stars">';
            for ($i = 0; $i < $stars; $i++) {
                echo '<i class="fas fa-star"></i>';
            }
            for ($i = 0; $i < $empty_stars; $i++) {
                echo '<i class="far fa-star"></i>';
            }
            echo '</div></div>';
            echo '<div class="feedback-date">' . htmlspecialchars($row['FeedbackDate']) . '</div>';
            echo '<p>' . htmlspecialchars($row['FeedbackText']) . '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No feedback available.</p>';
    }
    ?>
</div>




<!-- footer section start -->
<div class="footer">
    <div class="content">
        <div class="services">
            <h4>Shop</h4>
            <p><a href="dispaly.php">Indoor plants</a></p>
            <p><a href="dispaly.php">Outdoor plants</a></p>
            <p><a href="dispaly.php">plant pots</a></p>
            <p><a href="dispaly.php">Cactus</a></p>
            <p><a href="dispaly.php">Seeds</a></p>
            <p><a href="dispaly.php">Accessories</a></p>
        </div>
        <div class="social-media">
            <h4>Social</h4>
            <p>
                <a href="http://linkedin.com/in/mira-assi-1113ab239"
                ><i class="fab fa-linkedin"></i> Linkedin</a
                >
            </p>
            <p>
                <a href="#"
                ><i class="fab fa-twitter"></i> Twitter</a
                >
            </p>
            <p>
                <a href="https://www.facebook.com/asmaa.yahya.5661"
                ><i class="fab fa-facebook"></i> Facebook</a
                >
            </p>
            <p>
                <a href="https://www.instagram.com/asmaa_yahya000/"
                ><i class="fab fa-instagram"></i> Instagram</a
                >
            </p>
        </div>
        <div class="links">
            <h4>Quick links</h4>
            <p><a href="home_admin_page.html">Home</a></p>
            <p><a href="about_us_admin.html">About</a></p>
            <p><a href="dispaly.php">Shop</a></p>
            <p><a href="contact_admin.html">Contact</a></p>
            <p><a href="admin_feedback.php">Feedback</a></p>
        </div>
        <div class="details">
            <h4 class="address">Address</h4>
            <p>
                Jenin <br />
                Abu Bakr Street, next to the Islamic Bank.
            </p>
            <h4 class="mobile">Mobile</h4>
            <p><a href="#">+972 59-898-6445</a></p>
            <h4 class="mail">Email</h4>
            <p><a href="mailto:asmaa12112499@gmail.com">asmaa12112499@gmail.com</a></p>
        </div>
    </div>
    <footer>
        <hr />
        © 2024 copyright.
    </footer>
</div>
<!-- footer section end -->

</body>
</html>