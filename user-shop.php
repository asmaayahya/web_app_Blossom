<?php
// Connect to the database
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


// Fetch products
$sql = "SELECT ProductID, Name, Description, Price, Stock, CategoryID, ImageURL FROM products";
$result = $conn->query($sql);

// Define categories
$categories = [
    1 => "indoor",
    2 => "outdoor",
    3 => "cactus",
    4 => "seeds",
    5 => "plantpots",
    6 => "accessories"
];

$product_data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $product_data[$categories[$row["CategoryID"]]][] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blossom Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home_page.css">
    <link href="shop.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!--    <script src="shop.js" defer></script>-->
</head>
<body>
<!--header section start -->
<header>
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
    <a href="#" class="logo"><i class='fas fa-seedling' style='font-size:25px; color: #ccc7c3; ' ></i>Blossom </a>
    <nav class="navbar">
        <a href="home_page.html">Home</a>
        <a href="user-shop.php">Shop</a>
        <a href="contact.html">Contact us</a>
        <a href="about_us.html">About</a>
        <a href="feeback.html">Feedback</a>
    </nav>
    <div class="icons">
        <a href="wishlist.html" class="fas fa-heart"></a>
        <a id="iconCart" href="cart.html" class="fas fa-shopping-cart"></a>
        <a href="sign_in_up.html" class="fas fa-user"></a>
    </div>
</header>
<!--header section end -->

<section id="hero" class="hero">
   <img src="images/flowers-background-copy-space.jpg" ">
    <div class="content">
        <h3 >Welcome to Blossom Shop!</h3>

    </div>
</section>

<section class="shop-products" id="shop-products">
    <div >
        <h1 class="shop-heading"> <span> Our products</span></h1>
    </div>
    <div class="shop-box-container" id="shop_now">
        <div class="shop-box" onclick="showSection('indoor')">
            <div class="shop-image">
                <img src="images/indoor.jpg" alt="Indoor plants">
            </div>
            <div class="shop-content">
                <h3>Indoor plants</h3>
            </div>
        </div>
        <div class="shop-box" onclick="showSection('outdoor')">
            <div class="shop-image">
                <img src="images/out.jpg" alt="Outdoor plants">
            </div>
            <div class="shop-content">
                <h3>Outdoor plants</h3>
            </div>
        </div>
        <div class="shop-box" onclick="showSection('cactus')">
            <div class="shop-image">
                <img src="images/cactus.jpg" alt="Cactus">
            </div>
            <div class="shop-content">
                <h3>Cactus</h3>
            </div>
        </div>
        <div class="shop-box" onclick="showSection('seeds')">
            <div class="shop-image">
                <img src="images/seedss.jpg" alt="Seeds">
            </div>
            <div class="shop-content">
                <h3>Seeds</h3>
            </div>
        </div>
        <div class="shop-box" onclick="showSection('plantpots')">
            <div class="shop-image">
                <img src="images/plantpots.jpg" alt="Plant pots">
            </div>
            <div class="shop-content">
                <h3>Plant pots</h3>
            </div>
        </div>
        <div class="shop-box" onclick="showSection('accessories')">
            <div class="shop-image">
                <img src="images/plant_accs.jpg" alt="Accessories">
            </div>
            <div class="shop-content">
                <h3>Accessories</h3>
            </div>
        </div>
    </div>
</section>
<section class="cart-list" id="cart-list" style="display: none;">
    <h2>Cart</h2>
    <div id="cart-items"></div>
    <div class="cart-total">
        <h3>Total: $<span id="total-cost">0</span></h3>
    </div>
</section>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body">
            <img src="" alt="Item Image" class="modal-image">
            <div class="modal-text">
                <h2 class="modal-title"></h2>
                <p class="modal-description"></p>
                <p class="modal-price"></p>
                <button class="add-to-cart" >Add to Cart</button>
            </div>
        </div>
    </div>
</div>

<?php foreach ($categories as $category_id => $category_name): ?>
    <section id="<?php echo $category_name; ?>" class="section-content">
        <section class="items">
            <div class="all-items">
                <?php if (isset($product_data[$category_name])): ?>
                    <?php foreach ($product_data[$category_name] as $product): ?>
                        <div onmouseover="appear_icon(this)" onmouseout="hidden_icon(this)" class="item item slide-in from-top">
                            <img src="<?php echo $product["ImageURL"]; ?>" alt="<?php echo $product["Name"]; ?>" class="item-image">
                            <div class="item-info">
                                <h4 class="item-title"><?php echo $product["Name"]; ?></h4>
                                <p class="item-description" style="display: none"><?php echo $product["Description"]; ?></p>
                                <p class="item-price">$<?php echo number_format($product["Price"], 2); ?></p>
                                <div class="item-icons">
                                    <a class="cart" href="#"><i class="fas fa-shopping-cart"></i></a>
                                    <a class="heart" href="#"><i class="fas fa-heart"></i></a>
                                    <a class="eye" href="#" onclick="return false;"><i class="fas fa-eye"></i></a>
                                    <a class="heart" href="#"><i class="fas fa-trash"></i></a>
                                    <a class="eye" href="#"><i class="fas fa-edit"></i></a>

                                </div>
                            </div>
                        </div>


                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No products available in this category.</p>
                <?php endif; ?>
            </div>

        </section>
    </section>
<?php endforeach; ?>

