<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="cart-container">
        <section class="cart-items-section">
            <div class="cart-header">
                <h2 class="cart-title">Keranjang</h2>
                <span class="cart-items-count"> <span id="cart-total-item-count-header">0</span> Total Item</span>
            </div>
            <div class="select-all">
                <input type="checkbox" id="select-all-checkbox">
                <label for="select-all-checkbox">Pilih Semua</label>
            </div>

            <div id="cart-item-list-container">
                <p id="empty-cart-message-cart-page" style="display:none;">Keranjang Anda kosong.</p>
                <ul id="cart-item-list-cart-page" style="list-style: none; padding-left: 0;">
                </ul>
            </div>

            <a href="/products" class="back-to-menu-button">
                <i class="fas fa-arrow-left"></i> Kembali ke Menu
            </a>
        </section>

        <section class="cart-summary-section">
            <div class="cart-summary">
                <h3>Ringkasan</h3>
                <div class="summary-item">
                    <span class="summary-items-label">Item Terpilih</span>
                    <span id="summary-selected-items-count">0</span>
                </div>
                <div class="summary-total">
                    <span>Total Harga</span>
                    <span id="summary-selected-total-price">Rp. 0</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="process-checkout-button" id="process-checkout-button" role="button" disabled>Proses Checkout</a>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartItemList = document.getElementById('cart-item-list-cart-page');
            const cartTotalItemCountHeader = document.getElementById('cart-total-item-count-header');
            const summarySelectedItemsCount = document.getElementById('summary-selected-items-count');
            const summarySelectedTotalPriceDisplay = document.getElementById('summary-selected-total-price');
            const emptyCartMessage = document.getElementById('empty-cart-message-cart-page');
            const processCheckoutButton = document.getElementById('process-checkout-button');
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const cartItemListContainer = document.getElementById('cart-item-list-container');

            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');

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
                    if (item.selected === undefined) {
                        item.selected = true;
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
                    const checkoutUrl = "{{ route('checkout.index') }}";
                    processCheckoutButton.setAttribute('href', checkoutUrl);
                }

                updateSelectAllCheckboxState();
            }

            function updateSelectAllCheckboxState() {
                if (cart.length === 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.disabled = true;
                } else {
                    selectAllCheckbox.disabled = false;
                    selectAllCheckbox.checked = cart.every(item => item.selected);
                }
            }

            function handleQuantityChange(event) {
                const button = event.target;
                const productIndex = parseInt(button.closest('.cart-item').querySelector('.cart-item-checkbox').dataset.productIndex);
                const change = button.classList.contains('increase-quantity') ? 1 : -1;

                if (cart[productIndex]) {
                    let currentQuantity = Number(cart[productIndex].quantity) || 0;
                    let newQuantity = currentQuantity + change;

                    if (newQuantity < 1) {
                        if (confirm('Atur jumlah menjadi 0? Ini akan menghapus item dari keranjang Anda.')) {
                            removeItemFromCart(productIndex);
                        }
                        return;
                    }

                    cart[productIndex].quantity = newQuantity;
                    saveCart();
                    updateCartDisplay();
                }
            }

            function handleRemoveItem(event) {
                const button = event.currentTarget;
                const productIndex = parseInt(button.closest('.cart-item').querySelector('.cart-item-checkbox').dataset.productIndex);
                if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
                    removeItemFromCart(productIndex);
                }
            }

            function handleItemSelectionChange(event) {
                const checkbox = event.target;
                const productIndex = parseInt(checkbox.dataset.productIndex);
                if (cart[productIndex]) {
                    cart[productIndex].selected = checkbox.checked;
                    saveCart();
                    updateSummaryAndCheckoutState();
                } else {
                    console.error("Cart item not found at index for selection change:", productIndex);
                }
            }

            function handleSelectAllChange() {
                const isChecked = selectAllCheckbox.checked;
                cart.forEach((item, index) => {
                    item.selected = isChecked;
                    const itemCheckbox = cartItemList.querySelector(`.cart-item-checkbox[data-product-index="${index}"]`);
                    if (itemCheckbox) {
                        itemCheckbox.checked = isChecked;
                    }
                });
                saveCart();
                updateSummaryAndCheckoutState();
            }

            function removeItemFromCart(productIndex) {
                if (productIndex >= 0 && productIndex < cart.length) {
                    cart.splice(productIndex, 1);
                    saveCart();
                    updateCartDisplay();
                }
            }

            function updateCartDisplay() {
                const focusedElement = document.activeElement;
                const focusedIndex = focusedElement?.closest('.cart-item')?.querySelector('.cart-item-checkbox')?.dataset.productIndex;
                const focusedIsCheckbox = focusedElement?.classList.contains('cart-item-checkbox');
                const focusedIsQuantity = focusedElement?.classList.contains('item-quantity') || focusedElement?.classList.contains('quantity-button');


                cartItemList.innerHTML = '';
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
                        item.quantity = Number(item.quantity) || 1;
                        item.price = Number(item.price) || 0;
                        if (item.selected === undefined) {
                            item.selected = true;
                        }

                        totalItemsInCart += item.quantity;
                        const itemTotal = item.price * item.quantity;
                        const imageUrl = (item.pict && item.pict !== '') ? item.pict : 'https://placehold.co/80x80?text=Tidak Ada Gambar';

                        const listItem = document.createElement('li');
                        listItem.classList.add('cart-item');
                        listItem.dataset.index = index;

                        listItem.innerHTML = `
                    <input type="checkbox" class="cart-item-checkbox" data-product-index="${index}" ${item.selected ? 'checked' : ''}>
                    <div class="cart-item-image-container">
                        <img src="${imageUrl}" alt="${item.name || 'Product Image'}" class="cart-item-image">
                    </div>
                    <div class="cart-item-details">
                        <h4 class="cart-item-name">${item.name || 'Produk Tanpa Nama'}</h4>
                        <p class="cart-item-category">${item.deskripsi || 'Tidak ada deskripsi'}</p>
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

                        cartItemList.appendChild(listItem);

                        const checkbox = listItem.querySelector('.cart-item-checkbox');
                        const decreaseBtn = listItem.querySelector('.decrease-quantity');
                        const increaseBtn = listItem.querySelector('.increase-quantity');
                        const removeBtn = listItem.querySelector('.remove-item-button');

                        if (checkbox) checkbox.addEventListener('change', handleItemSelectionChange);
                        if (decreaseBtn) decreaseBtn.addEventListener('click', handleQuantityChange);
                        if (increaseBtn) increaseBtn.addEventListener('click', handleQuantityChange);
                        if (removeBtn) removeBtn.addEventListener('click', handleRemoveItem);

                    });
                }

                cartTotalItemCountHeader.textContent = totalItemsInCart;
                updateSummaryAndCheckoutState();

                if (focusedIndex !== undefined) {
                    const itemToFocus = cartItemList.querySelector(`.cart-item[data-index="${focusedIndex}"]`);
                    if (itemToFocus) {
                        let elementToFocus = null;
                        if (focusedIsCheckbox) {
                            elementToFocus = itemToFocus.querySelector('.cart-item-checkbox');
                        } else if (focusedIsQuantity) {
                            elementToFocus = itemToFocus.querySelector('.quantity-button') || itemToFocus.querySelector('.item-quantity');
                        }

                        if (elementToFocus) {
                            elementToFocus.focus();
                        }
                    }
                }
            }

            processCheckoutButton.addEventListener('click', function(event) {
                const selectedItems = cart.filter(item => item.selected);
                sessionStorage.setItem('selectedCartItems', JSON.stringify(selectedItems));
            });


            selectAllCheckbox.addEventListener('change', handleSelectAllChange);
            updateCartDisplay();

        });
    </script>
</body>

</html>