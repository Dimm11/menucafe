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
    <!-- Font Awesome untuk ikon -->
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

        h1 {
            text-align: center;
            color: #5a3e2b;
            margin-bottom: 40px;
            font-family: 'Playfair Display', 'Georgia', serif;
            font-size: 3em;
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

        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
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

        /* Table Number Input Styling */
        div {
            text-align: center;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeInUp 1s ease 0.6s forwards;
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

        label {
            font-weight: 600;
            color: #5a3e2b;
            margin-right: 15px;
            font-size: 1.1em;
            display: inline-block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            padding: 12px 20px;
            border: 2px solid rgba(90, 62, 43, 0.2);
            border-radius: 25px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            width: 250px;
            text-align: center;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #8b6f47;
            box-shadow: 0 0 20px rgba(139, 111, 71, 0.2);
            transform: translateY(-2px);
        }

        /* Sort Button Styling */
        #sortButton {
            display: block;
            margin: 0 auto 30px;
            padding: 15px 30px;
            background: linear-gradient(135deg, #5a3e2b, #8b6f47);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 5px 15px rgba(90, 62, 43, 0.3);
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fadeInUp 1s ease 0.9s forwards;
        }

        #sortButton::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        #sortButton:hover::before {
            left: 100%;
        }

        #sortButton:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(90, 62, 43, 0.4);
        }

        /* Product Grid Styling */
        #product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 30px;
            opacity: 0;
            animation: fadeInUp 1s ease 1.2s forwards;
        }

        .product-card {
            border: 1px solid rgba(90, 62, 43, 0.1);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .product-card:hover::before {
            left: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(90, 62, 43, 0.15);
            border-color: rgba(90, 62, 43, 0.3);
        }

        .product-card img {
            max-width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-card h3 {
            margin-bottom: 10px;
            color: #5a3e2b;
            font-family: 'Playfair Display', serif;
            font-size: 1.4em;
            font-weight: 600;
        }

        .product-card p {
            color: #666;
            margin-bottom: 15px;
            font-size: 0.95em;
            line-height: 1.6;
        }

        .product-card .price {
            font-weight: bold;
            margin-bottom: 20px;
            color: #8b6f47;
            font-size: 1.3em;
            background: linear-gradient(45deg, #8b6f47, #5a3e2b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-card .detail-button {
            padding: 12px 25px;
            background: linear-gradient(135deg, #8b6f47, #5a3e2b);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .product-card .detail-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .product-card .detail-button:hover::before {
            left: 100%;
        }

        .product-card .detail-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(90, 62, 43, 0.3);
        }

        /* Category Section Styling */
        .category-section {
            margin-bottom: 50px;
            grid-column: 1 / -1;
        }

        .category-section h2 {
            text-align: center;
            color: #5a3e2b;
            margin-bottom: 30px;
            font-family: 'Playfair Display', serif;
            font-size: 2.2em;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }

        .category-section h2::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #8b6f47, #5a3e2b);
            border-radius: 2px;
        }

        .category-section .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        /* Modal Styles - Enhanced */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            opacity: 1;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            margin: 5% auto;
            padding: 40px;
            border: 1px solid rgba(90, 62, 43, 0.1);
            width: 85%;
            max-width: 900px;
            border-radius: 25px;
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.show .modal-content {
            transform: scale(1);
        }

        .modal-product-image-container {
            text-align: center;
        }

        .modal-product-image {
            max-width: 100%;
            max-height: 400px;
            height: auto;
            border-radius: 15px;
            margin-bottom: 15px;
            object-fit: contain;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 20px;
            border-bottom: 2px solid rgba(90, 62, 43, 0.1);
            padding-bottom: 15px;
        }

        .modal-header h2 {
            margin: 0;
            color: #5a3e2b;
            font-family: 'Playfair Display', serif;
            font-size: 2em;
        }

        .modal-cart-icon {
            font-size: 32px;
            color: #8b6f47;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .modal-product-details p {
            margin-bottom: 20px;
            color: #555;
            line-height: 1.7;
            font-size: 1.1em;
        }

        #modal-product-harga {
            font-size: 1.5em;
            font-weight: bold;
            color: #8b6f47;
            margin-bottom: 25px;
            background: linear-gradient(45deg, #8b6f47, #5a3e2b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .modal-quantity-controls {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            justify-content: center;
            gap: 20px;
        }

        .quantity-button {
            padding: 12px 18px;
            border: 2px solid rgba(90, 62, 43, 0.2);
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            color: #5a3e2b;
            transition: all 0.3s ease;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-button:hover {
            background: linear-gradient(135deg, #8b6f47, #5a3e2b);
            color: white;
            border-color: #5a3e2b;
            transform: scale(1.1);
        }

        .item-quantity {
            font-size: 24px;
            font-weight: bold;
            color: #5a3e2b;
            min-width: 40px;
            text-align: center;
        }

        #modal-add-to-cart-button {
            padding: 15px 20px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            width: 100%;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        #modal-add-to-cart-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        #modal-add-to-cart-button:hover::before {
            left: 100%;
        }

        #modal-add-to-cart-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.3);
        }

        .modal-back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #5a3e2b;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 15px;
        }

        .modal-back-button:hover {
            color: #8b6f47;
            background: rgba(139, 111, 71, 0.1);
        }

        .modal-back-button i {
            margin-right: 10px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .modal-back-button:hover i {
            transform: translateX(-3px);
        }

        .close-button {
            color: #aaa;
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 35px;
            font-weight: bold;
            padding: 0;
            transition: all 0.3s ease;
            line-height: 1;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .close-button:hover,
        .close-button:focus {
            color: #333;
            background: rgba(0, 0, 0, 0.1);
            text-decoration: none;
            cursor: pointer;
            transform: scale(1.1);
        }

        /* Shopping Cart Icon Styling */
        #cart-icon-container {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 1500;
        }

        #cart-icon-link {
            display: inline-block;
            padding: 18px;
            background: linear-gradient(135deg, #8b6f47, #5a3e2b);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(90, 62, 43, 0.3);
            position: relative;
            animation: float 3s ease-in-out infinite;
        }

        #cart-icon-link:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 15px 35px rgba(90, 62, 43, 0.4);
        }

        #cart-icon-link[disabled] {
            opacity: 0.5;
            cursor: default;
            pointer-events: none;
            background: linear-gradient(135deg, #ccc, #999);
        }

        #cart-icon-link i {
            font-size: 24px;
        }

        /* Cart Count Styling */
        #cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ff4757, #ff3742);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            box-shadow: 0 3px 10px rgba(255, 71, 87, 0.3);
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        /* Order Confirmation Message Styling */
        #order-confirmation-message {
            display: none;
            margin-top: 30px;
            padding: 20px;
            border: 2px solid #4CAF50;
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(69, 160, 73, 0.05));
            color: #2e7d32;
            border-radius: 15px;
            text-align: center;
            font-weight: 600;
            backdrop-filter: blur(5px);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.1);
        }

        /* Mobile Specific Styles for Modal */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            h1 {
                font-size: 2.2em;
                margin-bottom: 30px;
            }

            input[type="text"] {
                width: 200px;
            }

            #product-grid {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            .modal {
                align-items: flex-start;
                padding-top: 20px;
            }

            .modal-content {
                grid-template-columns: 1fr;
                margin-top: 20px;
                margin-bottom: 20px;
                width: 95%;
                padding: 30px 20px;
                gap: 25px;
            }

            .modal-product-image-container {
                margin-bottom: 20px;
            }

            .modal-product-image {
                max-height: 280px;
            }

            .modal-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .modal-header h2 {
                margin-bottom: 15px;
                font-size: 1.6em;
            }

            .category-section .product-list {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
            }

            .modal-quantity-controls {
                justify-content: center;
                gap: 15px;
            }

            #modal-add-to-cart-button {
                font-size: 16px;
            }

            #cart-icon-container {
                top: 20px;
                right: 20px;
            }

            #cart-icon-link {
                padding: 15px;
            }

            #cart-icon-link i {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8em;
            }

            input[type="text"] {
                width: 180px;
            }

            #product-grid {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            .product-card {
                padding: 20px;
            }

            .product-card img {
                height: 150px;
            }

            .category-section .product-list {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }
    </style>
