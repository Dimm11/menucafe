<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* General Body Styling */
        body {
            font-family: 'Figtree', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8f4e3 0%, #f0e6d2 100%);
            color: #333;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(90, 62, 43, 0.02) 0%, transparent 60%),
                radial-gradient(circle at 75% 75%, rgba(139, 111, 71, 0.03) 0%, transparent 60%);
            animation: float 30s ease-in-out infinite;
            z-index: -1;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        h2 {
            text-align: center;
            color: #5a3e2b;
            margin-bottom: 40px;
            font-family: 'Playfair Display', 'Georgia', serif;
            font-size: 2.5em;
            font-weight: 700;
            background: linear-gradient(45deg, #5a3e2b, #8b6f47);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            opacity: 0;
            animation: fadeInDown 1s ease 0.3s forwards;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #5a3e2b, #8b6f47);
            border-radius: 2px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .checkout-container {
            max-width: 700px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(90, 62, 43, 0.1);
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 1s ease 0.6s forwards;
        }

        .checkout-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .checkout-container:hover::before {
            left: 100%;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(90, 62, 43, 0.1);
            padding-bottom: 20px;
        }

        .checkout-summary {
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(90, 62, 43, 0.05), rgba(139, 111, 71, 0.03));
            border-radius: 15px;
            border: 1px solid rgba(90, 62, 43, 0.1);
            backdrop-filter: blur(5px);
        }

        .checkout-summary h3 {
            color: #5a3e2b;
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
            font-size: 1.5em;
            text-align: center;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #555;
            font-size: 1.1em;
            padding: 5px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 1.3em;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid rgba(90, 62, 43, 0.2);
            color: #5a3e2b;
            background: linear-gradient(45deg, #5a3e2b, #8b6f47);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .checkout-form-group {
            margin-bottom: 25px;
        }

        .checkout-form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #5a3e2b;
            font-size: 1.1em;
        }

        .checkout-form input[type="number"],
        .checkout-form select {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid rgba(90, 62, 43, 0.2);
            border-radius: 15px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
        }

        .checkout-form input[type="number"]:focus,
        .checkout-form select:focus {
            outline: none;
            border-color: #8b6f47;
            box-shadow: 0 0 20px rgba(139, 111, 71, 0.2);
            transform: translateY(-2px);
        }

        /* Style for number input arrows to be removed */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        #payment-method-info {
            margin-top: 15px;
            font-style: italic;
            color: #666;
            padding: 10px;
            background: rgba(139, 111, 71, 0.05);
            border-radius: 10px;
            border-left: 4px solid #8b6f47;
        }

        #qris-image {
            display: none;
            max-width: 100%;
            height: auto;
            margin-top: 20px;
            border: 1px solid rgba(90, 62, 43, 0.2);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #qris-image:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .checkout-button {
            display: block;
            width: 100%;
            padding: 18px 20px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            margin-top: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
        }

        .checkout-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .checkout-button:hover::before {
            left: 100%;
        }

        .checkout-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(76, 175, 80, 0.4);
        }

        .back-to-cart-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #5a3e2b;
            text-decoration: none;
            margin-top: 25px;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 15px 25px;
            border-radius: 15px;
            background: rgba(90, 62, 43, 0.05);
            border: 1px solid rgba(90, 62, 43, 0.1);
            width: 100%;
        }

        .back-to-cart-button:hover {
            color: #8b6f47;
            background: rgba(139, 111, 71, 0.1);
            border-color: rgba(139, 111, 71, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(90, 62, 43, 0.1);
        }

        .back-to-cart-button i {
            margin-right: 10px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .back-to-cart-button:hover i {
            transform: translateX(-3px);
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            h2 {
                font-size: 2em;
                margin-bottom: 30px;
            }

            .checkout-container {
                margin: 10px auto;
                padding: 30px 20px;
                max-width: 100%;
            }

            .checkout-summary {
                padding: 20px;
            }

            .checkout-summary h3 {
                font-size: 1.3em;
            }

            .summary-item,
            .summary-total {
                font-size: 1em;
            }

            .checkout-form-group label {
                font-size: 1em;
            }

            .checkout-form input[type="number"],
            .checkout-form select {
                padding: 12px 15px;
                font-size: 16px;
            }

            .checkout-button {
                padding: 15px 20px;
                font-size: 16px;
            }

            .back-to-cart-button {
                padding: 12px 20px;
                font-size: 1em;
            }

            .back-to-cart-button i {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            h2 {
                font-size: 1.8em;
            }

            .checkout-container {
                padding: 25px 15px;
            }

            .checkout-summary {
                padding: 15px;
            }

            .checkout-summary h3 {
                font-size: 1.2em;
            }

            .summary-item,
            .summary-total {
                font-size: 0.95em;
            }

            .checkout-form input[type="number"],
            .checkout-form select {
                padding: 10px 15px;
            }

            .checkout-button {
                padding: 12px 15px;
                font-size: 15px;
            }

            #payment-method-info {
                font-size: 0.9em;
                padding: 8px;
            }
        }

        /* Animation delays for staggered entrance */
        .checkout-summary {
            opacity: 0;
            animation: fadeInUp 1s ease 0.9s forwards;
        }

        .checkout-form-group:nth-child(1) {
            opacity: 0;
            animation: fadeInUp 1s ease 1.2s forwards;
        }

        .checkout-form-group:nth-child(2) {
            opacity: 0;
            animation: fadeInUp 1s ease 1.5s forwards;
        }

        .checkout-button {
            opacity: 0;
            animation: fadeInUp 1s ease 1.8s forwards;
        }

        .back-to-cart-button {
            opacity: 0;
            animation: fadeInUp 1s ease 2.1s forwards;
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
            <h3>Ringkasan Pesanan</h3>
            <div class="summary-item">
                <span>Jumlah Item</span>
                <span id="checkout-summary-items-count">0</span>
            </div>
            <div class="summary-total">
                <span>Total Pembayaran</span>
                <span id="checkout-summary-total-price">Rp. 0</span>
            </div>
        </div>

        <form id="checkout-form" class="checkout-form">
            <div class="checkout-form-group">
                <label for="table_number">Nomor Meja</label>
                <input type="number" id="table_number" name="table_number" placeholder="Masukkan Nomor Meja" min="1" required>
            </div>

            <div class="checkout-form-group">
                <label for="payment_method">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="" selected disabled>-- Pilih Metode Pembayaran --</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Tunai">Tunai</option>
                </select>
                <div id="payment-method-info"></div>
                <img id="qris-image" src="assets/QRIS.jpg" alt="QRIS Code">
            </div>

            <button type="submit" class="checkout-button">
                <i class="fas fa-credit-card"></i> Proses Checkout
            </button>
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
