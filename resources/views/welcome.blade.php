<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Menu Cafe</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
            integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Styles -->
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
                background-image: url('/assets/background2.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            .background-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(90, 62, 43, 0.7);
                z-index: -1;
            }

            .container {
                text-align: center;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                padding: 60px 50px;
                border-radius: 20px;
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.1),
                    0 0 0 1px rgba(255, 255, 255, 0.2);
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 40px;
                max-width: 500px;
                width: 90%;
                position: relative;
                transition: transform 0.3s ease;
                z-index: 1;
            }

            .container:hover {
                transform: translateY(-5px);
            }

            /* Decorative coffee beans */
            .container::before,
            .container::after {
                content: '☕';
                position: absolute;
                font-size: 2em;
                color: rgba(90, 62, 43, 0.1);
                animation: pulse 3s ease-in-out infinite;
            }

            .container::before {
                top: 20px;
                left: 30px;
                animation-delay: 0s;
            }

            .container::after {
                bottom: 20px;
                right: 30px;
                animation-delay: 1.5s;
            }

            @keyframes pulse {
                0%, 100% { opacity: 0.1; transform: scale(1); }
                50% { opacity: 0.3; transform: scale(1.1); }
            }

            .cafe-info {
                position: relative;
            }

            .welcome-text {
                font-size: 1.4em;
                color: #8b6f47;
                margin-bottom: 15px;
                font-weight: 400;
                letter-spacing: 1px;
                opacity: 0;
                animation: fadeInUp 1s ease 0.3s forwards;
            }

            h1 {
                font-family: 'Playfair Display', 'Georgia', serif;
                color: #5a3e2b;
                font-size: 3.2em;
                margin-bottom: 15px;
                font-weight: 700;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
                background: linear-gradient(45deg, #5a3e2b, #8b6f47);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                opacity: 0;
                animation: fadeInUp 1s ease 0.6s forwards;
            }

            .subtitle {
                font-size: 1.1em;
                color: #8b6f47;
                margin-bottom: 10px;
                font-style: italic;
                opacity: 0;
                animation: fadeInUp 1s ease 0.9s forwards;
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

            .links {
                display: flex;
                flex-direction: column;
                gap: 15px;
                width: 100%;
                max-width: 300px;
            }

            .links a {
                position: relative;
                text-decoration: none;
                color: #5a3e2b;
                font-weight: 600;
                font-size: 1.2em;
                padding: 18px 30px;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(248, 244, 227, 0.8));
                border: 2px solid rgba(90, 62, 43, 0.2);
                border-radius: 50px;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                overflow: hidden;
                backdrop-filter: blur(5px);
                opacity: 0;
                animation: fadeInUp 1s ease forwards;
            }

            .links a:nth-child(1) {
                animation-delay: 1.2s;
            }

            .links a:nth-child(2) {
                animation-delay: 1.4s;
            }

            .links a::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background-color: rgba(90, 62, 43, 0.7);
                z-index: -1;
            }

            .links a:hover::before {
                left: 100%;
            }

            .links a:hover {
                background: linear-gradient(135deg, #5a3e2b, #8b6f47);
                color: #fff;
                border-color: #5a3e2b;
                transform: translateY(-3px);
                box-shadow: 0 15px 30px rgba(90, 62, 43, 0.3);
            }

            .links a i {
                margin-right: 10px;
                transition: transform 0.3s ease;
            }

            .links a:hover i {
                transform: scale(1.2);
            }

            .cafe-address {
                margin-top: 20px;
                padding: 20px;
                background: rgba(90, 62, 43, 0.05);
                border-radius: 15px;
                border: 1px solid rgba(90, 62, 43, 0.1);
                opacity: 0;
                animation: fadeInUp 1s ease 1.6s forwards;
            }

            .cafe-address p {
                color: #5a3e2b;
                font-size: 1em;
                font-weight: 500;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .cafe-address i {
                color: #8b6f47;
                font-size: 1.2em;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .container {
                    padding: 40px 30px;
                    gap: 30px;
                }

                h1 {
                    font-size: 2.5em;
                }

                .welcome-text {
                    font-size: 1.2em;
                }

                .links a {
                    font-size: 1.1em;
                    padding: 15px 25px;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding: 10px;
                }

                .container {
                    padding: 30px 20px;
                }

                h1 {
                    font-size: 2em;
                }

                .container::before,
                .container::after {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="background-overlay"></div>
        <div class="container">
            <div class="cafe-info">
                <div class="welcome-text">Selamat Datang di</div>
                <h1>Lampaoe Coffe and Culture</h1>
                <p class="subtitle">Rumah Joglo yang Menjadi Ciri Khas Kami</p>
            </div>
            <div class="links">
                <a href="{{ url('/products') }}">
                    <i class="fas fa-utensils"></i>
                    Lihat Menu
                </a>
                <a href="{{ url('/about') }}">
                    <i class="fas fa-info-circle"></i>
                    Tentang Kami
                </a>
            </div>
            <div class="cafe-address">
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    Jl. H. Sarmat No.97, RT.04/RW.03, Pd. Petir, Kec. Bojongsari, Kota Depok, Jawa Barat 16517
                </p>
            </div>
        </div>
    </body>
</html>
