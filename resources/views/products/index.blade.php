<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>

<body>
    <h1>Menu Kami</h1>

    <div>
        <label for="table-number">Nomor Meja:</label>
        <input type="text" id="table-number" name="table_number" placeholder="Masukkan nomor meja">
    </div>

    <button id="sortButton">Urutkan Harga (Tertinggi)</button>

    <div id="product-grid" data-products='@json($products)'>
    </div>

    <div id="cart-icon-container">
        <a href="{{ route('cart.index') }}" id="cart-icon-link" disabled>
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count">0</span>
        </a>
    </div>

    <div id="order-confirmation-message">
    </div>

    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-product-image-container">
                <img id="modal-product-pict" src="" alt="Gambar Produk" class="modal-product-image">
            </div>
            <div class="modal-product-details">
                <div class="modal-header">
                    <h2 id="modal-product-nama"></h2>
                    <i class="fas fa-coffee modal-cart-icon"></i>
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reviewOrderButton = document.getElementById('cart-icon-link');
            const orderConfirmationMessageDiv = document.getElementById('order-confirmation-message');
            const tableNumberInput = document.getElementById('table-number');
            const sortButton = document.getElementById('sortButton');
            const productGrid = document.getElementById('product-grid');

            const productModal = document.getElementById('productModal');

            productModal.style.display = "none";

            let products = JSON.parse(productGrid.dataset.products);
            let sortedAscending = true;

            // algoritma bubble sort
            function bubbleSort(arr, ascending = true) {
                let len = arr.length;
                let swapped;
                do {
                    swapped = false;
                    for (let i = 0; i < len - 1; i++) {
                        const price1 = parseFloat(arr[i].harga);
                        const price2 = parseFloat(arr[i + 1].harga);

                        if (ascending) {
                            if (price1 > price2) {
                                let tmp = arr[i];
                                arr[i] = arr[i + 1];
                                arr[i + 1] = tmp;
                                swapped = true;
                            }
                        } else {
                            if (price1 < price2) {
                                let tmp = arr[i];
                                arr[i] = arr[i + 1];
                                arr[i + 1] = tmp;
                                swapped = true;
                            }
                        }
                    }
                } while (swapped);
                return arr;
            }

            function renderProducts(products) {
                productGrid.innerHTML = '';

                const makananSection = document.createElement('div');
                makananSection.classList.add('category-section');
                makananSection.innerHTML = '<h2>Makanan</h2><div class="product-list"></div>';

                const minumanSection = document.createElement('div');
                minumanSection.classList.add('category-section');
                minumanSection.innerHTML = '<h2>Minuman</h2><div class="product-list"></div>';

                const cemilanSection = document.createElement('div');
                cemilanSection.classList.add('category-section');
                cemilanSection.innerHTML = '<h2>Cemilan</h2><div class="product-list"></div>';

                productGrid.appendChild(makananSection);
                productGrid.appendChild(minumanSection);
                productGrid.appendChild(cemilanSection);

                const makananList = makananSection.querySelector('.product-list');
                const minumanList = minumanSection.querySelector('.product-list');
                const cemilanList = cemilanSection.querySelector('.product-list');


                products.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.classList.add('product-card');
                    productCard.dataset.productId = product.id;
                    productCard.dataset.productNama = product.nama;
                    productCard.dataset.productDeskripsi = product.deskripsi;
                    productCard.dataset.productHarga = product.harga;
                    productCard.dataset.productPict = product.product_pict;
                    productCard.dataset.productCategory = product.category;

                    const img = document.createElement('img');
                    img.src = product.product_pict ? '/' + product.product_pict : 'https://placehold.co/250x150?text=Tidak+Ada+Gambar';
                    img.alt = product.nama;

                    img.onerror = function() {
                        this.onerror = null;
                        this.src = 'https://placehold.co/250x150?text=Gagal+Memuat+Gambar';
                    };


                    const h3 = document.createElement('h3');
                    h3.textContent = product.nama;

                    const p = document.createElement('p');
                    p.textContent = product.deskripsi;

                    const price = document.createElement('p');
                    price.classList.add('price');
                    price.textContent = `Harga: Rp${parseInt(product.harga).toLocaleString('id-ID')}`;

                    const detailButton = document.createElement('button');
                    detailButton.classList.add('detail-button');
                    detailButton.textContent = 'Detail';

                    productCard.appendChild(img);
                    productCard.appendChild(h3);
                    productCard.appendChild(p);
                    productCard.appendChild(price);
                    productCard.appendChild(detailButton);

                    switch (product.category) {
                        case 1:
                            makananList.appendChild(productCard);
                            break;
                        case 2:
                            minumanList.appendChild(productCard);
                            break;
                        case 3:
                            cemilanList.appendChild(productCard);
                            break;
                        default:
                            break;
                    }
                });

                const newDetailButtons = document.querySelectorAll('.detail-button');
                newDetailButtons.forEach(button => {
                    button.addEventListener('click', detailButtonClickHandler);
                });
            }

            sortButton.addEventListener('click', function() {
                products = bubbleSort(products, sortedAscending);
                sortedAscending = !sortedAscending;
                sortButton.textContent = `Urutkan Harga (${sortedAscending ? 'Tertinggi' : 'Terendah'})`;
                renderProducts(products);
            });

            function detailButtonClickHandler() {
                const productCard = this.closest('.product-card');
                selectedProduct = {
                    id: productCard.dataset.productId,
                    nama: productCard.dataset.productNama,
                    deskripsi: productCard.dataset.productDeskripsi,
                    harga: parseFloat(productCard.dataset.productHarga),
                    pict: productCard.dataset.productPict,
                };

                modalProductPict.src = selectedProduct.pict ? '/' + selectedProduct.pict : 'https://placehold.co/400x300?text=Tidak+Ada+Gambar';

                modalProductPict.onerror = function() {
                    this.onerror = null;
                    this.src = 'https://placehold.co/400x300?text=Gagal+Memuat+Gambar';
                };

                modalProductNama.textContent = selectedProduct.nama;
                modalProductDeskripsi.textContent = selectedProduct.deskripsi;
                modalProductHarga.textContent = `Harga: Rp${parseInt(selectedProduct.harga).toLocaleString('id-ID')}`;
                modalQuantity = 1;
                modalItemQuantityDisplay.textContent = modalQuantity;

                productModal.style.display = "flex";
            }

            renderProducts(products);

            const modalProductPict = document.getElementById('modal-product-pict');
            const modalProductNama = document.getElementById('modal-product-nama');
            const modalProductDeskripsi = document.getElementById('modal-product-deskripsi');
            const modalProductHarga = document.getElementById('modal-product-harga');
            const modalAddToCartButton = document.getElementById('modal-add-to-cart-button');
            const modalBackButton = document.getElementById('modal-back-button');
            const modalDecreaseQuantityButton = document.getElementById('modal-decrease-quantity');
            const modalIncreaseQuantityButton = document.getElementById('modal-increase-quantity');
            const modalItemQuantityDisplay = document.getElementById('modal-item-quantity');


            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
            let selectedProduct = null;
            let modalQuantity = 1;

            function updatePlaceOrderButtonState() {
                if (cart.length > 0 && tableNumberInput.value.trim() !== '') {
                    reviewOrderButton.removeAttribute('disabled');
                } else {
                    reviewOrderButton.setAttribute('disabled', 'disabled');
                }
                sessionStorage.setItem('tableNumber', tableNumberInput.value.trim());
            }

            const savedTableNumber = sessionStorage.getItem('tableNumber');
            if (savedTableNumber) {
                tableNumberInput.value = savedTableNumber;
            }


            productGrid.addEventListener('click', function(event) {
                const detailButton = event.target.closest('.detail-button');
                if (detailButton) {
                    detailButtonClickHandler.call(detailButton);
                }
            });


            modalAddToCartButton.addEventListener('click', function() {
                const tableNumber = tableNumberInput.value.trim();
                if (tableNumber === '') {
                    alert('Mohon masukkan nomor meja sebelum menambahkan ke keranjang.');
                    return;
                }

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
                            deskripsi: productDeskripsi,
                            category: selectedProduct.category
                        });
                    }
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    updatePlaceOrderButtonState();
                    updateCartCountDisplay();
                    productModal.style.display = "none";
                    selectedProduct = null;
                    modalQuantity = 1;
                }
            });

            modalBackButton.addEventListener('click', function() {
                productModal.style.display = "none";
                selectedProduct = null;
                modalQuantity = 1;
            });


            window.addEventListener('click', function(event) {
                if (event.target == productModal) {
                    productModal.style.display = "none";
                    selectedProduct = null;
                    modalQuantity = 1;
                }
            });

            modalDecreaseQuantityButton.addEventListener('click', function() {
                if (modalQuantity > 1) {
                    modalQuantity--;
                    modalItemQuantityDisplay.textContent = modalQuantity;
                }
            });

            modalIncreaseQuantityButton.addEventListener('click', function() {
                modalQuantity++;
                modalItemQuantityDisplay.textContent = modalQuantity;
            });


            tableNumberInput.addEventListener('input', function() {
                updatePlaceOrderButtonState();
            });


            const cartCountSpan = document.getElementById('cart-count');

            function updateCartCountDisplay() {
                const cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCountSpan.textContent = totalItems;
            }

            updatePlaceOrderButtonState();
            updateCartCountDisplay();
        });
    </script>

</body>

</html>