</head>

<body>
    <h1>Menu Kami</h1>

    <div>
        <label for="table-number">Nomor Meja:</label>
        <input type="text" id="table-number" name="table_number" placeholder="Masukkan nomor meja">
    </div>

    <button id="sortButton">Urutkan Harga (Tertinggi)</button>

    <div id="product-grid" data-products='@json($products)'>
        {{-- Product Grid Container (populated by JS) --}}
    </div>

    <div id="cart-icon-container">
        <a href="{{ route('cart.index') }}" id="cart-icon-link" disabled>
            <i class="fas fa-shopping-cart"></i>
            <span id="cart-count">0</span>
        </a>
    </div>

    <div id="order-confirmation-message">
    </div>

    <!-- The Modal -->
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
                document.addEventListener('DOMContentLoaded', function () {
            const reviewOrderButton = document.getElementById('cart-icon-link');
            const orderConfirmationMessageDiv = document.getElementById('order-confirmation-message');
            const tableNumberInput = document.getElementById('table-number');
            const sortButton = document.getElementById('sortButton');
            const productGrid = document.getElementById('product-grid');

            const productModal = document.getElementById('productModal'); // Get modal reference early

            // Sembunyikan modal saat DOMContentLoaded
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
                productGrid.innerHTML = ''; // Clear existing products

                // Create category containers
                const makananSection = document.createElement('div');
                makananSection.classList.add('category-section');
                makananSection.innerHTML = '<h2>Makanan</h2><div class="product-list"></div>';

                const minumanSection = document.createElement('div');
                minumanSection.classList.add('category-section');
                minumanSection.innerHTML = '<h2>Minuman</h2><div class="product-list"></div>';

                const cemilanSection = document.createElement('div');
                cemilanSection.classList.add('category-section');
                cemilanSection.innerHTML = '<h2>Cemilan</h2><div class="product-list"></div>';

                // Append category sections to the product grid container
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
                    productCard.dataset.productCategory = product.category; // Add category data attribute

                    const img = document.createElement('img');
                    // Use product_pict path or a placeholder
                    img.src = product.product_pict ? '/' + product.product_pict : 'https://placehold.co/250x150?text=Tidak+Ada+Gambar';
                    img.alt = product.nama;

                    // Add an error handler for the image
                    img.onerror = function() {
                        this.onerror = null; // Prevent infinite loop if placeholder also fails
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

                    // Append product card to the correct category list
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
                            // Handle products with no category or unknown category if necessary
                            break;
                    }
                });

                // Re-attach event listeners to the new detail buttons
                const newDetailButtons = document.querySelectorAll('.detail-button');
                newDetailButtons.forEach(button => {
                    button.addEventListener('click', detailButtonClickHandler);
                });
            }

            sortButton.addEventListener('click', function () {
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

                // Use product_pict path or a placeholder
                modalProductPict.src = selectedProduct.pict ? '/' + selectedProduct.pict : 'https://placehold.co/400x300?text=Tidak+Ada+Gambar';

                // Add an error handler for the modal image
                modalProductPict.onerror = function() {
                    this.onerror = null; // Prevent infinite loop if placeholder also fails
                    this.src = 'https://placehold.co/400x300?text=Gagal+Memuat+Gambar';
                };

                modalProductNama.textContent = selectedProduct.nama;
                modalProductDeskripsi.textContent = selectedProduct.deskripsi;
                modalProductHarga.textContent = `Harga: Rp${parseInt(selectedProduct.harga).toLocaleString('id-ID')}`;
                modalQuantity = 1;
                modalItemQuantityDisplay.textContent = modalQuantity;

                productModal.style.display = "flex"; // Use flex to enable centering
            }

            // Initial rendering
            renderProducts(products);

            // Modal elements
            // const productModal = document.getElementById('productModal'); // Moved up
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
                 // Store table number in sessionStorage
                 sessionStorage.setItem('tableNumber', tableNumberInput.value.trim());
            }

             // Load table number from sessionStorage on page load
            const savedTableNumber = sessionStorage.getItem('tableNumber');
            if (savedTableNumber) {
                tableNumberInput.value = savedTableNumber;
            }


            // Event listener for product card click (delegation is more efficient)
            productGrid.addEventListener('click', function(event) {
                const detailButton = event.target.closest('.detail-button');
                if (detailButton) {
                    detailButtonClickHandler.call(detailButton);
                }
            });


            modalAddToCartButton.addEventListener('click', function () {
                const tableNumber = tableNumberInput.value.trim();
                if (tableNumber === '') {
                    alert('Mohon masukkan nomor meja sebelum menambahkan ke keranjang.');
                    return; // Stop the function if table number is empty
                }

                if (selectedProduct) {
                    const productName = selectedProduct.nama;
                    const productPrice = selectedProduct.harga;
                    // Determine the image URL to store in the cart.
                    // Use a placeholder if the original is null/empty OR if it failed to load.
                    // We'll use the modalProductPict's current src as it has the error handler.
                    const productPict = selectedProduct.pict; // Use the stored path
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
                            category: selectedProduct.category // Add category to cart item
                        });
                    }
                    sessionStorage.setItem('cart', JSON.stringify(cart)); // Save cart to session storage
                    updatePlaceOrderButtonState();
                    updateCartCountDisplay(); // Update cart count after adding item
                    productModal.style.display = "none";
                    selectedProduct = null;
                    modalQuantity = 1;
                }
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


            const cartCountSpan = document.getElementById('cart-count');

            function updateCartCountDisplay() {
                const cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                cartCountSpan.textContent = totalItems;
            }

            updatePlaceOrderButtonState(); // Initial button state
            updateCartCountDisplay(); // Initial cart count display
        });
    </script>

</body>

</html>
