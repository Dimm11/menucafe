<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Menu</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Modal Styles - Updated to match design */
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
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 70%;
            border-radius: 8px;
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .modal-product-image-container {
            text-align: center;
        }

        .modal-product-image {
            max-width: 90%;
            max-height: 300px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
            object-fit: contain;
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
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-cart-icon {
            font-size: 24px;
            color: #555;
        }

        .modal-quantity-controls {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .quantity-button {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #eee;
            cursor: pointer;
            font-size: 16px;
        }

        .quantity-button:hover {
            background-color: #ddd;
        }

        .item-quantity {
            margin: 0 10px;
            font-size: 18px;
        }

        #modal-add-to-cart-button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-bottom: 15px;
        }

        #modal-add-to-cart-button:hover {
            background-color: #45a049;
        }

        .modal-back-button {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            cursor: pointer;
            color: #333;
        }

        .modal-back-button i {
            margin-right: 5px;
            font-size: 18px;
        }

        .close-button {
            color: #aaa;
            position: absolute;
            top: 0;
            right: 0;
            font-size: 28px;
            font-weight: bold;
            padding: 0 10px;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
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
            padding: 10px;
            background-color: #f8f9fa; /* Light background */
            border-radius: 50%; /* Circular shape */
            color: #495057; /* Dark gray color */
            text-decoration: none;
            transition: background-color 0.3s ease; /* Smooth hover effect */
            opacity: 0.8; /* Slightly transparent initially */
        }

        #cart-icon-link:hover {
            background-color: #e9ecef; /* Slightly darker on hover */
            opacity: 1; /* Fully opaque on hover */
        }

        #cart-icon-link[disabled] {
            opacity: 0.5; /* More transparent when disabled */
            cursor: default; /* No pointer cursor when disabled */
            pointer-events: none; /* Prevent clicks when disabled */
        }

        #cart-icon-link i {
            font-size: 24px; /* Size of the cart icon */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Font Awesome for icons -->
</head>

<body>
    <h1>Our Menu</h1>

    <div>
        <label for="table-number">Table Number:</label>
        <input type="text" id="table-number" name="table_number">
    </div>

    <div id="product-grid"
        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px;">
        {{-- Product Grid Container --}}
        @foreach ($products as $product)
            <div class="product-card"
                style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);"
                data-product-id="{{ $product->id }}" data-product-nama="{{ $product->nama }}"
                data-product-deskripsi="{{ $product->deskripsi }}" data-product-harga="{{ $product->harga }}"
                data-product-pict="{{ $product->product_pict }}"> {{-- Product Card Container --}}
                <img src="{{ $product->product_pict }}" alt="{{ $product->nama }}"
                    style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 10px;"> {{-- Product Image --}}
                <h3 style="margin-bottom: 5px;">{{ $product->nama }}</h3> {{-- Product Name --}}
                <p style="color: #777; margin-bottom: 10px;">{{ $product->deskripsi }}</p> {{-- Product Description --}}
                <p class="price" style="font-weight: bold; margin-bottom: 15px;">Price:
                    ${{ number_format($product->harga, 2) }}</p> {{-- Product Price --}}
                <button class="detail-button"
                    style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Detail</button>
                {{-- Detail Button --}}
            </div>
        @endforeach
    </div>

    <div id="cart-icon-container">
        <a href="{{ route('cart.index') }}" id="cart-icon-link" disabled>
            <i class="fas fa-shopping-cart"></i>
        </a>
    </div>


    <div id="order-confirmation-message" style="display: none; margin-top: 20px; padding: 15px; border: 1px solid #ccc; background-color: #e0f7fa;">
    </div>

    <!-- The Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-product-image-container">
                <img id="modal-product-pict" src="" alt="Product Picture" class="modal-product-image">
            </div>
            <div class="modal-product-details">
                <div class="modal-header">
                    <h2 id="modal-product-nama"></h2>
                    <i class="fas fa-shopping-cart modal-cart-icon"></i>
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
            <span class="close-button">×</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const detailButtons = document.querySelectorAll('.detail-button');
            const reviewOrderButton = document.getElementById('cart-icon-link'); // Changed to cart icon link
            const orderConfirmationMessageDiv = document.getElementById('order-confirmation-message');
            const tableNumberInput = document.getElementById('table-number');

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
            }

            detailButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productCard = this.closest('.product-card');
                    selectedProduct = {
                        id: productCard.dataset.productId,
                        nama: productCard.dataset.productNama,
                        deskripsi: productCard.dataset.productDeskripsi,
                        harga: parseFloat(productCard.dataset.productHarga),
                        pict: productCard.dataset.productPict
                    };

                    modalProductPict.src = selectedProduct.pict;
                    modalProductNama.textContent = selectedProduct.nama;
                    modalProductDeskripsi.textContent = selectedProduct.deskripsi;
                    modalProductHarga.textContent = `Price: $${selectedProduct.harga.toFixed(2)}`;
                    modalQuantity = 1;
                    modalItemQuantityDisplay.textContent = modalQuantity;

                    productModal.style.display = "block";
                });
            });

            modalAddToCartButton.addEventListener('click', function () {
                if (selectedProduct) {
                    const productName = selectedProduct.nama;
                    const productPrice = selectedProduct.harga;
                    const productPict = selectedProduct.pict;
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