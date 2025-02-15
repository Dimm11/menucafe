<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Selamat Datang di Cafe Kami</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'figtree', sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-color: #f3f4f6; /* Warna latar belakang abu-abu muda */
            }

            .container {
                text-align: center;
                padding: 2rem;
                background-color: #ffffff; /* Warna latar belakang putih untuk container */
                border-radius: 0.5rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Efek bayangan tipis */
            }

            h1 {
                font-size: 2.5rem;
                margin-bottom: 1.5rem;
                color: #374151; /* Warna teks judul */
            }

            .button-container {
                display: flex;
                flex-direction: column;
                gap: 1rem; /* Jarak antar tombol */
                margin-top: 2rem;
            }

            .button, .dropdown-container {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                font-weight: 600;
                text-align: center;
                text-decoration: none;
                border-radius: 0.375rem;
                background-color: #4f46e5; /* Warna latar belakang tombol biru */
                color: #ffffff; /* Warna teks tombol putih */
                transition: background-color 0.2s ease-in-out; /* Efek transisi hover */
                cursor: pointer; /* Menambahkan cursor pointer untuk dropdown */
            }

            .button:hover, .dropdown-container:hover {
                background-color: #3730a3; /* Warna latar belakang tombol biru lebih gelap saat hover */
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
                border-radius: 0.375rem;
                margin-top: 0.25rem; /* Sedikit jarak dari tombol dropdown */
            }

            .dropdown-content a {
                color: black;
                padding: 0.75rem 1rem;
                text-decoration: none;
                display: block;
                text-align: left;
                border-bottom: 1px solid #e5e7eb; /* Garis pemisah antar item dropdown */
            }

            .dropdown-content a:last-child {
                border-bottom: none; /* Hilangkan garis bawah pada item terakhir */
                border-bottom-left-radius: 0.375rem; /* Rounded bottom left corner */
                border-bottom-right-radius: 0.375rem; /* Rounded bottom right corner */
            }

            .dropdown-content a:hover {background-color: #ddd;}

            .dropdown-container:hover .dropdown-content {
                display: block;
            }

        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <h1>Selamat Datang di [Nama Cafe Anda]</h1>
            <p>Nikmati suasana hangat dan kopi terbaik di kota!</p>

            <div class="button-container">
                <a href="#" class="button">Profil Cafe</a>
                <div class="dropdown-container">
                    Menu Cafe
                    <div class="dropdown-content">
                    <a href="{{ route('products.index', ['table' => $tableId]) }}">Makanan</a>
                    <a href="{{ route('products.index', ['table' => $tableId]) }}">Minuman</a>
                    </div>
                </div>
                <a href="#" class="button">Alamat Cafe</a>
            </div>
        </div>
    </body>
</html>