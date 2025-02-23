<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Basic Styling for Checkout Page - Adjust as needed to match image */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .checkout-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .checkout-summary {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .checkout-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
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
            background-image: url('data:image/svg+xml;utf8,<svg fill="black" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
            background-repeat: no-repeat;
            background-position-x: 95%;
            background-position-y: 5px;
        }

        .checkout-button {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .checkout-button:hover {
            background-color: #218838;
        }

        .back-to-cart-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
        }

        .back-to-cart-button i {
            margin-right: 5px;
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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h2>Checkout</h2>
        </div>

        <div class="checkout-summary">
            <h3>Summary</h3>
            <div class="summary-item">
                <span>Items</span>
                <span id="checkout-summary-items-count">0</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span id="checkout-summary-total-price">Rp. 0</span>
            </div>
        </div>

        <form id="checkout-form" class="checkout-form">
            <div class="form-group">
                <label for="table_number">No. Meja</label>
                <input type="number" id="table_number" name="table_number" placeholder="Masukkan Nomor Meja" min="1" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Metode Pembayaran</label>
                <select id="payment_method" name="payment_method">
                    <option value="QRIS/Tunai">QRIS / Tunai</option>
                    <option value="Debit/Kredit">Debit / Kredit (Belum Tersedia)</option>
                </select>
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

            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]'); // Retrieve cart from session

            function updateCheckoutSummary() {
                let totalPrice = 0;
                let totalItems = 0;

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    totalPrice += itemTotal;
                    totalItems += item.quantity;
                });

                checkoutSummaryItemsCount.textContent = totalItems;
                checkoutSummaryTotalPriceDisplay.textContent = `Rp. ${formatPrice(totalPrice)}`;
            }

            function formatPrice(price) {
                return price.toFixed(0).replace(/\d(?=(\d{3})+(?!\d))/g, '$&.'); // Format to Indonesian Rupiah style
            }

            checkoutForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

                const tableNumber = document.getElementById('table_number').value;
                const paymentMethod = document.getElementById('payment_method').value;

                if (!tableNumber) {
                    alert("Nomor meja harus diisi.");
                    return;
                }

                if (cart.length > 0) {
                    // Prepare data to send to backend
                    const cartItemsForBackend = cart.map(item => ({
                        name: item.name,
                        price: item.price,
                        quantity: item.quantity,
                    }));

                    const orderData = {
                        table_number: tableNumber,
                        payment_method: paymentMethod, // Include payment method if needed
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
                        alert("Pesanan berhasil dibuat! Order ID: " + data.order_id);
                        sessionStorage.removeItem('cart'); // Clear cart after successful checkout
                        window.location.href = '/products'; // Redirect to products page after successful checkout (or any other page you want)
                    })
                    .catch(error => {
                        console.error('Error during checkout:', error);
                        alert("Terjadi kesalahan saat memproses pesanan: " + error.message);
                    });
                } else {
                    alert("Keranjang belanja kosong.");
                }
            });

            updateCheckoutSummary(); // Initial summary display on checkout page load
        });
    </script>
</body>

</html>