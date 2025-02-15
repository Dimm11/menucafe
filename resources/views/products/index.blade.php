<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Menu</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <h1>Our Menu</h1>

    <div>
        <label for="table-number">Table Number:</label>
        <input type="text" id="table-number" name="table_number">
    </div>

    <div id="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;"> {{-- Product Grid Container --}}
        @foreach ($products as $product)
            <div class="product-card" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);"> {{-- Product Card Container --}}
                <img src="{{ $product->product_pict }}" alt="{{ $product->nama }}" style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 10px;"> {{-- Product Image --}}
                <h3 style="margin-bottom: 5px;">{{ $product->nama }}</h3> {{-- Product Name --}}
                <p style="color: #777; margin-bottom: 10px;">{{ $product->deskripsi }}</p> {{-- Product Description --}}
                <p class="price" style="font-weight: bold; margin-bottom: 15px;">Price: ${{ number_format($product->harga, 2) }}</p> {{-- Product Price --}}
                <button class="add-to-order-button" style="padding: 8px 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Add to Order</button> {{-- Add to Order Button --}}
            </div>
        @endforeach
    </div>

    <h2>Your Order</h2>
    <div id="cart-items">
        <p id="empty-cart-message" style="display: none;">Your cart is empty.</p>
        <ul id="cart-item-list" style="list-style: none; padding-left: 0;">
        </ul>
        <div id="order-total" style="margin-top: 10px; font-weight: bold;">
            Total: $0.00
        </div>
    </div>

    <button id="review-order-button" disabled>Review Order</button>
    <div id="order-review-section" style="display: none; margin-top: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f8f8f8;">
        <h2>Review Your Order</h2>
        <ul id="order-review-items" style="list-style: none; padding-left: 0;">
        </ul>
        <div id="order-review-total" style="margin-top: 10px; font-weight: bold;">
        </div>
        <button id="confirm-order-button">Confirm Order</button>
        <button id="back-to-menu-button" style="margin-left: 10px;">Back to Menu</button>
    </div>

    <div id="order-confirmation-message"
        style="display: none; margin-top: 20px; padding: 15px; border: 1px solid #ccc; background-color: #e0f7fa;">
    </div>

    <script>
         document.addEventListener('DOMContentLoaded', function () {
            const addToOrderButtons = document.querySelectorAll('.add-to-order-button');
            const cartItemsDiv = document.getElementById('cart-items');
            const cartItemList = document.getElementById('cart-item-list');
            const orderTotalDisplay = document.getElementById('order-total');
            const emptyCartMessage = document.getElementById('empty-cart-message');
            const tableNumberInput = document.getElementById('table-number');
            const reviewOrderButton = document.getElementById('review-order-button'); // Get Review Order button
            const orderReviewSection = document.getElementById('order-review-section'); // Get review section
            const orderReviewItemsList = document.getElementById('order-review-items'); // Get review items list
            const orderReviewTotalDisplay = document.getElementById('order-review-total'); // Get review total display
            const confirmOrderButton = document.getElementById('confirm-order-button'); // Get Confirm Order button
            const backToMenuButton = document.getElementById('back-to-menu-button');     // Get Back to Menu button
            const orderConfirmationMessageDiv = document.getElementById('order-confirmation-message');
            let cart = [];

            function updatePlaceOrderButtonState() { // Now updates Review Order button
                if (cart.length > 0 && tableNumberInput.value.trim() !== '') {
                    reviewOrderButton.disabled = false; // Enable Review Order button
                } else {
                    reviewOrderButton.disabled = true;  // Disable Review Order button
                }
            }

            addToOrderButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productName = this.closest('.product-card').querySelector('h3').textContent; // Get product name from card
                    const productPrice = parseFloat(this.closest('.product-card').querySelector('.price').textContent.replace('Price: $','')); // Get price from card

                    const existingCartItemIndex = cart.findIndex(item => item.name === productName);

                    if (existingCartItemIndex > -1) {
                        cart[existingCartItemIndex].quantity++;
                    } else {
                        cart.push({ name: productName, price: productPrice, quantity: 1 });
                    }

                    updateCartDisplay();
                    updatePlaceOrderButtonState();
                });
            });

            function updateCartDisplay() {
                cartItemList.innerHTML = '';
                let totalPrice = 0;

                if (cart.length === 0) {
                    emptyCartMessage.style.display = 'block';
                    orderTotalDisplay.style.display = 'none';
                } else {
                    emptyCartMessage.style.display = 'none';
                    orderTotalDisplay.style.display = 'block';

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
                const increaseButtons = document.querySelectorAll('.increase-quantity');
                const decreaseButtons = document.querySelectorAll('.decrease-quantity');

                increaseButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const productName = this.dataset.productName;
                        adjustQuantity(productName, 1);
                    });
                });

                decreaseButtons.forEach(button => {
                    button.addEventListener('click', function() {
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

            tableNumberInput.addEventListener('input', function() {
                updatePlaceOrderButtonState();
            });

            reviewOrderButton.addEventListener('click', function() { // "Review Order" button click handler
                if (cart.length === 0 || tableNumberInput.value.trim() === '') {
                    alert("Please add items to your cart and enter your table number.");
                    return;
                }

                // --- Display Order Review Section ---
                orderReviewSection.style.display = 'block'; // Show the review section

                // Populate order review items list and total
                orderReviewItemsList.innerHTML = ''; // Clear previous review items
                let reviewTotal = 0;
                cart.forEach(item => {
                    const listItem = document.createElement('li');
                    const itemTotal = item.price * item.quantity;
                    reviewTotal += itemTotal;
                    listItem.textContent = `${item.name} x ${item.quantity} - $${itemTotal.toFixed(2)}`;
                    orderReviewItemsList.appendChild(listItem);
                });
                orderReviewTotalDisplay.textContent = `Total: $${reviewTotal.toFixed(2)}`;

                // Hide the cart display and "Review Order" button itself (optional, for cleaner UI in review)
                cartItemsDiv.style.display = 'none';
                reviewOrderButton.style.display = 'none';
            });

            confirmOrderButton.addEventListener('click', function() { // "Confirm Order" button click handler
                const tableNumber = tableNumberInput.value.trim();
                const orderData = {
                    table_number: tableNumber,
                    cart_items: cart
                };

                fetch('/orders', { // ... fetch request - same as before for "Place Order" ...
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

                    // Hide review section and confirmation after order
                    orderReviewSection.style.display = 'none';
                    setTimeout(function() {
                        orderConfirmationMessageDiv.style.display = 'none';
                    }, 5000);
                })
                .catch(error => {
                    console.error('Error placing order:', error);
                    alert('Failed to place order. Please try again.');
                });
            });

            backToMenuButton.addEventListener('click', function() { // "Back to Menu" button click handler
                // Hide review section, show cart and "Review Order" button again
                orderReviewSection.style.display = 'none';
                cartItemsDiv.style.display = 'block';
                reviewOrderButton.style.display = 'inline-block'; // Or 'block', depending on your layout
            });


            updateCartDisplay(); // Initial cart display
            updatePlaceOrderButtonState(); // Initial button state
        });
    </script>

</body>

</html>