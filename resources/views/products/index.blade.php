<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Menu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Font Awesome for icons -->
    <style>
        /* General Body Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f4e3; /* Light cafe background */
            color: #333;
        }

        h1 {
            text-align: center;
            color: #5a3e2b; /* Dark brown for headings */
            margin-bottom: 30px;
            font-family: 'Georgia', serif; /* More traditional font */
        }

        /* Table Number Input Styling */
        div {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            color: #5a3e2b;
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Sort Button Styling */
        #sortButton {
            display: block; /* Make it a block element */
            margin: 0 auto 20px; /* Center the button and add bottom margin */
            padding: 10px 15px;
            background-color: #7b5c45; /* Cafe-like brown */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        #sortButton:hover {
            background-color: #634c3b;
        }

        /* Product Grid Styling */
        #product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px; /* Increased gap */
            margin-top: 20px;
        }

        .product-card {
            border: 1px solid #e0d9c6; /* Lighter border */
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1); /* Softer shadow */
            background-color: #ffffff; /* White background for cards */
            transition: transform 0.3s ease; /* Add hover effect */
        }

        .product-card:hover {
            transform: translateY(-5px); /* Lift card on hover */
        }

        .product-card img {
            max-width: 100%;
            height: 150px; /* Fixed height for images */
            object-fit: cover; /* Crop image to fit */
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }

        .product-card h3 {
            margin-bottom: 5px;
            color: #5a3e2b;
        }

        .product-card p {
            color: #666; /* Slightly darker gray */
            margin-bottom: 10px;
            font-size: 0.9em; /* Smaller font for description */
        }

        .product-card .price {
            font-weight: bold;
            margin-bottom: 15px;
            color: #7b5c45; /* Matching the sort button */
            font-size: 1.1em;
        }

        .product-card .detail-button {
            padding: 10px 15px; /* Increased padding */
            background-color: #a0836e; /* Softer brown */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .product-card .detail-button:hover {
            background-color: #8b715f;
        }

        /* Modal Styles - Updated to match design */
        .modal {
            display: none;
            position: fixed;
            z-index: 100; /* Higher z-index */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6); /* Darker overlay */
            backdrop-filter: blur(5px); /* Add blur effect */
            -webkit-backdrop-filter: blur(5px); /* For Safari */
        }

        .modal-content {
            background-color: #ffffff; /* White background */
            margin: 5% auto; /* Adjusted margin */
            padding: 30px; /* Increased padding */
            border: 1px solid #888;
            width: 80%; /* Wider modal */
            max-width: 800px; /* Max width */
            border-radius: 10px; /* More rounded corners */
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1.5fr; /* Adjust column ratio */
            gap: 30px; /* Increased gap */
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-product-image-container {
            text-align: center;
        }

        .modal-product-image {
            max-width: 100%;
            max-height: 350px; /* Increased max height */
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
            object-fit: contain;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }

        .modal-product-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee; /* Add a separator */
            padding-bottom: 10px;
        }

        .modal-header h2 {
            margin: 0;
            color: #5a3e2b;
        }

        .modal-cart-icon {
            font-size: 28px; /* Larger icon */
            color: #7b5c45;
        }

        .modal-product-details p {
            margin-bottom: 15px;
            color: #555;
            line-height: 1.5; /* Improved readability */
        }

        #modal-product-harga {
            font-size: 1.3em;
            font-weight: bold;
            color: #7b5c45;
            margin-bottom: 20px;
        }

        .modal-quantity-controls {
            display: flex;
            align-items: center;
            margin-bottom: 20px; /* Increased margin */
            justify-content: center; /* Center controls */
        }

        .quantity-button {
            padding: 10px 15px; /* Increased padding */
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #eee;
            cursor: pointer;
            font-size: 18px; /* Larger font */
            transition: background-color 0.3s ease;
        }

        .quantity-button:hover {
            background-color: #ddd;
        }

        .item-quantity {
            margin: 0 15px; /* Increased margin */
            font-size: 20px; /* Larger font */
            font-weight: bold;
            color: #5a3e2b;
        }

        #modal-add-to-cart-button {
            padding: 12px 15px; /* Increased padding */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px; /* Larger font */
            width: 100%;
            margin-bottom: 15px;
            transition: background-color 0.3s ease;
        }

        #modal-add-to-cart-button:hover {
            background-color: #45a049;
        }

        .modal-back-button {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            cursor: pointer;
            color: #5a3e2b;
            font-size: 1em;
            transition: color 0.3s ease;
        }

        .modal-back-button:hover {
            color: #7b5c45;
        }

        .modal-back-button i {
            margin-right: 8px; /* Increased margin */
            font-size: 20px; /* Larger icon */
        }

        .close-button {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            font-weight: bold;
            padding: 0; /* Remove padding */
            transition: color 0.3s ease;
            line-height: 1; /* Ensure consistent vertical alignment */
        }

        .close-button:hover,
        .close-button:focus {
            color: #333;
            text-decoration: none;
            cursor: pointer;
        }

        /* Shopping Cart Icon Styling */
        #cart-icon-container {
            position: fixed; /* Fixed to viewport */
            top: 20px;
            right: 20px;
            z-index: 1000; /* Ensure it's on top of other elements */
        }

        #cart-icon-link {
            display: inline-block;
            padding: 15px; /* Larger padding */
            background-color: #a0836e; /* Matching detail button */
            border-radius: 50%; /* Circular shape */
            color: white; /* White icon */
            text-decoration: none;
            transition: background-color 0.3s ease; /* Smooth hover effect */
            opacity: 0.9; /* Slightly transparent initially */
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
        }

        #cart-icon-link:hover {
            background-color: #8b715f; /* Slightly darker on hover */
            opacity: 1; /* Fully opaque on hover */
        }

        #cart-icon-link[disabled] {
            opacity: 0.5; /* More transparent when disabled */
            cursor: default; /* No pointer cursor when disabled */
            pointer-events: none; /* Prevent clicks when disabled */
            background-color: #ccc; /* Gray out when disabled */
        }

        #cart-icon-link i {
            font-size: 28px; /* Larger size of the cart icon */
        }

        /* Order Confirmation Message Styling */
        #order-confirmation-message {
            display: none;
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #d4edda; /* Green border */
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text */
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Our Menu</h1>

    <div>
        <label for="table-number">Table Number:</label>
        <input type="text" id="table-number" name="table_number" placeholder="Enter table number">
    </div>

    <button id="sortButton">Sort by Price (Ascending)</button>

    <div id="product-grid" data-products='@json($products)'>
        {{-- Product Grid Container (populated by JS) --}}
    </div>

    <div id="cart-icon-container">
        <a href="{{ route('cart.index') }}" id="cart-icon-link" disabled>
            <i class="fas fa-shopping-cart"></i>
        </a>
    </div>


    <div id="order-confirmation-message">
    </div>

    <!-- The Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-button">×</span>
            <div class="modal-product-image-container">
                <img id="modal-product-pict" src="" alt="Product Picture" class="modal-product-image">
            </div>
            <div class="modal-product-details">
                <div class="modal-header">
                    <h2 id="modal-product-nama"></h2>
                    <i class="fas fa-coffee modal-cart-icon"></i> <!-- Using a coffee icon for variety -->
                </div>
                <p id="modal-product-deskripsi"></p>
                <p id="modal-product-harga" class="price"></p>
                <div class="modal-quantity-controls">
                    <button class="quantity-button decrease-quantity" id="modal-decrease-quantity">-</button>
                    <span class="item-quantity" id="modal-item-quantity">1</span>
                    <button class="quantity-button increase-quantity" id="modal-increase-quantity">+</button>
                </div>

                <button id="modal-add-to-cart-button" class="add-to-order-button">Tambah Ke Keranjang</button>

                <div class="modal-back-button" id="modal-back-button">
                    <i class="fas fa-arrow-left"></i> Kembali
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reviewOrderButton = document.getElementById('cart-icon-link');
            const orderConfirmationMessageDiv = document.getElementById('order-confirmation-message');
            const tableNumberInput = document.getElementById('table-number');
            const sortButton = document.getElementById('sortButton');
            const productGrid = document.getElementById('product-grid');

            let products = JSON.parse(productGrid.dataset.products);
            let sortedAscending = true;

            // algoritma bubble sort
            function bubbleSort(arr, ascending = true) {
                let len = arr.length;
                let swapped;
                do {
                    swapped = false;
                    for (let i = 0; i < len - 1; i++) {
                        const price1 = parseFloat(arr[i].harga);
                        const price2 = parseFloat(arr[i + 1].harga);

                        if (ascending) {
                            if (price1 > price2) {
                                let tmp = arr[i];
                                arr[i] = arr[i + 1];
                                arr[i + 1] = tmp;
                                swapped = true;
                            }
                        } else {
                            if (price1 < price2) {
                                let tmp = arr[i];
                                arr[i] = arr[i + 1];
                                arr[i + 1] = tmp;
                                swapped = true;
                            }
                        }
                    }
                } while (swapped);
                return arr;
            }

            function renderProducts(products) {
                productGrid.innerHTML = ''; // Clear existing products

                products.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.classList.add('product-card');
                    productCard.dataset.productId = product.id;
                    productCard.dataset.productNama = product.nama;
                    productCard.dataset.productDeskripsi = product.deskripsi;
                    productCard.dataset.productHarga = product.harga;
                    productCard.dataset.productPict = product.product_pict;

                    const img = document.createElement('img');
                    // Use placehold.co if product_pict is null, empty, or an error occurs
                    img.src = product.product_pict ? product.product_pict : 'https://placehold.co/250x150?text=No+Image';
                    img.alt = product.nama;

                    // Add an error handler for the image
                    img.onerror = function() {
                        this.onerror = null; // Prevent infinite loop if placeholder also fails
                        this.src = 'https://placehold.co/250x150?text=Error+Loading+Image';
                    };


                    const h3 = document.createElement('h3');
                    h3.textContent = product.nama;

                    const p = document.createElement('p');
                    p.textContent = product.deskripsi;

                    const price = document.createElement('p');
                    price.classList.add('price');
                    price.textContent = `Price: Rp${parseInt(product.harga).toLocaleString('id-ID')}`;

                    const detailButton = document.createElement('button');
                    detailButton.classList.add('detail-button');
                    detailButton.textContent = 'Detail';

                    productCard.appendChild(img);
                    productCard.appendChild(h3);
                    productCard.appendChild(p);
                    productCard.appendChild(price);
                    productCard.appendChild(detailButton);

                    productGrid.appendChild(productCard);
                });

                // Re-attach event listeners to the new detail buttons
                const newDetailButtons = document.querySelectorAll('.detail-button');
                newDetailButtons.forEach(button => {
                    button.addEventListener('click', detailButtonClickHandler);
                });
            }

            sortButton.addEventListener('click', function () {
                products = bubbleSort(products, sortedAscending);
                sortedAscending = !sortedAscending;
                sortButton.textContent = `Sort by Price (${sortedAscending ? 'Ascending' : 'Descending'})`;
                renderProducts(products);
            });

            function detailButtonClickHandler() {
                const productCard = this.closest('.product-card');
                selectedProduct = {
                    id: productCard.dataset.productId,
                    nama: productCard.dataset.productNama,
                    deskripsi: productCard.dataset.productDeskripsi,
                    harga: parseFloat(productCard.dataset.productHarga),
                    pict: productCard.dataset.productPict
                };

                // Use placehold.co if product_pict is null, empty, or an error occurs
                modalProductPict.src = selectedProduct.pict ? selectedProduct.pict : 'https://placehold.co/400x300?text=No+Image';

                // Add an error handler for the modal image
                modalProductPict.onerror = function() {
                    this.onerror = null; // Prevent infinite loop if placeholder also fails
                    this.src = 'https://placehold.co/400x300?text=Error+Loading+Image';
                };

                modalProductNama.textContent = selectedProduct.nama;
                modalProductDeskripsi.textContent = selectedProduct.deskripsi;
                modalProductHarga.textContent = `Price: Rp${parseInt(selectedProduct.harga).toLocaleString('id-ID')}`;
                modalQuantity = 1;
                modalItemQuantityDisplay.textContent = modalQuantity;

                productModal.style.display = "block";
            }

            // Initial rendering
            renderProducts(products);

            // Modal elements
            const productModal = document.getElementById('productModal');
            const modalCloseButton = productModal.querySelector('.close-button');
            const modalProductPict = document.getElementById('modal-product-pict');
            const modalProductNama = document.getElementById('modal-product-nama');
            const modalProductDeskripsi = document.getElementById('modal-product-deskripsi');
            const modalProductHarga = document.getElementById('modal-product-harga');
            const modalAddToCartButton = document.getElementById('modal-add-to-cart-button');
            const modalBackButton = document.getElementById('modal-back-button');
            const modalDecreaseQuantityButton = document.getElementById('modal-decrease-quantity');
            const modalIncreaseQuantityButton = document.getElementById('modal-increase-quantity');
            const modalItemQuantityDisplay = document.getElementById('modal-item-quantity');


            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]'); // Load cart from session, default to empty array
            let selectedProduct = null;
            let modalQuantity = 1;

            function updatePlaceOrderButtonState() {
                if (cart.length > 0 && tableNumberInput.value.trim() !== '') {
                    reviewOrderButton.removeAttribute('disabled');
                } else {
                    reviewOrderButton.setAttribute('disabled', 'disabled');
                }
                 // Store table number in sessionStorage
                 sessionStorage.setItem('tableNumber', tableNumberInput.value.trim());
            }

             // Load table number from sessionStorage on page load
            const savedTableNumber = sessionStorage.getItem('tableNumber');
            if (savedTableNumber) {
                tableNumberInput.value = savedTableNumber;
            }


            // Event listener for product card click (delegation is more efficient)
            productGrid.addEventListener('click', function(event) {
                const detailButton = event.target.closest('.detail-button');
                if (detailButton) {
                    detailButtonClickHandler.call(detailButton);
                }
            });


            modalAddToCartButton.addEventListener('click', function () {
                if (selectedProduct) {
                    const productName = selectedProduct.nama;
                    const productPrice = selectedProduct.harga;
                    // Determine the image URL to store in the cart.
                    // Use a placeholder if the original is null/empty OR if it failed to load.
                    // We'll use the modalProductPict's current src as it has the error handler.
                    const productPict = modalProductPict.src;
                    const productDeskripsi = selectedProduct.deskripsi;
                    const quantityToAdd = parseInt(modalItemQuantityDisplay.textContent);

                    const existingCartItemIndex = cart.findIndex(item => item.name === productName);

                    if (existingCartItemIndex > -1) {
                        cart[existingCartItemIndex].quantity += quantityToAdd;
                    } else {
                        cart.push({
                            name: productName,
                            price: productPrice,
                            quantity: quantityToAdd,
                            pict: productPict,
                            deskripsi: productDeskripsi
                        });
                    }
                    sessionStorage.setItem('cart', JSON.stringify(cart)); // Save cart to session storage
                    updatePlaceOrderButtonState();
                    productModal.style.display = "none";
                    selectedProduct = null;
                    modalQuantity = 1;
                }
            });

            modalCloseButton.addEventListener('click', function () {
                productModal.style.display = "none";
                selectedProduct = null;
                modalQuantity = 1;
            });

            modalBackButton.addEventListener('click', function () {
                productModal.style.display = "none";
                selectedProduct = null;
                modalQuantity = 1;
            });


            window.addEventListener('click', function (event) {
                if (event.target == productModal) {
                    productModal.style.display = "none";
                    selectedProduct = null;
                    modalQuantity = 1;
                }
            });

            modalDecreaseQuantityButton.addEventListener('click', function () {
                if (modalQuantity > 1) {
                    modalQuantity--;
                    modalItemQuantityDisplay.textContent = modalQuantity;
                }
            });

            modalIncreaseQuantityButton.addEventListener('click', function () {
                modalQuantity++;
                modalItemQuantityDisplay.textContent = modalQuantity;
            });


            tableNumberInput.addEventListener('input', function () {
                updatePlaceOrderButtonState();
            });


            updatePlaceOrderButtonState(); // Initial button state
        });
    </script>

</body>

</html>