<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Checkout Page Styles - Based on Index Page */
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

        .checkout-container {
            width: 600px; /* Fixed width */
            margin: 20px auto;
            background-color: #ffffff; /* White background */
            padding: 30px; /* Increased padding */
            border-radius: 10px; /* More rounded corners */
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1); /* Softer shadow */
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee; /* Add a separator */
            padding-bottom: 10px;
        }

        .checkout-summary {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0d9c6; /* Lighter border */
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px; /* Increased margin */
            color: #555;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px; /* Increased margin */
            padding-top: 10px;
            border-top: 1px solid #ddd;
            color: #7b5c45; /* Matching the sort button */
        }

        .checkout-form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #5a3e2b; /* Dark brown */
        }

        .checkout-form input[type="number"],
        .checkout-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* to include padding in width */
            appearance: none; /* Remove default arrow in some browsers */
            -webkit-appearance: none; /* For Safari and Chrome */
            /* Removed background-image to remove dropdown icon */
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: 5px;
            font-size: 16px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }

        .checkout-button {
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
        }

        .checkout-button:hover {
            background-color: #45a049;
        }

        .back-to-cart-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            color: #5a3e2b; /* Dark brown */
            text-decoration: none;
            margin-top: 20px; /* Increased margin */
            font-size: 1em;
            transition: color 0.3s ease;
        }

        .back-to-cart-button:hover {
            color: #7b5c45; /* Cafe brown on hover */
        }

        .back-to-cart-button i {
            margin-right: 8px; /* Increased margin */
            font-size: 20px; /* Larger icon */
        }
        /* Style for number input arrows to be removed in some browsers */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }

        #qris-image {
            display: none; /* Hidden by default */
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            border: 1px solid #e0d9c6;
            border-radius: 8px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h2>Checkout</h2>
        </div>

        <div class="checkout-summary">
            <h3>Ringkasan</h3>
            <div class="summary-item">
                <span>Jumlah Item</span>
                <span id="checkout-summary-items-count">0</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span id="checkout-summary-total-price">Rp. 0</span>
            </div>
        </div>

        <form id="checkout-form" class="checkout-form">
            <div class="checkout-form-group">
                <label for="table_number">No. Meja</label>
                <input type="number" id="table_number" name="table_number" placeholder="Masukkan Nomor Meja" min="1" required>
            </div>

            <div class="checkout-form-group">
                <label for="payment_method">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method">
                    <option value="" selected disabled>-- Pilih Metode Pembayaran --</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Tunai">Tunai</option>
                </select>
                <div id="payment-method-info" style="margin-top: 10px; font-style: italic; color: #555;"></div>
                <img id="qris-image" src="{{ asset('assets/QRIS.jpg') }}" alt="QRIS Code">
            </div>

            <button type="submit" class="checkout-button">Checkout</button>
        </form>

        <a href="/cart" class="back-to-cart-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkoutSummaryItemsCount = document.getElementById('checkout-summary-items-count');
            const checkoutSummaryTotalPriceDisplay = document.getElementById('checkout-summary-total-price');
            const checkoutForm = document.getElementById('checkout-form');
            const paymentMethodSelect = document.getElementById('payment_method');
            const qrisImage = document.getElementById('qris-image');
            const paymentMethodInfo = document.getElementById('payment-method-info');
            // Removed checkoutButton reference as it's no longer disabled by script

            // Retrieve selected items from session storage
            let selectedCartItems = JSON.parse(sessionStorage.getItem('selectedCartItems') || '[]');

            // Check for table number in session storage and pre-fill if found
            const savedTableNumber = sessionStorage.getItem('tableNumber');
            const tableNumberInput = document.getElementById('table_number');
            if (savedTableNumber) {
                tableNumberInput.value = savedTableNumber;
                tableNumberInput.readOnly = true; // Make the input read-only
            }

            function updateCheckoutSummary() {
                let totalPrice = 0;
                let totalItems = 0;

                selectedCartItems.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    totalPrice += itemTotal;
                    totalItems += item.quantity;
                });

                checkoutSummaryItemsCount.textContent = totalItems;
            checkoutSummaryTotalPriceDisplay.textContent = `Rp. ${formatPrice(totalPrice)}`;
        }

        function formatPrice(price) {
            // Use Intl.NumberFormat to format price in Indonesian Rupiah style
            return new Intl.NumberFormat('id-ID').format(price);
        }

        // Function to show/hide QRIS image and display payment method info based on selection
        function handlePaymentMethodChange() {
            const selectedMethod = paymentMethodSelect.value;
            if (selectedMethod === 'QRIS') {
                qrisImage.style.display = 'block';
                paymentMethodInfo.textContent = "Harap konfirmasi pembayaran ke kasir";
            } else if (selectedMethod === 'Tunai') {
                qrisImage.style.display = 'none';
                paymentMethodInfo.textContent = "Harap melakukan pembayaran di kasir";
            } else {
                qrisImage.style.display = 'none';
                paymentMethodInfo.textContent = ""; // Clear text if no method is selected
            }
        }

            // Initial check on page load
            handlePaymentMethodChange();
            // Removed checkPaymentMethodSelection call and event listener

            // Add event listener for changes
            paymentMethodSelect.addEventListener('change', handlePaymentMethodChange);


            checkoutForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

                const tableNumber = document.getElementById('table_number').value;
                const paymentMethod = document.getElementById('payment_method').value;

                // Check if payment method is selected
                if (paymentMethod === "") {
                    alert("Mohon pilih metode pembayaran.");
                    return; // Stop form submission
                }

                if (!tableNumber) {
                    alert("Nomor meja harus diisi.");
                    return;
                }

                if (selectedCartItems.length > 0) {
                    // Prepare data to send to backend
                    const cartItemsForBackend = selectedCartItems.map(item => ({
                        name: item.name,
                        price: item.price,
                        quantity: item.quantity,
                    }));

                    const orderData = {
                        table_number: tableNumber,
                        metode_pembayaran: paymentMethod, // Include payment method if needed
                        cart_items: cartItemsForBackend,
                    };

                    // Send data to backend using fetch API
                    fetch('/orders', { // Assuming your Laravel route is defined as /api/work-orders
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(orderData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(`HTTP error! status: ${response.status}, message: ${err.message || 'Unknown error'}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert("Pesanan berhasil dibuat untuk nomor meja " + sessionStorage.getItem('tableNumber') +"! Nomor pesanan: " + data.order_id);

                        // Retrieve the main cart items
                        let mainCartItems = JSON.parse(sessionStorage.getItem('cart') || '[]');

                        // Get the names of the items that were just checked out
                        const checkedOutItemNames = selectedCartItems.map(item => item.name);

                        // Filter out the checked out items from the main cart
                        mainCartItems = mainCartItems.filter(item => !checkedOutItemNames.includes(item.name));

                        // Save the updated main cart back to session storage
                        sessionStorage.setItem('cart', JSON.stringify(mainCartItems));

                        // Clear selected items from session storage after successful checkout
                        sessionStorage.removeItem('selectedCartItems');

                        window.location.href = '/products'; // Redirect to products page after successful checkout (or any other page you want)
                    })
                    .catch(error => {
                        console.error('Error during checkout:', error);
                        alert("Terjadi kesalahan saat memproses pesanan: " + error.message);
                    });
                } else {
                    alert("Tidak ada item yang dipilih untuk checkout.");
                }
            });

            updateCheckoutSummary(); // Initial summary display on checkout page load
        });
    </script>
</body>

</html>
