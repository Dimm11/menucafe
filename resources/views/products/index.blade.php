<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Menu</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
            position: relative;
        }

        .close-button {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-product-image {
            max-width: 50%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .modal-quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
        }

        .modal-quantity-button {
            padding: 8px 12px;
            background-color: #f0f0f0;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 10px;
        }

        .modal-quantity-button:hover {
            background-color: #e0e0e0;
        }

        .modal-quantity {
            margin: 0 10px;
            font-size: 1.2em;
        }

        .modal-actions {
            text-align: center;
            margin-top: 20px;
        }

        .modal-add-to-order-button,
        .modal-back-button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 10px;
        }

        .modal-back-button {
            background-color: #f44336; /* Red for back/cancel */
        }

        .modal-add-to-order-button:hover,
        .modal-back-button:hover {
            opacity: 0.9;
        }

        /* Cart Modal Styles */
        #cartModal .modal-content {
            width: 90%; /* Adjust cart modal width if needed */
            max-width: 600px; /* Example max width for cart modal */
        }

        /* Cart Button Styles */
        #cartButton {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 2; /* Ensure it's above other content */
        }

        #cartButton:hover {
            background-color: #0056b3;
        }

        #cart-items-modal .modal-content{
            margin-top: 5%; /* Adjust top margin for cart modal */
        }

    </style>
</head>

