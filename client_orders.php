<!-- admin_page.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="home_page.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="home.js"></script>
    <link rel="stylesheet" href="admin_add.css">
    <link rel="stylesheet" href="about_us.css">
    <link rel="stylesheet" href="clients_order.css">

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
        <a href="wishlist.html" class="fas fa-heart"></a>
        <a  href="cart.html" class="fas fa-shopping-cart"></a>
        <a href="sign_in_up.html" class="fas fa-user"></a>
    </div>
</header>
<!--header section end -->
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
echo "Connected successfully";
$sql = "SELECT orders.OrderID, orders.UserID, orders.OrderDate, orders.TotalAmount, users.Username
        FROM orders
        INNER JOIN users ON orders.UserID = users.UserID
        ORDER BY orders.OrderDate ASC"; // Order by oldest date first
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container'>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='order-card'>";
        echo "<h3>Order #" . $row["OrderID"]. "</h3>";
        echo "<p>User: " . $row["Username"]. "</p>";
        echo "<p>Order Date: " . $row["OrderDate"]. "</p>";
        echo "<p>Total Price: $" . $row["TotalAmount"]. "</p>";
        echo "<div class='button-group'>";
        echo "<button onclick='showOrderDetails(" . $row["OrderID"] . ")' class='button' >Show Order Details</button>";
        echo "<button onclick='showUserInfo(" . $row["UserID"] . ")' class='button'>Show customer Info</button>";

        echo "</div>"; // close button-group
        echo "</div>"; // close order-card
    }
    echo "</div>"; // close container
} else {
    echo "0 results";
}

$conn->close();
?>

<div id="userInfoModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeUserInfoModal()">&times;</span>
        <div id="userInfo"></div>
    </div>
</div>
<div id="orderDetailsModal" class="modal" style="display: none;">
    <div class="modal-content-1">
        <span class="close" onclick="closeOrderDetailsModal()">&times;</span>
        <div id="orderDetails"></div>
    </div>
</div>
<script>
    function showUserInfo(userID) {
        let userInfoDiv = document.getElementById("userInfo");

        // Display the user information modal
        let userInfoModal = document.getElementById("userInfoModal");
        userInfoModal.style.display = "block";

        // Fetch user information using AJAX
        fetch('getUserInfo.php?userID=' + userID)
            .then(response => response.json())
            .then(data => {
                // Display user information in the modal
                userInfoDiv.innerHTML = `
                    <h2 class="user_info_header">Customer Information</h2>
                    <p class="user_info_p"><strong>Username:</strong> ${data.Username}</p>
                    <p class="user_info_p"><strong>Email:</strong> ${data.Email}</p>
                    <p class="user_info_p"><strong>Full Name:</strong> ${data.FullName}</p>
                    <p class="user_info_p"><strong>Address:</strong> ${data.Address}</p>
                    <p class="user_info_p"><strong>Phone:</strong> ${data.Phone}</p>
                `;
            });
    }

    function closeUserInfoModal() {
        document.getElementById("userInfoModal").style.display = "none";
    }

    function showOrderDetails(orderID) {
        let orderDetailsDiv = document.getElementById("orderDetails");
        // Display the order details modal
        let orderDetailsModal = document.getElementById("orderDetailsModal");
        orderDetailsModal.style.display = "block";

        // Fetch order details using AJAX
        fetch('getOrderDetails.php?orderID=' + orderID)
            .then(response => response.json())
            .then(data => {
                // Display order details in the modal
                orderDetailsDiv.innerHTML = '';
                data.forEach(product => {
                    orderDetailsDiv.innerHTML += `
                    <div class='order-details-card'>
                        <h4>${product.Name}</h4>
                        <img src='${product.ImageURL}' alt='${product.Name}'/>
                        <p><strong>Description:</strong> ${product.Description}</p>
                        <p  style="font-size: 12pt;color: black; font-weight: bold">Quantity:${product.Quantity}</p>
                        <p style="font-size: 12pt;color: black; font-weight: bold">Price: $${product.Price}</p>
                    </div>
                `;
                });
            });
    }

    function closeOrderDetailsModal() {
        document.getElementById("orderDetailsModal").style.display = "none";
    }

</script>




<!-- footer section start -->
<div class="footer">
    <div class="content">
        <div class="services">
            <h4>Shop</h4>
            <p><a href="#">Indoor plants</a></p>
            <p><a href="#">Outdoor plants</a></p>
            <p><a href="#">plant pots</a></p>
            <p><a href="#">Cactus</a></p>
            <p><a href="#">Seeds</a></p>
            <p><a href="#">Accessories</a></p>
        </div>
        <div class="social-media">
            <h4>Social</h4>
            <p>
                <a href="#"
                ><i class="fab fa-linkedin"></i> Linkedin</a
                >
            </p>
            <p>
                <a href="#"
                ><i class="fab fa-twitter"></i> Twitter</a
                >
            </p>
            <p>
                <a href="https://www.facebook.com/codewithfaraz"
                ><i class="fab fa-facebook"></i> Facebook</a
                >
            </p>
            <p>
                <a href="https://www.instagram.com/codewithfaraz"
                ><i class="fab fa-instagram"></i> Instagram</a
                >
            </p>
        </div>
        <div class="links">
            <h4>Quick links</h4>
            <p><a href="#">Home</a></p>
            <p><a href="#">About</a></p>
            <p><a href="#">Shop</a></p>
            <p><a href="#">Contact</a></p>
            <p><a href="#">Feedback</a></p>
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
            <p><a href="#">asmaa12112499@gmail.com</a></p>
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