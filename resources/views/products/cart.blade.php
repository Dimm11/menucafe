<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Assuming styles.css is your base CSS if needed -->
    <!-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f4e3; /* Light cafe background */
            color: #333;
        }

        h2 {
            text-align: center;
            color: #5a3e2b; /* Dark brown for headings */
            margin-bottom: 30px;
            font-family: 'Georgia', serif; /* More traditional font */
        }

        /* Cart Container - Desktop */
        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Main cart area and summary */
            gap: 30px; /* Increased gap */
            max-width: 960px;
            margin: 20px auto;
            background-color: #ffffff; /* White background */
            padding: 30px; /* Increased padding */
            border-radius: 10px; /* More rounded corners */
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1); /* Softer shadow */
        }

        .cart-items-section {
            border-right: 1px solid #e0d9c6; /* Lighter border */
            padding-right: 30px; /* Increased padding */
        }

        .cart-summary-section {
            padding-left: 30px; /* Increased padding */
        }

        /* Cart Header */
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee; /* Add a separator */
            padding-bottom: 10px;
        }

        .cart-title {
            font-size: 24px;
            margin: 0;
            color: #5a3e2b;
        }

        .cart-items-count {
            font-size: 16px;
            color: #777;
        }
        /* Added style for summary specific counts */
        .summary-items-label {
           font-size: 0.95em;
           color: #555;
        }


        /* Select All */
        .select-all {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: #5a3e2b;
        }

        .select-all input[type="checkbox"] {
            margin-right: 8px;
            cursor: pointer; /* Add cursor pointer */
            transform: scale(1.1); /* Slightly larger checkbox */
        }
         .select-all label {
             cursor: pointer; /* Make label clickable */
         }

        /* Cart Item - Desktop */
        .cart-item {
            display: grid;
            /* Checkbox, Image, Details, Price, Quantity Controls, Remove */
            grid-template-columns: auto auto 1fr auto auto auto;
            gap: 20px; /* Increased gap */
            padding: 15px 0;
            border-bottom: 1px solid #e0d9c6; /* Lighter border */
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item input[type="checkbox"] {
            justify-self: start;
            cursor: pointer; /* Add cursor pointer */
             transform: scale(1.1); /* Slightly larger checkbox */
        }

        .cart-item-image-container {
            width: 80px; /* Slightly larger image container */
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff; /* Ensure background for images */
        }

        .cart-item-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .cart-item-details {
            justify-self: start;
            padding-right: 10px; /* Added right padding for spacing before price */
        }

        .cart-item-name {
            font-weight: bold;
            margin-bottom: 5px;
            margin-top: 0; /* Ensure no extra top margin */
            color: #5a3e2b;
        }

        .cart-item-category {
            color: #666; /* Slightly darker gray */
            font-size: 0.9em;
            margin-top: 0; /* Ensure no extra top margin */
        }

        .cart-item-price {
            justify-self: end;
            font-weight: bold;
            color: #7b5c45; /* Matching the sort button */
            font-size: 1.1em;
            text-align: right; /* Align price text right */
            white-space: nowrap; /* Prevent price wrapping */
        }

        .cart-quantity-controls {
            display: flex;
            align-items: center;
            justify-self: end;
        }

        .quantity-button {
            padding: 8px 12px; /* Increased padding */
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #eee;
            cursor: pointer;
            font-size: 16px; /* Larger font */
            transition: background-color 0.3s ease;
            line-height: 1; /* Prevent extra height */
        }

        .quantity-button:hover {
            background-color: #ddd;
        }
        /* Prevent text selection on double click */
        .quantity-button {
           user-select: none;
           -webkit-user-select: none; /* Safari */
           -moz-user-select: none; /* Firefox */
           -ms-user-select: none; /* IE10+/Edge */
        }

        .item-quantity {
            margin: 0 10px;
            font-size: 18px; /* Larger font */
            font-weight: bold;
            color: #5a3e2b;
            min-width: 25px; /* Ensure space for quantity */
            text-align: center;
        }

        .remove-item-button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2em; /* Slightly larger icon */
            justify-self: end;
            transition: color 0.3s ease;
            padding: 5px; /* Add padding for easier clicking */
        }

        .remove-item-button:hover {
            color: #c82333;
        }

        /* Cart Summary */
        .cart-summary {
            padding: 20px;
            background-color: #f9f9f9; /* Slightly off-white */
            border-radius: 8px; /* Match container */
            box-shadow: 2px 2px 5px rgba(0,0,0,0.05); /* Subtle shadow */
            border: 1px solid #eee; /* Subtle border */
        }

        .cart-summary h3 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
            color: #5a3e2b;
            font-family: 'Georgia', serif;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px; /* Increased spacing */
            color: #555;
            font-size: 0.95em;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
            padding-top: 15px; /* Increased spacing */
            border-top: 1px solid #ddd;
            color: #7b5c45; /* Matching the sort button */
        }

        /* Buttons */
        .process-checkout-button {
            display: block;
            width: 100%;
            padding: 12px 15px; /* Increased padding */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px; /* Larger font */
            margin-top: 20px;
            transition: background-color 0.3s ease;
            text-align: center; /* Ensure text is centered */
            text-decoration: none; /* Remove underline if used as link */
            box-sizing: border-box; /* Include padding in width */
        }

        .process-checkout-button:hover {
            background-color: #45a049;
        }

        .process-checkout-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .back-to-menu-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            color: #5a3e2b; /* Dark brown */
            text-decoration: none;
            margin-top: 20px; /* Increased margin */
            font-size: 1em;
            transition: color 0.3s ease;
            padding: 8px 0; /* Add some vertical padding */
        }

        .back-to-menu-button:hover {
            color: #7b5c45; /* Cafe brown on hover */
        }

        .back-to-menu-button i { /* For arrow icon */
            margin-right: 8px; /* Increased margin */
            font-size: 20px; /* Larger icon */
        }

        /* Empty Cart Message */
        #empty-cart-message-cart-page {
            text-align: center;
            color: #777;
            font-style: italic;
            padding: 40px 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr; /* Stack sections on smaller screens */
                padding: 15px; /* Reduce padding */
                gap: 20px; /* Reduce gap */
            }

            .cart-items-section {
                border-right: none; /* Remove side border */
                border-bottom: 1px solid #e0d9c6; /* Add bottom border */
                padding-right: 0;
                padding-bottom: 20px;
                margin-bottom: 20px;
            }

            .cart-summary-section {
                padding-left: 0;
            }

            .cart-item {
                /* Checkbox, Image, Details+Price+Qty, Remove */
                grid-template-columns: auto auto 1fr auto;
                gap: 10px; /* Reduce gap */
                align-items: flex-start; /* Align items to top for better vertical layout */
            }

            /* Place details, price, quantity in the 3rd column */
            .cart-item-details {
                 grid-column: 3;
                 padding-right: 0; /* Remove padding */
            }

            .cart-item-price {
                grid-column: 3; /* Place in the same column as details */
                justify-self: start; /* Align price to the start below details */
                margin-top: 8px; /* Add space above price */
                font-size: 1em; /* Slightly smaller price */
                 text-align: left; /* Align left on mobile */
                 white-space: normal; /* Allow wrapping if needed */
            }

            .cart-quantity-controls {
                grid-column: 3; /* Place in the same column as details */
                justify-self: start; /* Align quantity controls to the start */
                margin-top: 8px; /* Add space above controls */
            }
            .quantity-button {
                padding: 6px 10px; /* Slightly smaller buttons */
                font-size: 14px;
            }
            .item-quantity {
                font-size: 16px;
                margin: 0 8px;
            }

             /* Keep remove button aligned right in the 4th column */
            .remove-item-button {
                 grid-column: 4;
                 justify-self: end;
                 align-self: center; /* Center vertically */
                 font-size: 1.1em;
            }

            .cart-title {
                font-size: 20px;
            }

            .cart-items-count {
                font-size: 14px;
            }

            .process-checkout-button {
                font-size: 16px;
                padding: 10px 12px;
            }
             .back-to-menu-button {
                 font-size: 0.95em;
             }
             .back-to-menu-button i {
                 font-size: 18px;
             }
        }

         /* Further adjustments for very small screens */
        @media (max-width: 480px) {
             .cart-item-image-container {
                 width: 60px;
                 height: 60px;
             }
             .cart-item-name {
                 font-size: 0.95em;
             }
             .cart-item-category {
                 font-size: 0.8em;
             }
             .select-all {
                 font-size: 0.9em;
             }
             .cart-header {
                 flex-direction: column; /* Stack title and count */
                 align-items: flex-start;
                 gap: 5px;
                 margin-bottom: 15px;
             }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <div class="cart-container">
        <section class="cart-items-section">
            <div class="cart-header">
                <h2 class="cart-title">Shopping Cart</h2>
                <!-- This count shows TOTAL items in cart -->
                <span class="cart-items-count"> <span id="cart-total-item-count-header">0</span> Total Items</span>
            </div>
            <div class="select-all">
                <input type="checkbox" id="select-all-checkbox">
                <label for="select-all-checkbox">Select All</label>
            </div>

            <div id="cart-item-list-container">
                <p id="empty-cart-message-cart-page" style="display:none;">Your cart is empty.</p>
                <ul id="cart-item-list-cart-page" style="list-style: none; padding-left: 0;">
                    <!-- Cart items will be rendered here by JavaScript -->
                </ul>
            </div>

            <a href="/products" class="back-to-menu-button"> <!-- Assuming /products is your menu page -->
                <i class="fas fa-arrow-left"></i> Kembali ke Menu
            </a>
        </section>

        <section class="cart-summary-section">
            <div class="cart-summary">
                <h3>Summary (Selected Items)</h3>
                <div class="summary-item">
                    <span class="summary-items-label">Selected Items</span>
                    <span id="summary-selected-items-count">0</span>
                </div>
                <div class="summary-total">
                    <span>Total Price</span>
                    <span id="summary-selected-total-price">Rp. 0</span>
                </div>
                <!-- Updated link to use route() helper if blade -->
                <a href="{{ route('checkout.index') }}" class="process-checkout-button" id="process-checkout-button" role="button" disabled>Process Checkout</a>
            </div>
        </section>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartItemList = document.getElementById('cart-item-list-cart-page');
        const cartTotalItemCountHeader = document.getElementById('cart-total-item-count-header');
        const summarySelectedItemsCount = document.getElementById('summary-selected-items-count');
        const summarySelectedTotalPriceDisplay = document.getElementById('summary-selected-total-price');
        const emptyCartMessage = document.getElementById('empty-cart-message-cart-page');
        const processCheckoutButton = document.getElementById('process-checkout-button');
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const cartItemListContainer = document.getElementById('cart-item-list-container');

        let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');

        // --- Helper Functions ---

        function formatPrice(price) {
            const numericPrice = Number(price);
            if (isNaN(numericPrice)) {
                return '0';
            }
            return numericPrice.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function saveCart() {
            sessionStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateSummaryAndCheckoutState() {
            let selectedTotalPrice = 0;
            let selectedItemsCount = 0;
            let anySelected = false;

            cart.forEach(item => {
                // Ensure selected property exists, default to true if not
                if (item.selected === undefined) {
                    item.selected = true; // Default new/untracked items to selected
                }
                if (item.selected) {
                    const itemQuantity = Number(item.quantity) || 0;
                    const itemPrice = Number(item.price) || 0;
                    selectedTotalPrice += itemPrice * itemQuantity;
                    selectedItemsCount += itemQuantity;
                    anySelected = true;
                }
            });

            summarySelectedItemsCount.textContent = selectedItemsCount;
            summarySelectedTotalPriceDisplay.textContent = `Rp. ${formatPrice(selectedTotalPrice)}`;

            const canCheckout = cart.length > 0 && anySelected;
            processCheckoutButton.disabled = !canCheckout;

            if (!canCheckout) {
                processCheckoutButton.removeAttribute('href');
            } else {
                const checkoutUrl = "{{ route('checkout.index') }}"; // Ensure correct URL
                processCheckoutButton.setAttribute('href', checkoutUrl);
            }

            updateSelectAllCheckboxState(); // Keep select-all checkbox synced
        }

        function updateSelectAllCheckboxState() {
            if (cart.length === 0) { // Check cart array length first
                selectAllCheckbox.checked = false;
                selectAllCheckbox.disabled = true;
            } else {
                selectAllCheckbox.disabled = false;
                // Check if *every* item in the cart data is selected
                selectAllCheckbox.checked = cart.every(item => item.selected);
            }
        }

        // --- Event Handler Logic ---

        function handleQuantityChange(event) {
            const button = event.target;
            const productIndex = parseInt(button.closest('.cart-item').querySelector('.cart-item-checkbox').dataset.productIndex); // Find index reliably
            const change = button.classList.contains('increase-quantity') ? 1 : -1;

            if (cart[productIndex]) {
                let currentQuantity = Number(cart[productIndex].quantity) || 0;
                let newQuantity = currentQuantity + change;

                if (newQuantity < 1) {
                    if (confirm('Set quantity to 0? This will remove the item from your cart.')) {
                        removeItemFromCart(productIndex);
                    }
                    return;
                }

                cart[productIndex].quantity = newQuantity;
                saveCart();
                updateCartDisplay(); // Full redraw needed to update item price span
            }
        }

        function handleRemoveItem(event) {
            const button = event.currentTarget; // Use currentTarget
             // Find the index from the checkbox within the same cart item
            const productIndex = parseInt(button.closest('.cart-item').querySelector('.cart-item-checkbox').dataset.productIndex);
            if (confirm('Are you sure you want to remove this item from the cart?')) {
                removeItemFromCart(productIndex);
            }
        }

        function handleItemSelectionChange(event) {
            const checkbox = event.target;
            const productIndex = parseInt(checkbox.dataset.productIndex);
            if (cart[productIndex]) {
                cart[productIndex].selected = checkbox.checked;
                saveCart();
                // Only need to update summary, checkout button, and select-all checkbox state
                // No need for a full redraw which would lose focus etc.
                updateSummaryAndCheckoutState();
            } else {
                 console.error("Cart item not found at index for selection change:", productIndex);
            }
        }

        function handleSelectAllChange() {
            const isChecked = selectAllCheckbox.checked;
            cart.forEach((item, index) => {
                item.selected = isChecked;
                // Update visual checkbox in the DOM as well
                const itemCheckbox = cartItemList.querySelector(`.cart-item-checkbox[data-product-index="${index}"]`);
                if (itemCheckbox) {
                    itemCheckbox.checked = isChecked;
                }
            });
            saveCart();
            updateSummaryAndCheckoutState(); // Update summary based on new selections
        }

        function removeItemFromCart(productIndex) {
            if (productIndex >= 0 && productIndex < cart.length) {
                cart.splice(productIndex, 1);
                // Important: After removing an item, the indices of subsequent items change.
                // A full redraw is the safest way to handle this.
                saveCart();
                updateCartDisplay();
            }
        }

        // --- Main Display Function ---

        function updateCartDisplay() {
            // Store focused element before clearing
            const focusedElement = document.activeElement;
            const focusedIndex = focusedElement?.closest('.cart-item')?.querySelector('.cart-item-checkbox')?.dataset.productIndex;
            const focusedIsCheckbox = focusedElement?.classList.contains('cart-item-checkbox');
            const focusedIsQuantity = focusedElement?.classList.contains('item-quantity') || focusedElement?.classList.contains('quantity-button');


            cartItemList.innerHTML = ''; // Clear current list content
            let totalItemsInCart = 0;

            if (cart.length === 0) {
                emptyCartMessage.style.display = 'block';
                cartItemList.style.display = 'none';
                cartItemListContainer.style.minHeight = '100px';
            } else {
                emptyCartMessage.style.display = 'none';
                cartItemList.style.display = 'block';
                cartItemListContainer.style.minHeight = 'auto';

                cart.forEach((item, index) => {
                    // Ensure necessary properties exist and have valid types
                    item.quantity = Number(item.quantity) || 1;
                    item.price = Number(item.price) || 0;
                    if (item.selected === undefined) {
                        item.selected = true; // Default selection
                    }

                    totalItemsInCart += item.quantity;
                    const itemTotal = item.price * item.quantity;
                    const imageUrl = (item.pict && item.pict !== '') ? item.pict : 'https://placehold.co/80x80?text=No+Image';

                    const listItem = document.createElement('li');
                    listItem.classList.add('cart-item');
                    // Assign index to the list item itself for easier lookups later if needed
                    listItem.dataset.index = index;

                    listItem.innerHTML = `
                        <input type="checkbox" class="cart-item-checkbox" data-product-index="${index}" ${item.selected ? 'checked' : ''}>
                        <div class="cart-item-image-container">
                            <img src="${imageUrl}" alt="${item.name || 'Product Image'}" class="cart-item-image">
                        </div>
                        <div class="cart-item-details">
                            <h4 class="cart-item-name">${item.name || 'Unnamed Product'}</h4>
                            <p class="cart-item-category">${item.deskripsi || 'No description'}</p>
                        </div>
                        <span class="cart-item-price">Rp. ${formatPrice(itemTotal)}</span>
                        <div class="cart-quantity-controls">
                            <button class="quantity-button decrease-quantity">-</button>
                            <span class="item-quantity">${item.quantity}</span>
                            <button class="quantity-button increase-quantity">+</button>
                        </div>
                        <button class="remove-item-button">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;

                    // --- Add Listeners Directly After Appending ---
                    cartItemList.appendChild(listItem);

                    // Find elements *within this specific listItem*
                    const checkbox = listItem.querySelector('.cart-item-checkbox');
                    const decreaseBtn = listItem.querySelector('.decrease-quantity');
                    const increaseBtn = listItem.querySelector('.increase-quantity');
                    const removeBtn = listItem.querySelector('.remove-item-button');

                    if (checkbox) checkbox.addEventListener('change', handleItemSelectionChange);
                    if (decreaseBtn) decreaseBtn.addEventListener('click', handleQuantityChange);
                    if (increaseBtn) increaseBtn.addEventListener('click', handleQuantityChange);
                    if (removeBtn) removeBtn.addEventListener('click', handleRemoveItem);
                    // --- End Listener Addition ---

                });
            }

            cartTotalItemCountHeader.textContent = totalItemsInCart;
            updateSummaryAndCheckoutState(); // Update summary/checkout based on initial/current state

            // Restore focus if possible (basic implementation)
            if (focusedIndex !== undefined) {
                 const itemToFocus = cartItemList.querySelector(`.cart-item[data-index="${focusedIndex}"]`);
                 if (itemToFocus) {
                     let elementToFocus = null;
                     if (focusedIsCheckbox) {
                         elementToFocus = itemToFocus.querySelector('.cart-item-checkbox');
                     } else if (focusedIsQuantity) {
                         // Try to focus quantity button or input if applicable
                         elementToFocus = itemToFocus.querySelector('.quantity-button') || itemToFocus.querySelector('.item-quantity');
                     }
                      // Add more conditions if other elements can be focused

                     if (elementToFocus) {
                         elementToFocus.focus();
                     }
                 }
            }
        }

        // --- Event Listener for Checkout Button ---
        processCheckoutButton.addEventListener('click', function(event) {
            // Prevent default link behavior initially
            // event.preventDefault(); // Keep default behavior to navigate

            // Filter selected items
            const selectedItems = cart.filter(item => item.selected);

            // Store selected items in sessionStorage
            sessionStorage.setItem('selectedCartItems', JSON.stringify(selectedItems));

            // Allow the default link behavior to proceed to the checkout page
            // The checkout page will read 'selectedCartItems' from sessionStorage
        });


        // --- Initial Setup ---
        selectAllCheckbox.addEventListener('change', handleSelectAllChange);
        updateCartDisplay(); // Initial draw and listener attachment

    });
</script>
</body>

</html>