<body>
    <h1>Our Menu</h1>

    <button id="cartButton">View Cart</button>

    @isset($tableId)
    <div>
        <label for="table-number">Table Number:</label>
        <input type="text" id="table-number" name="table_number" value="{{ $tableId ?? '' }}">
    </div>
    @else
    <div>

    </div>
    @endisset

    <div id="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
        {{-- Product Grid Container --}}
        @foreach ($products as $product)
        <div class="product-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);" data-product-id="{{ $product->id }}" data-product-name="{{ $product->nama }}" data-product-description="{{ $product->deskripsi }}" data-product-price="{{ $product->harga }}" data-product-image="{{ $product->product_pict }}">
            {{-- Product Card Container --}}
            <img src="{{ $product->product_pict }}" alt="{{ $product->nama }}" style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 10px;">
            {{-- Product Image --}}
            <h3 style="margin-bottom: 5px;">{{ $product->nama }}</h3> {{-- Product Name --}}
            <p style="color: #777; margin-bottom: 10px;">{{ $product->deskripsi }}</p> {{-- Product Description --}}
            <p class="price" style="font-weight: bold; margin-bottom: 15px;">Price: ${{ number_format($product->harga, 2) }}</p>
            {{-- Product Price --}}
            <button class="detail-button" style="padding: 8px 12px; background-color: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer;">Detail</button>
            {{-- Detail Button --}}
        </div>
        @endforeach
    </div>

    <!-- Product Detail Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-button product-modal-close">×</span>
            <img src="" alt="Product Image" class="modal-product-image">
            <h2 id="modal-product-name"></h2>
            <p id="modal-product-description"></p>
            <p id="modal-product-price" style="font-weight: bold;"></p>
            <div class="modal-quantity-controls">
                <button class="modal-quantity-button decrease-modal-quantity">-</button>
                <span class="modal-quantity">1</span>
                <button class="modal-quantity-button increase-modal-quantity">+</button>
            </div>
            <div class="modal-actions">
                <button class="modal-add-to-order-button">Add to Order</button>
                <button class="modal-back-button product-modal-back">Back</button>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div id="cartModal" class="modal" id="cart-items-modal">
        <div class="modal-content">
            <span class="close-button cart-modal-close">×</span>
            <h2>Your Order</h2>
            <div id="cart-items">
                <p id="empty-cart-message" style="display: none;">Your cart is empty.</p>
                <ul id="cart-item-list" style="list-style: none; padding-left: 0;">
                </ul>
                <div id="order-total" style="margin-top: 10px; font-weight: bold;">
                    Total: $0.00
                </div>
            </div>

            <button id="cart-review-order-button" disabled>Review Order</button>
            <div id="order-review-section" style="display: none; margin-top: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f8f8f8;">
                <h2>Review Your Order</h2>
                <ul id="order-review-items" style="list-style: none; padding-left: 0;">
                </ul>
                <div id="order-review-total" style="margin-top: 10px; font-weight: bold;">
                </div>
                <button id="confirm-order-button">Confirm Order</button>
                <button id="cart-back-to-menu-button" style="margin-left: 10px;">Back to Cart</button>
            </div>

            <div id="order-confirmation-message" style="display: none; margin-top: 20px; padding: 15px; border: 1px solid #ccc; background-color: #e0f7fa;">
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const detailButtons = document.querySelectorAll('.detail-button');
            const cartButton = document.getElementById('cartButton'); // Cart button
            const cartModal = document.getElementById('cartModal'); // Cart Modal
            const cartModalCloseButton = document.querySelector('.cart-modal-close'); // Cart modal close button
            const cartItemsDiv = cartModal.querySelector('#cart-items'); // Cart items div inside modal
            const cartItemList = cartModal.querySelector('#cart-item-list'); // Cart item list inside modal
            const orderTotalDisplay = cartModal.querySelector('#order-total'); // Order total display inside modal
            const emptyCartMessage = cartModal.querySelector('#empty-cart-message'); // Empty cart message inside modal
            const tableNumberInput = document.getElementById('table-number');
            const reviewOrderButton = cartModal.querySelector('#cart-review-order-button'); // Review Order button inside cart modal
            const orderReviewSection = cartModal.querySelector('#order-review-section'); // Review section inside cart modal
            const orderReviewItemsList = cartModal.querySelector('#order-review-items'); // Review items list inside cart modal
            const orderReviewTotalDisplay = cartModal.querySelector('#order-review-total'); // Review total display inside cart modal
            const confirmOrderButton = cartModal.querySelector('#confirm-order-button'); // Confirm Order button inside cart modal
            const backToMenuButton = cartModal.querySelector('#cart-back-to-menu-button'); // Back to Menu button inside cart modal
            const orderConfirmationMessageDiv = cartModal.querySelector('#order-confirmation-message'); // Confirmation message inside cart modal


            // Product Modal elements
            const productModal = document.getElementById('productModal');
            const productModalCloseButton = document.querySelector('.product-modal-close');
            const productModalBackButton = document.querySelector('.product-modal-back');
            const modalProductName = document.getElementById('modal-product-name');
            const modalProductDescription = document.getElementById('modal-product-description');
            const modalProductPrice = document.getElementById('modal-product-price');
            const modalProductImage = document.querySelector('.modal-product-image');
            const modalQuantitySpan = document.querySelector('.modal-quantity');
            const increaseModalQuantityButton = document.querySelector('.increase-modal-quantity');
            const decreaseModalQuantityButton = document.querySelector('.decrease-modal-quantity');
            const modalAddToCartButton = document.querySelector('.modal-add-to-order-button');


            let cart = [];
            let currentModalProduct = null;
            let modalQuantity = 1;

            function updatePlaceOrderButtonState() {
                if (cart.length > 0 && tableNumberInput.value.trim() !== '') {
                    reviewOrderButton.disabled = false;
                } else {
                    reviewOrderButton.disabled = true;
                }
            }

            detailButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productCard = this.closest('.product-card');
                    currentModalProduct = {
                        id: productCard.dataset.productId,
                        name: productCard.dataset.productName,
                        description: productCard.dataset.productDescription,
                        price: parseFloat(productCard.dataset.productPrice),
                        image: productCard.dataset.productImage
                    };
                    modalQuantity = 1;

                    modalProductName.textContent = currentModalProduct.name;
                    modalProductDescription.textContent = currentModalProduct.description;
                    modalProductPrice.textContent = `Price: $${currentModalProduct.price.toFixed(2)}`;
                    modalProductImage.src = currentModalProduct.image;
                    modalQuantitySpan.textContent = modalQuantity;

                    productModal.style.display = "block";
                });
            });

            productModalCloseButton.onclick = function () {
                productModal.style.display = "none";
            }

            productModalBackButton.onclick = function () {
                productModal.style.display = "none";
            }


            increaseModalQuantityButton.addEventListener('click', function () {
                modalQuantity++;
                modalQuantitySpan.textContent = modalQuantity;
            });

            decreaseModalQuantityButton.addEventListener('click', function () {
                if (modalQuantity > 1) {
                    modalQuantity--;
                    modalQuantitySpan.textContent = modalQuantity;
                }
            });

            modalAddToCartButton.addEventListener('click', function () {
                if (currentModalProduct) {
                    const productName = currentModalProduct.name;
                    const productPrice = currentModalProduct.price;
                    const quantityToAdd = modalQuantity;

                    const existingCartItemIndex = cart.findIndex(item => item.name === productName);

                    if (existingCartItemIndex > -1) {
                        cart[existingCartItemIndex].quantity += quantityToAdd;
                    } else {
                        cart.push({ name: productName, price: productPrice, quantity: quantityToAdd });
                    }

                    updateCartDisplay();
                    updatePlaceOrderButtonState();
                    productModal.style.display = "none";
                }
            });


            function updateCartDisplay() {
                cartItemList.innerHTML = '';
                let totalPrice = 0;

                if (cart.length === 0) {
                    emptyCartMessage.style.display = 'block';
                    orderTotalDisplay.style.display = 'none';
                    reviewOrderButton.disabled = true; // Disable Review Order if cart is empty
                } else {
                    emptyCartMessage.style.display = 'none';
                    orderTotalDisplay.style.display = 'block';
                    reviewOrderButton.disabled = false; // Enable Review Order if cart has items

                    cart.forEach(item => {
                        const listItem = document.createElement('li');
                        const itemTotal = item.price * item.quantity;
                        totalPrice += itemTotal;

                        listItem.innerHTML = `
                            ${item.name} - $${item.price.toFixed(2)}
                            <div style="display: inline-block; margin-left: 10px;">
                                <button class="quantity-button decrease-quantity" data-product-name="${item.name}">-</button>
                                <span class="item-quantity" style="margin: 0 5px;">${item.quantity}</span>
                                <button class="quantity-button increase-quantity" data-product-name="${item.name}">+</button>
                            </div>
                            = $${itemTotal.toFixed(2)}
                        `;
                        cartItemList.appendChild(listItem);
                    });
                }

                orderTotalDisplay.textContent = `Total: $${totalPrice.toFixed(2)}`;
                addQuantityButtonEventListeners();
            }

            function addQuantityButtonEventListeners() {
                const increaseButtons = cartModal.querySelectorAll('.increase-quantity');
                const decreaseButtons = cartModal.querySelectorAll('.decrease-quantity');

                increaseButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const productName = this.dataset.productName;
                        adjustQuantity(productName, 1);
                    });
                });

                decreaseButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const productName = this.dataset.productName;
                        adjustQuantity(productName, -1);
                    });
                });
            }

            function adjustQuantity(productName, change) {
                const cartItemIndex = cart.findIndex(item => item.name === productName);
                if (cartItemIndex > -1) {
                    let newQuantity = cart[cartItemIndex].quantity + change;
                    if (newQuantity < 0) newQuantity = 0;
                    cart[cartItemIndex].quantity = newQuantity;
                    if (cart[cartItemIndex].quantity === 0) {
                        cart.splice(cartItemIndex, 1);
                    }
                    updateCartDisplay();
                    updatePlaceOrderButtonState();
                }
            }

            tableNumberInput.addEventListener('input', function () {
                updatePlaceOrderButtonState();
            });


            reviewOrderButton.addEventListener('click', function () {
                if (cart.length === 0 || tableNumberInput.value.trim() === '') {
                    alert("Please add items to your cart and enter your table number.");
                    return;
                }

                orderReviewSection.style.display = 'block';
                cartItemsDiv.style.display = 'none'; // Hide cart items when reviewing
                reviewOrderButton.style.display = 'none'; // Hide Review Order button in review state

                orderReviewItemsList.innerHTML = '';
                let reviewTotal = 0;
                cart.forEach(item => {
                    const listItem = document.createElement('li');
                    const itemTotal = item.price * item.quantity;
                    reviewTotal += itemTotal;
                    listItem.textContent = `${item.name} x ${item.quantity} - $${itemTotal.toFixed(2)}`;
                    orderReviewItemsList.appendChild(listItem);
                });
                orderReviewTotalDisplay.textContent = `Total: $${reviewTotal.toFixed(2)}`;

            });

            confirmOrderButton.addEventListener('click', function () {
                const tableNumber = tableNumberInput.value.trim();
                const orderData = {
                    table_number: tableNumber,
                    cart_items: cart
                };

                fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(orderData)
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        orderConfirmationMessageDiv.textContent = data.message + (data.order_id ? ` Order ID: ${data.order_id}` : '');
                        orderConfirmationMessageDiv.style.display = 'block';

                        cart = [];
                        updateCartDisplay();
                        updatePlaceOrderButtonState();
                        tableNumberInput.value = '';

                        orderReviewSection.style.display = 'none'; // Hide review section after order
                        cartItemsDiv.style.display = 'block'; // Show cart items section again
                        reviewOrderButton.style.display = 'inline-block'; // Show Review Order button again

                        setTimeout(function () {
                            orderConfirmationMessageDiv.style.display = 'none';
                            cartModal.style.display = 'none'; // Close cart modal after order
                        }, 5000);
                    })
                    .catch(error => {
                        console.error('Error placing order:', error);
                        alert('Failed to place order. Please try again.');
                    });
            });

            backToMenuButton.addEventListener('click', function () {
                orderReviewSection.style.display = 'none';
                cartItemsDiv.style.display = 'block'; // Show cart items section when going back to menu
                reviewOrderButton.style.display = 'inline-block'; // Show Review Order button when going back to menu
            });

            cartButton.addEventListener('click', function() {
                cartModal.style.display = 'block'; // Show cart modal
            });

            cartModalCloseButton.onclick = function() {
                cartModal.style.display = 'none'; // Hide cart modal
            }

            window.onclick = function(event) {
                if (event.target == cartModal) {
                    cartModal.style.display = 'none'; // Hide cart modal if clicked outside
                }
                if (event.target == productModal) {
                    productModal.style.display = 'none'; // Hide product modal if clicked outside
                }
            }


            updateCartDisplay();
            updatePlaceOrderButtonState();
        });
    </script>

</body>

</html>