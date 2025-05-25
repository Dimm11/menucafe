<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
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
            margin-bottom: 30px;
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

        /* Cart Container - Desktop */
        .cart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(90, 62, 43, 0.1);
            opacity: 0;
            animation: fadeInUp 1s ease 0.6s forwards;
            position: relative;
            overflow: hidden;
        }

        .cart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .cart-container:hover::before {
            left: 100%;
        }

        .cart-items-section {
            border-right: 1px solid rgba(90, 62, 43, 0.1);
            padding-right: 40px;
        }

        .cart-summary-section {
            padding-left: 40px;
        }

        /* Cart Header */
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(90, 62, 43, 0.1);
            padding-bottom: 20px;
        }

        .cart-title {
            font-size: 2em;
            margin: 0;
            color: #5a3e2b;
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .cart-items-count {
            font-size: 1.1em;
            color: #8b6f47;
            font-weight: 600;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.1), rgba(90, 62, 43, 0.05));
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        .summary-items-label {
           font-size: 1em;
           color: #555;
           font-weight: 500;
        }

        /* Select All */
        .select-all {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #5a3e2b;
            font-size: 1.1em;
            padding: 15px 20px;
            background: rgba(139, 111, 71, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(90, 62, 43, 0.1);
            transition: all 0.3s ease;
        }

        .select-all:hover {
            background: rgba(139, 111, 71, 0.1);
            transform: translateY(-2px);
        }

        .select-all input[type="checkbox"] {
            margin-right: 12px;
            cursor: pointer;
            transform: scale(1.3);
            accent-color: #8b6f47;
        }

        .select-all label {
             cursor: pointer;
        }

        /* Cart Item - Desktop */
        .cart-item {
            display: grid;
            grid-template-columns: auto auto 1fr auto auto auto;
            gap: 25px;
            padding: 20px;
            border-bottom: 1px solid rgba(90, 62, 43, 0.1);
            align-items: center;
            background: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            border-radius: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .cart-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .cart-item:hover::before {
            left: 100%;
        }

        .cart-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(90, 62, 43, 0.1);
            background: rgba(255, 255, 255, 0.9);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item input[type="checkbox"] {
            justify-self: start;
            cursor: pointer;
            transform: scale(1.2);
            accent-color: #8b6f47;
        }

        .cart-item-image-container {
            width: 90px;
            height: 90px;
            border: 1px solid rgba(90, 62, 43, 0.1);
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .cart-item-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .cart-item:hover .cart-item-image {
            transform: scale(1.05);
        }

        .cart-item-details {
            justify-self: start;
            padding-right: 15px;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 0;
            color: #5a3e2b;
            font-size: 1.1em;
            font-family: 'Playfair Display', serif;
        }

        .cart-item-category {
            color: #8b6f47;
            font-size: 0.9em;
            margin-top: 0;
            font-weight: 500;
        }

        .cart-item-price {
            justify-self: end;
            font-weight: bold;
            color: #8b6f47;
            font-size: 1.2em;
            text-align: right;
            white-space: nowrap;
            background: linear-gradient(45deg, #8b6f47, #5a3e2b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cart-quantity-controls {
            display: flex;
            align-items: center;
            justify-self: end;
            background: rgba(139, 111, 71, 0.05);
            padding: 8px 15px;
            border-radius: 25px;
            border: 1px solid rgba(90, 62, 43, 0.1);
        }

        .quantity-button {
            padding: 8px 12px;
            border: 2px solid rgba(90, 62, 43, 0.2);
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: #5a3e2b;
            transition: all 0.3s ease;
            line-height: 1;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .quantity-button:hover {
            background: linear-gradient(135deg, #8b6f47, #5a3e2b);
            color: white;
            border-color: #5a3e2b;
            transform: scale(1.1);
        }

        .item-quantity {
            margin: 0 15px;
            font-size: 18px;
            font-weight: bold;
            color: #5a3e2b;
            min-width: 30px;
            text-align: center;
        }

        .remove-item-button {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1.3em;
            justify-self: end;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-item-button:hover {
            color: #c82333;
            background: rgba(220, 53, 69, 0.1);
            transform: scale(1.1);
        }

        /* Cart Summary - Enhanced Responsive */
        .cart-summary {
            padding: 30px;
            background: rgba(139, 111, 71, 0.05);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(90, 62, 43, 0.1);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .cart-summary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .cart-summary:hover::before {
            left: 100%;
        }

        .cart-summary h3 {
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            color: #5a3e2b;
            font-family: 'Playfair Display', serif;
            font-size: 1.8em;
            font-weight: 600;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #555;
            font-size: 1em;
            font-weight: 500;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 1.3em;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid rgba(90, 62, 43, 0.2);
            color: #5a3e2b;
        }

        /* Buttons */
        .process-checkout-button {
            display: block;
            width: 100%;
            padding: 15px 20px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            margin-top: 25px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
        }

        .process-checkout-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .process-checkout-button:hover::before {
            left: 100%;
        }

        .process-checkout-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(76, 175, 80, 0.4);
        }

        .process-checkout-button:disabled {
            background: linear-gradient(135deg, #ccc, #999);
            cursor: not-allowed;
            opacity: 0.7;
            box-shadow: none;
            transform: none;
        }

        .back-to-menu-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            color: #5a3e2b;
            text-decoration: none;
            margin-top: 30px;
            font-size: 1.1em;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 12px 20px;
            border-radius: 25px;
            background: rgba(139, 111, 71, 0.05);
            border: 1px solid rgba(90, 62, 43, 0.1);
        }

        .back-to-menu-button:hover {
            color: #8b6f47;
            background: rgba(139, 111, 71, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(90, 62, 43, 0.1);
        }

        .back-to-menu-button i {
            margin-right: 10px;
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .back-to-menu-button:hover i {
            transform: translateX(-3px);
        }

        /* Empty Cart Message */
        #empty-cart-message-cart-page {
            text-align: center;
            color: #8b6f47;
            font-style: italic;
            padding: 60px 0;
            font-size: 1.2em;
            background: rgba(139, 111, 71, 0.05);
            border-radius: 15px;
            border: 2px dashed rgba(90, 62, 43, 0.2);
        }

        /* Enhanced Responsive adjustments */
        @media (max-width: 1024px) {
            .cart-container {
                padding: 30px;
                gap: 30px;
            }

            .cart-items-section {
                padding-right: 30px;
            }

            .cart-summary-section {
                padding-left: 30px;
            }

            .cart-summary {
                position: static;
                top: auto;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .cart-container {
                grid-template-columns: 1fr;
                padding: 25px;
                gap: 30px;
            }

            .cart-items-section {
                border-right: none;
                border-bottom: 2px solid rgba(90, 62, 43, 0.1);
                padding-right: 0;
                padding-bottom: 30px;
                margin-bottom: 30px;
            }

            .cart-summary-section {
                padding-left: 0;
            }

            /* Enhanced cart summary for mobile */
            .cart-summary {
                position: static;
                top: auto;
                padding: 25px 20px;
                margin-top: 20px;
            }

            .cart-summary h3 {
                font-size: 1.6em;
                margin-bottom: 20px;
            }

            .summary-item {
                font-size: 0.95em;
                margin-bottom: 12px;
            }

            .summary-total {
                font-size: 1.2em;
                margin-top: 20px;
                padding-top: 15px;
            }

            .process-checkout-button {
                font-size: 16px;
                padding: 14px 18px;
                margin-top: 20px;
            }

            .cart-item {
                grid-template-columns: auto auto 1fr auto;
                gap: 15px;
                align-items: flex-start;
                padding: 18px 15px;
            }

            .cart-item-details {
                 grid-column: 3;
                 padding-right: 0;
            }

            .cart-item-price {
                grid-column: 3;
                justify-self: start;
                margin-top: 10px;
                font-size: 1.1em;
                 text-align: left;
                 white-space: normal;
            }

            .cart-quantity-controls {
                grid-column: 3;
                justify-self: start;
                margin-top: 10px;
                padding: 6px 12px;
            }

            .quantity-button {
                padding: 6px 10px;
                font-size: 14px;
                width: 30px;
                height: 30px;
            }

            .item-quantity {
                font-size: 16px;
                margin: 0 10px;
            }

            .remove-item-button {
                 grid-column: 4;
                 justify-self: end;
                 align-self: center;
                 font-size: 1.2em;
                 width: 36px;
                 height: 36px;
            }

            .cart-title {
                font-size: 1.8em;
            }

            .cart-items-count {
                font-size: 1em;
                padding: 6px 12px;
            }

            .back-to-menu-button {
                 font-size: 1em;
                 padding: 10px 16px;
             }

             .back-to-menu-button i {
                 font-size: 18px;
             }
        }

        @media (max-width: 600px) {
            .cart-container {
                padding: 20px 15px;
                border-radius: 20px;
            }

            .cart-summary {
                padding: 20px 15px;
                border-radius: 15px;
            }

            .cart-summary h3 {
                font-size: 1.5em;
                margin-bottom: 18px;
            }

            .summary-item {
                font-size: 0.9em;
                margin-bottom: 10px;
            }

            .summary-total {
                font-size: 1.1em;
                margin-top: 18px;
                padding-top: 12px;
            }

            .process-checkout-button {
                font-size: 15px;
                padding: 12px 16px;
                border-radius: 20px;
            }
        }

        @media (max-width: 480px) {
             .cart-item-image-container {
                 width: 70px;
                 height: 70px;
                 border-radius: 12px;
             }

             .cart-item-name {
                 font-size: 1em;
                 margin-bottom: 6px;
             }

             .cart-item-category {
                 font-size: 0.85em;
             }

             .select-all {
                 font-size: 1em;
                 padding: 12px 15px;
                 border-radius: 12px;
             }

             .cart-header {
                 flex-direction: column;
                 align-items: flex-start;
                 gap: 8px;
                 margin-bottom: 20px;
                 padding-bottom: 15px;
             }

             h2 {
                 font-size: 2em;
                 margin-bottom: 25px;
             }

             .cart-item {
                 padding: 15px 12px;
                 border-radius: 12px;
                 margin-bottom: 12px;
             }

             .cart-summary {
                 padding: 18px 12px;
                 border-radius: 12px;
             }

             .cart-summary h3 {
                 font-size: 1.4em;
                 margin-bottom: 15px;
             }

             .summary-item {
                 font-size: 0.85em;
                 margin-bottom: 8px;
             }

             .summary-total {
                 font-size: 1em;
                 margin-top: 15px;
                 padding-top: 10px;
             }

             .process-checkout-button {
                 font-size: 14px;
                 padding: 11px 14px;
                 border-radius: 18px;
                 margin-top: 15px;
             }

             .back-to-menu-button {
                 font-size: 0.95em;
                 padding: 9px 14px;
                 border-radius: 20px;
                 margin-top: 25px;
             }

             .back-to-menu-button i {
                 font-size: 16px;
                 margin-right: 8px;
             }

             #empty-cart-message-cart-page {
                 padding: 40px 20px;
                 font-size: 1.1em;
                 border-radius: 12px;
             }
        }

        /* Ultra small screens */
        @media (max-width: 360px) {
            body {
                padding: 10px;
            }

            .cart-container {
                padding: 15px 10px;
                border-radius: 15px;
            }

            .cart-summary {
                padding: 15px 10px;
                border-radius: 10px;
            }

            .cart-summary h3 {
                font-size: 1.3em;
                margin-bottom: 12px;
            }

            .summary-item {
                font-size: 0.8em;
                margin-bottom: 6px;
            }

            .summary-total {
                font-size: 0.95em;
                margin-top: 12px;
                padding-top: 8px;
            }

            .process-checkout-button {
                font-size: 13px;
                padding: 10px 12px;
                border-radius: 15px;
                margin-top: 12px;
            }

            .cart-item {
                padding: 12px 8px;
                border-radius: 10px;
                margin-bottom: 10px;
            }

            .cart-item-image-container {
                width: 60px;
                height: 60px;
                border-radius: 10px;
            }

            .select-all {
                font-size: 0.9em;
                padding: 10px 12px;
                border-radius: 10px;
            }

            .back-to-menu-button {
                font-size: 0.9em;
                padding: 8px 12px;
                border-radius: 18px;
                margin-top: 20px;
            }

            .back-to-menu-button i {
                font-size: 14px;
                margin-right: 6px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="cart-container">
        <section class="cart-items-section">
            <div class="cart-header">
                <h2 class="cart-title">Keranjang</h2>
                <!-- This count shows TOTAL items in cart -->
                <span class="cart-items-count"> <span id="cart-total-item-count-header">0</span> Total Item</span>
            </div>
            <div class="select-all">
                <input type="checkbox" id="select-all-checkbox">
                <label for="select-all-checkbox">Pilih Semua</label>
            </div>

            <div id="cart-item-list-container">
                <p id="empty-cart-message-cart-page" style="display:none;">Keranjang Anda kosong.</p>
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
                <h3>Ringkasan</h3>
                <div class="summary-item">
                    <span class="summary-items-label">Item Terpilih</span>
                    <span id="summary-selected-items-count">0</span>
                </div>
                <div class="summary-total">
                    <span>Total Harga</span>
                    <span id="summary-selected-total-price">Rp. 0</span>
                </div>
                <!-- Updated link to use route() helper if blade -->
                <a href="{{ route('checkout.index') }}" class="process-checkout-button" id="process-checkout-button" role="button" disabled>Proses Checkout</a>
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
                    if (confirm('Atur jumlah menjadi 0? Ini akan menghapus item dari keranjang Anda.')) {
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
                    const imageUrl = (item.pict && item.pict !== '') ? item.pict : 'https://placehold.co/80x80?text=Tidak Ada Gambar';

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
