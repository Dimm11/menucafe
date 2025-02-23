<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Shopping Cart Page Styles - Based on Image */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Main cart area and summary */
            gap: 20px;
            max-width: 960px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cart-items-section {
            border-right: 1px solid #eee;
            padding-right: 20px;
        }

        .cart-summary-section {
            padding-left: 20px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-title {
            font-size: 24px;
            margin: 0;
        }

        .cart-items-count {
            font-size: 16px;
            color: #777;
        }

        .select-all {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .select-all input[type="checkbox"] {
            margin-right: 8px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: auto 1fr auto auto auto auto; /* Checkbox, Image/Details, Price, Quantity Controls, Remove */
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item input[type="checkbox"] {
            justify-self: start;
        }

        .cart-item-image-container {
            width: 70px;
            height: 70px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cart-item-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .cart-item-details {
            justify-self: start;
        }

        .cart-item-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .cart-item-category {
            color: #777;
            font-size: 0.9em;
        }

        .cart-item-price {
            justify-self: end;
            font-weight: bold;
        }

        .cart-quantity-controls {
            display: flex;
            align-items: center;
            justify-self: end;
        }

        .quantity-button {
            padding: 5px 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #eee;
            cursor: pointer;
            font-size: 14px;
        }

        .item-quantity {
            margin: 0 10px;
            font-size: 16px;
        }

        .cart-summary {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .process-checkout-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .process-checkout-button:hover {
            background-color: #218838;
        }

        .back-to-menu-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
        }

        .back-to-menu-button i { /* For arrow icon */
            margin-right: 5px;
        }

        .remove-item-button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1em;
            justify-self: end;
        }

        .remove-item-button:hover {
            color: #c82333;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <div class="cart-container">
        <section class="cart-items-section">
            <div class="cart-header">
                <h2 class="cart-title">Shopping Cart</h2>
                <span class="cart-items-count"> <span id="cart-item-count-header">0</span> Items</span>
            </div>
            <div class="select-all">
                <input type="checkbox" id="select-all-checkbox">
                <label for="select-all-checkbox">Select All</label>
            </div>

            <div id="cart-item-list-container">
                <p id="empty-cart-message-cart-page" style="display:none;">Your cart is empty.</p>
                <ul id="cart-item-list-cart-page" style="list-style: none; padding-left: 0;">
                    <!-- Cart items will be rendered here -->
                </ul>
            </div>

            <a href="/products" class="back-to-menu-button">
                <i class="fas fa-arrow-left"></i> Kembali ke Menu
            </a>
        </section>

        <section class="cart-summary-section">
            <div class="cart-summary">
                <h3>Summary</h3>
                <div class="summary-item">
                    <span>Items</span>
                    <span id="summary-items-count">0</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span id="summary-total-price">Rp. 0</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="process-checkout-button" id="process-checkout-button" role="button" disabled>Process Checkout</a>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartItemList = document.getElementById('cart-item-list-cart-page');
            const cartItemCountHeader = document.getElementById('cart-item-count-header');
            const summaryItemsCount = document.getElementById('summary-items-count');
            const summaryTotalPriceDisplay = document.getElementById('summary-total-price');
            const emptyCartMessage = document.getElementById('empty-cart-message-cart-page');
            const processCheckoutButton = document.getElementById('process-checkout-button');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');

            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]'); // Retrieve cart from session

            function updateCartDisplay() {
                cartItemList.innerHTML = '';
                let totalPrice = 0;
                let totalItems = 0;
                let hasCheckedItem = false; // To track if any item is checked

                if (cart.length === 0) {
                    emptyCartMessage.style.display = 'block';
                    cartItemList.style.display = 'none';
                    processCheckoutButton.disabled = true;
                    selectAllCheckbox.checked = false; // Uncheck select all if cart is empty
                } else {
                    emptyCartMessage.style.display = 'none';
                    cartItemList.style.display = 'block';
                    processCheckoutButton.disabled = false;

                    cart.forEach((item, index) => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('cart-item');
                        const itemTotal = item.price * item.quantity;
                        totalPrice += itemTotal;
                        totalItems += item.quantity;

                        listItem.innerHTML = `
                            <input type="checkbox" class="cart-item-checkbox" data-product-index="${index}">
                            <div class="cart-item-image-container">
                                <img src="${item.pict}" alt="${item.name}" class="cart-item-image" onerror="this.src='{{ asset('fallback-product-image.png') }}'; this.alt='Fallback Image';">
                                <noscript>
                                    <img src="${item.pict}" alt="${item.name}" class="cart-item-image" onerror="this.src='{{ asset('fallback-product-image.png') }}'; this.alt='Fallback Image';">
                                </noscript>
                            </div>
                            <div class="cart-item-details">
                                <h4 class="cart-item-name">${item.name}</h4>
                                <p class="cart-item-category">${item.deskripsi}</p>  <!-- Using description as category placeholder -->
                            </div>
                            <span class="cart-item-price">Rp. ${formatPrice(itemTotal)}</span>
                            <div class="cart-quantity-controls">
                                <button class="quantity-button decrease-quantity" data-product-index="${index}">-</button>
                                <span class="item-quantity">${item.quantity}</span>
                                <button class="quantity-button increase-quantity" data-product-index="${index}">+</button>
                            </div>
                            <button class="remove-item-button" data-product-index="${index}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                        cartItemList.appendChild(listItem);
                    });
                }

                cartItemCountHeader.textContent = totalItems;
                summaryItemsCount.textContent = totalItems;
                summaryTotalPriceDisplay.textContent = `Rp. ${formatPrice(totalPrice)}`;
                addQuantityButtonEventListeners();
                addRemoveButtonEventListeners();
                addCartItemCheckboxEventListeners();
                updateSelectAllCheckboxState(); // Update Select All checkbox based on item checkboxes
            }

            function formatPrice(price) {
                return price.toFixed(0).replace(/\d(?=(\d{3})+(?!\d))/g, '$&.'); // Format to Indonesian Rupiah style
            }

            function addQuantityButtonEventListeners() {
                const increaseButtons = cartItemList.querySelectorAll('.increase-quantity');
                const decreaseButtons = cartItemList.querySelectorAll('.decrease-quantity');

                increaseButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const productIndex = parseInt(this.dataset.productIndex);
                        adjustQuantity(productIndex, 1);
                    });
                });

                decreaseButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const productIndex = parseInt(this.dataset.productIndex);
                        adjustQuantity(productIndex, -1);
                    });
                });
            }

            function adjustQuantity(productIndex, change) {
                if (cart[productIndex]) {
                    let newQuantity = cart[productIndex].quantity + change;
                    if (newQuantity < 1) newQuantity = 1; // Minimum quantity is 1
                    cart[productIndex].quantity = newQuantity;
                    if (cart[productIndex].quantity <= 0) {
                        cart.splice(productIndex, 1); // Remove from cart if quantity becomes 0 or less
                    }
                    sessionStorage.setItem('cart', JSON.stringify(cart)); // Update session cart
                    updateCartDisplay();
                }
            }

            function addRemoveButtonEventListeners() {
                const removeButtons = cartItemList.querySelectorAll('.remove-item-button');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const productIndex = parseInt(this.dataset.productIndex);
                        removeItemFromCart(productIndex);
                    });
                });
            }

            function removeItemFromCart(productIndex) {
                cart.splice(productIndex, 1);
                sessionStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
            }

            function addCartItemCheckboxEventListeners() {
                const itemCheckboxes = cartItemList.querySelectorAll('.cart-item-checkbox');
                itemCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectAllCheckboxState();
                    });
                });
            }

            function updateSelectAllCheckboxState() {
                const itemCheckboxes = Array.from(cartItemList.querySelectorAll('.cart-item-checkbox'));
                if (itemCheckboxes.length === 0) {
                    selectAllCheckbox.checked = false;
                } else {
                    selectAllCheckbox.checked = itemCheckboxes.every(checkbox => checkbox.checked);
                }
            }


            selectAllCheckbox.addEventListener('change', function() {
                const itemCheckboxes = cartItemList.querySelectorAll('.cart-item-checkbox');
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });


            


            updateCartDisplay(); // Initial cart display
        });
    </script>
</body>

</html>