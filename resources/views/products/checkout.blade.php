<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
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
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutSummaryItemsCount = document.getElementById('checkout-summary-items-count');
            const checkoutSummaryTotalPriceDisplay = document.getElementById('checkout-summary-total-price');
            const checkoutForm = document.getElementById('checkout-form');
            const paymentMethodSelect = document.getElementById('payment_method');
            const qrisImage = document.getElementById('qris-image');
            const paymentMethodInfo = document.getElementById('payment-method-info');

            let selectedCartItems = JSON.parse(sessionStorage.getItem('selectedCartItems') || '[]');

            const savedTableNumber = sessionStorage.getItem('tableNumber');
            const tableNumberInput = document.getElementById('table_number');
            if (savedTableNumber) {
                tableNumberInput.value = savedTableNumber;
                tableNumberInput.readOnly = true;
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
                return new Intl.NumberFormat('id-ID').format(price);
            }

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
                    paymentMethodInfo.textContent = "";
                }
            }

            handlePaymentMethodChange();

            paymentMethodSelect.addEventListener('change', handlePaymentMethodChange);


            checkoutForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const tableNumber = document.getElementById('table_number').value;
                const paymentMethod = document.getElementById('payment_method').value;

                if (paymentMethod === "") {
                    alert("Mohon pilih metode pembayaran.");
                    return;
                }

                if (!tableNumber) {
                    alert("Nomor meja harus diisi.");
                    return;
                }

                if (selectedCartItems.length > 0) {
                    const cartItemsForBackend = selectedCartItems.map(item => ({
                        name: item.name,
                        price: item.price,
                        quantity: item.quantity,
                    }));

                    const orderData = {
                        table_number: tableNumber,
                        metode_pembayaran: paymentMethod,
                        cart_items: cartItemsForBackend,
                    };

                    fetch('/orders', {
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
                            alert("Pesanan berhasil dibuat untuk nomor meja " + sessionStorage.getItem('tableNumber') + "! Nomor pesanan: " + data.order_id);

                            let mainCartItems = JSON.parse(sessionStorage.getItem('cart') || '[]');

                            const checkedOutItemNames = selectedCartItems.map(item => item.name);

                            mainCartItems = mainCartItems.filter(item => !checkedOutItemNames.includes(item.name));

                            sessionStorage.setItem('cart', JSON.stringify(mainCartItems));

                            sessionStorage.removeItem('selectedCartItems');

                            window.location.href = '/products';
                        })
                        .catch(error => {
                            console.error('Error during checkout:', error);
                            alert("Terjadi kesalahan saat memproses pesanan: " + error.message);
                        });
                } else {
                    alert("Tidak ada item yang dipilih untuk checkout.");
                }
            });

            updateCheckoutSummary();
        });
    </script>

</body>

</html>