<script>
    function showSection(sectionId) {
        document.querySelectorAll('.section-content').forEach(section => {
            section.style.display = 'none';
        });
        document.getElementById(sectionId).style.display = 'block';
    }
    // Optionally show the first section by default
    showSection('indoor');
    document.addEventListener('DOMContentLoaded', (event) => {
        const modal = document.getElementById("modal");
        const span = document.getElementsByClassName("close")[0];

        document.querySelectorAll('.eye').forEach(eyeIcon => {
            eyeIcon.addEventListener('click', function(event) {
                const item = this.closest('.item');
                const imageSrc = item.querySelector('.item-image').src;
                const title = item.querySelector('.item-title').innerText;
                const price = item.querySelector('.item-price').innerText;

                document.querySelector('.modal-image').src = imageSrc;
                document.querySelector('.modal-title').innerText = title;
                document.querySelector('.modal-price').innerText = price;

                modal.style.display = "block";
            });
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });

    function appear_icon(itemElement) {
        const cartIcon = itemElement.querySelector(".cart");
        const heartIcon = itemElement.querySelector(".heart");
        const eyeIcon = itemElement.querySelector(".eye");
        const editIcon = itemElement.querySelector(".edit");
        const trashIcon = itemElement.querySelector(".trash");
        cartIcon.style.display = "inline-block";
        heartIcon.style.display = "inline-block";
        eyeIcon.style.display = "inline-block";
        editIcon.style.display = "inline-block";
        trashIcon.style.display = "inline-block";

    }

    // Function to hide icons
    function hidden_icon(itemElement) {
        const cartIcon = itemElement.querySelector(".cart");
        const heartIcon = itemElement.querySelector(".heart");
        const eyeIcon = itemElement.querySelector(".eye");
        cartIcon.style.display = "none";
        heartIcon.style.display = "none";
        eyeIcon.style.display = "none";
    }
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById("modal");
        const span = document.getElementsByClassName("close")[0];
        const modalAddToCartButton = modal.querySelector('.add-to-cart');

        document.querySelectorAll('.eye').forEach(eyeIcon => {
            eyeIcon.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default action to avoid scrolling to top
                const item = this.closest('.item');

                if (!item) {
                    console.error('Item not found for eye icon:', this);
                    return;
                }

                const imageSrc = item.querySelector('.item-image').src;
                const title = item.querySelector('.item-title').innerText;

                const descriptionElem = item.querySelector('.item-description');
                if (!descriptionElem) {
                    console.error('Description element not found for item:', item);
                    return;
                }

                descriptionElem.style.display = 'block';
                const description = descriptionElem.innerText;
                descriptionElem.style.display = 'none'; // Hide it again

                const priceElem = item.querySelector('.item-price');
                if (!priceElem) {
                    console.error('Price element not found for item:', item);
                    return;
                }
                const price = priceElem.innerText;

                document.querySelector('.modal-image').src = imageSrc;
                document.querySelector('.modal-title').innerText = title;
                document.querySelector('.modal-description').innerText = description;
                document.querySelector('.modal-price').innerText = price;

                modalAddToCartButton.dataset.imgSrc = imageSrc;
                modalAddToCartButton.dataset.title = title;
                modalAddToCartButton.dataset.description = description;
                modalAddToCartButton.dataset.price = price.replace('$', '');

                modal.style.display = "block";
            });
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        modalAddToCartButton.addEventListener('click', function(event) {
            addToCart(event);
            modal.style.display = "none"; // Close the modal after adding to cart
        });

        document.querySelectorAll('.cart').forEach(cartButton => {
            cartButton.addEventListener('click', addToCart);
        });
    });
    function addToCart(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const item = button.closest('.item');
        let imgSrc, title, price;

        if (item) {
            imgSrc = item.querySelector('.item-image').src;
            title = item.querySelector('.item-title').innerText;
            price = parseFloat(item.querySelector('.item-price').innerText.replace('$', ''));
        } else {
            imgSrc = button.dataset.imgSrc;
            title = button.dataset.title;
            price = parseFloat(button.dataset.price);
        }

        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        let existingItem = cartItems.find(cartItem => cartItem.title === title);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cartItems.push({ imgSrc, title, price, quantity: 1 });
        }

        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        loadCart(); // Reload the cart to update the total cost
    }


    document.addEventListener("DOMContentLoaded", function() {
        // Show the first section by default
        showSection('indoor');
    });

    function showSection(sectionId) {
        // Hide all sections
        var sections = document.querySelectorAll('.section-content');
        sections.forEach(function(section) {
            section.style.display = 'none';
            section.classList.remove('active');
        });

        // Show the selected section
        var activeSection = document.getElementById(sectionId);
        activeSection.style.display = 'block';
        activeSection.classList.add('active');
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.heart').forEach(heartIcon => {
            heartIcon.addEventListener('click', function(event) {
                event.preventDefault();
                const item = this.closest('.item');
                if (!item) {
                    console.error('Item not found for heart icon:', this);
                    return;
                }

                const imgSrc = item.querySelector('.item-image').src;
                const title = item.querySelector('.item-title').innerText;
                const description = item.querySelector('.item-description').innerText;
                const price = item.querySelector('.item-price').innerText;

                const wishlistItems = JSON.parse(localStorage.getItem('wishlistItems')) || [];
                wishlistItems.push({ imgSrc, title, description, price });
                localStorage.setItem('wishlistItems', JSON.stringify(wishlistItems));


            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.slide-in');

        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        items.forEach(item => {
            observer.observe(item);
        });
    });



</script>

</body>
</html>


