<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About Lampaoe Coffee and Culture</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=playfair-display:400,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=crimson-text:400,600&display=swap" rel="stylesheet" />
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
                background: linear-gradient(135deg, #f8f4e3 0%, #f0e6d2 100%);
                color: #333;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                position: relative;
                overflow-x: hidden;
            }

            /* Background decoration */
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: 
                    radial-gradient(circle at 25% 25%, rgba(90, 62, 43, 0.02) 0%, transparent 50%),
                    radial-gradient(circle at 75% 75%, rgba(139, 111, 71, 0.03) 0%, transparent 50%);
                animation: float 25s ease-in-out infinite;
                z-index: -1;
            }

            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(0.5deg); }
            }

            .container {
                text-align: left;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(15px);
                padding: 50px;
                border-radius: 20px;
                box-shadow: 
                    0 25px 50px rgba(0, 0, 0, 0.12),
                    0 0 0 1px rgba(255, 255, 255, 0.3);
                display: flex;
                flex-direction: column;
                gap: 30px;
                max-width: 800px;
                width: 90%;
                position: relative;
                transition: transform 0.3s ease;
                opacity: 0;
                animation: fadeInUp 1s ease 0.3s forwards;
            }

            .container:hover {
                transform: translateY(-3px);
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

            /* Decorative elements */
            .container::before {
                content: '';
                position: absolute;
                top: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 4px;
                background: linear-gradient(90deg, #5a3e2b, #8b6f47);
                border-radius: 2px;
            }

            .header-section {
                text-align: center;
                margin-bottom: 20px;
                position: relative;
            }

            .cafe-name {
                font-family: 'Playfair Display', 'Georgia', serif;
                color: #5a3e2b;
                font-size: 2.8em;
                margin-bottom: 10px;
                font-weight: 700;
                background: linear-gradient(45deg, #5a3e2b, #8b6f47);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.05);
                opacity: 0;
                animation: fadeInUp 1s ease 0.6s forwards;
            }

            .tagline {
                font-family: 'Crimson Text', serif;
                font-style: italic;
                color: #8b6f47;
                font-size: 1.3em;
                margin-bottom: 30px;
                opacity: 0;
                animation: fadeInUp 1s ease 0.9s forwards;
            }

            .story-content {
                position: relative;
                padding: 30px;
                background: linear-gradient(135deg, rgba(248, 244, 227, 0.3), rgba(240, 230, 210, 0.2));
                border-radius: 15px;
                border: 1px solid rgba(90, 62, 43, 0.1);
                margin-bottom: 20px;
                opacity: 0;
                animation: fadeInUp 1s ease 1.2s forwards;
            }

            .story-content::before {
                content: '"';
                position: absolute;
                top: -10px;
                left: 20px;
                font-size: 4em;
                color: rgba(90, 62, 43, 0.2);
                font-family: 'Playfair Display', serif;
                font-weight: bold;
                line-height: 1;
            }

            .story-text {
                font-family: 'Crimson Text', serif;
                font-size: 1.25em;
                line-height: 1.8;
                color: #4a4a4a;
                text-align: justify;
                position: relative;
                z-index: 1;
            }

            .highlight {
                color: #5a3e2b;
                font-weight: 600;
                position: relative;
            }

            .highlight::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                right: 0;
                height: 2px;
                background: linear-gradient(90deg, transparent, #8b6f47, transparent);
                opacity: 0.3;
            }

            .features-section {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                margin: 30px 0;
                opacity: 0;
                animation: fadeInUp 1s ease 1.5s forwards;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.7);
                padding: 25px;
                border-radius: 15px;
                text-align: center;
                border: 1px solid rgba(90, 62, 43, 0.1);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
                transition: left 0.5s;
            }

            .feature-card:hover::before {
                left: 100%;
            }

            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(90, 62, 43, 0.15);
                border-color: rgba(90, 62, 43, 0.2);
            }

            .feature-icon {
                font-size: 2.5em;
                color: #8b6f47;
                margin-bottom: 15px;
                display: block;
            }

            .feature-title {
                font-family: 'Playfair Display', serif;
                color: #5a3e2b;
                font-size: 1.3em;
                font-weight: 600;
                margin-bottom: 10px;
            }

            .feature-desc {
                color: #666;
                font-size: 1em;
                line-height: 1.6;
            }

            .location-info {
                background: linear-gradient(135deg, rgba(90, 62, 43, 0.05), rgba(139, 111, 71, 0.03));
                padding: 25px;
                border-radius: 15px;
                border: 1px solid rgba(90, 62, 43, 0.1);
                margin: 20px 0;
                text-align: center;
                opacity: 0;
                animation: fadeInUp 1s ease 1.8s forwards;
            }

            .location-title {
                font-family: 'Playfair Display', serif;
                color: #5a3e2b;
                font-size: 1.4em;
                font-weight: 600;
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .location-text {
                color: #666;
                font-size: 1.1em;
                line-height: 1.6;
            }

            .back-link {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                margin-top: 20px;
                text-decoration: none;
                color: #5a3e2b;
                font-weight: 600;
                font-size: 1.1em;
                padding: 15px 25px;
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(248, 244, 227, 0.8));
                border: 2px solid rgba(90, 62, 43, 0.2);
                border-radius: 50px;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                backdrop-filter: blur(5px);
                align-self: flex-start;
                opacity: 0;
                animation: fadeInUp 1s ease 2.1s forwards;
            }

            .back-link:hover {
                background: linear-gradient(135deg, #5a3e2b, #8b6f47);
                color: #fff;
                border-color: #5a3e2b;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(90, 62, 43, 0.3);
                text-decoration: none;
            }

            .back-link i {
                transition: transform 0.3s ease;
            }

            .back-link:hover i {
                transform: translateX(-3px);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .container {
                    padding: 30px 25px;
                    gap: 25px;
                }

                .cafe-name {
                    font-size: 2.2em;
                }

                .tagline {
                    font-size: 1.1em;
                }

                .story-text {
                    font-size: 1.1em;
                    text-align: left;
                }

                .features-section {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .feature-card {
                    padding: 20px;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding: 10px;
                }

                .container {
                    padding: 25px 20px;
                }

                .cafe-name {
                    font-size: 1.8em;
                }

                .story-content {
                    padding: 20px;
                }

                .story-content::before {
                    font-size: 3em;
                    top: -5px;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header-section">
                <h1 class="cafe-name">Lampaoe Coffee and Culture</h1>
                <p class="tagline">Mengenang Kenangan dalam Secangkir Kopi</p>
            </div>

            <div class="story-content">
                <p class="story-text">
                    <span class="highlight">Lampaoe Coffee and Culture</span> adalah kedai kopi di Bojongsari, Depok, Jawa Barat, 
                    dengan konsep unik yang mengajak pengunjung bernostalgia ke masa lampau. Nama <span class="highlight">"Lampaoe"</span> 
                    sendiri berarti masa lalu. Mengusung nuansa Jawa yang kental, interior kedai ini didominasi ornamen kayu dan rumah joglo, 
                    menciptakan suasana hangat dan tradisional. Di sini, kalian bisa menikmati secangkir kopi sambil bersantai dan 
                    mengenang kenangan masa lalu.
                </p>
            </div>

            <div class="features-section">
                <div class="feature-card">
                    <i class="fas fa-home feature-icon"></i>
                    <h3 class="feature-title">Arsitektur Joglo</h3>
                    <p class="feature-desc">Suasana tradisional dengan ornamen kayu dan rumah joglo yang autentik</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-coffee feature-icon"></i>
                    <h3 class="feature-title">Kopi Berkualitas</h3>
                    <p class="feature-desc">Berbagai pilihan kopi premium dengan cita rasa yang mengingatkan masa lalu</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-heart feature-icon"></i>
                    <h3 class="feature-title">Nostalgia</h3>
                    <p class="feature-desc">Tempat yang sempurna untuk bernostalgia dan mengenang kenangan indah</p>
                </div>
            </div>

            <div class="location-info">
                <h3 class="location-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Lokasi Kami
                </h3>
                <p class="location-text">Jl. H. Sarmat No.97, RT.04/RW.03, Pd. Petir, Kec. Bojongsari, Kota Depok, Jawa Barat 16517</p>
            </div>

            <a href="{{ url('/') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>
    </body>
</html>