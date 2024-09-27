
    function appear_icon(itemElement) {
        const cartIcon = itemElement.querySelector(".cart");
        const heartIcon = itemElement.querySelector(".heart");
        const eyeIcon = itemElement.querySelector(".eye");
        cartIcon.style.display = "inline-block";
        heartIcon.style.display = "inline-block";
        eyeIcon.style.display = "inline-block";
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
