<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KING GITAR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        :root {
            --bg-cream: #FFFBF5;
            --text-dark: #1A1A1A;
            --text-gray: #666666;
            --accent-green: #D4EED9;
            --icon-green: #2ECC71;
            --price-color: #333333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: white;
            color: var(--text-dark);
        }

        /* Utility */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background-color: var(--bg-cream);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: all 0.3s ease;
        }

        header.header-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .logo-text {
            font-size: 2.5rem;
            font-weight: 400;
            /* Serif-like elegance */
            font-family: 'Times New Roman', serif;
            /* Or similar serif font */
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .guitar-icon-small {
            height: 40px;
            transform: rotate(-15deg);
        }

        .guitar-icon-small.right {
            transform: rotate(15deg) scaleX(-1);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .location {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .location i {
            color: #E74C3C;
            font-size: 1.2rem;
        }

        .icon-btn {
            font-size: 1.5rem;
            color: #ccc;
            cursor: pointer;
        }

        .icon-btn.menu {
            color: #999;
        }

        .user-icon {
            color: #ccc;
            font-size: 1.8rem;
        }

        /* Search Section */
        .search-section {
            background-color: var(--bg-cream);
            padding-bottom: 40px;
            display: flex;
            justify-content: center;
        }

        .search-bar {
            background: white;
            border-radius: 50px;
            padding: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 700px;
            border: 1px solid #eee;
        }

        .search-option {
            flex: 1;
            padding: 10px 20px;
            border-right: 1px solid #eee;
        }

        .search-option:last-of-type {
            border-right: none;
        }

        .search-title {
            font-weight: 700;
            font-size: 1rem;
            display: block;
            color: #000;
        }

        .search-subtitle {
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        .search-btn {
            background-color: #E2EFE1;
            /* Light green bg */
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-right: 5px;
        }

        .search-btn i {
            color: #2ECC71;
            /* Green icon */
            font-size: 1.2rem;
        }

        /* Hero Section */
        .hero {
            background-color: var(--bg-cream);
            padding-bottom: 0;
            overflow: hidden;
        }

        .hero-image-container {
            width: 100%;
            height: 300px;
            /* Adjust height based on image aspect ratio */
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }

        .hero-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        /* Products Grid */
        .products {
            padding: 60px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .product-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 15px;
            position: relative;
            text-align: center;
            transition: transform 0.2s;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .wishlist-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #666;
            cursor: pointer;
        }

        .wishlist-btn:hover {
            color: #E74C3C;
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .product-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 5px;
            color: #000;
            text-align: left;
        }

        .product-price {
            font-size: 0.9rem;
            color: var(--text-gray);
            text-align: left;
        }

        /* Footer */
        footer {
            background-color: var(--bg-cream);
            padding: 60px 0;
            margin-top: 40px;
        }

        .footer-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 40px;
            color: #333;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .footer-col h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #000;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            text-decoration: none;
            color: #444;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 992px) {

            .products-grid,
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {

            .products-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .header-content {
                flex-direction: column;
                gap: 20px;
            }

            .logo-text {
                font-size: 2rem;
            }

            .search-bar {
                flex-direction: column;
                border-radius: 20px;
            }

            .search-option {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #eee;
            }

            .search-btn {
                width: 100%;
                border-radius: 0 0 20px 20px;
                height: 50px;
            }
        }

        /* Mobile Menu Styles */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu-drawer {
            position: fixed;
            top: 0;
            right: -300px;
            /* Hide off-canvas */
            width: 280px;
            height: 100%;
            background-color: white;
            z-index: 1001;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .mobile-menu-drawer.active {
            right: 0;
        }

        .mobile-menu-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .mobile-menu-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .mobile-menu-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-gray);
            cursor: pointer;
        }

        .mobile-menu-close:hover {
            color: #E74C3C;
        }

        .mobile-menu-links {
            list-style: none;
            padding: 20px;
            flex-grow: 1;
        }

        .mobile-menu-links li {
            margin-bottom: 15px;
        }

        .mobile-menu-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-size: 1.1rem;
            font-weight: 500;
            display: block;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.2s, color 0.2s;
        }

        .mobile-menu-links a:hover {
            background-color: var(--bg-cream);
            color: #C5A028;
            /* Gold-ish color */
        }

        .mobile-menu-links a.active {
            background-color: var(--bg-cream);
            color: #C5A028;
            font-weight: 700;
            border-left: 4px solid #C5A028;
        }
    </style>
</head>

<body>

    <header>
        <div class="container header-content">
            <!-- Left Header: Empty or Logo fallback -->
            <div style="width: 100px;">
                <img src="{{ asset('Foto/Logo.png') }}" alt="Company Logo" style="height: 50px; display: none;">
                <!-- Hidden as per design requesting centered text -->
            </div>

            <!-- Center Logo -->
            <a href="{{ url('/') }}" class="logo-container" style="text-decoration: none; color: inherit;">
                <!-- Using font awesome guitar as placeholder for small guitar image -->
                <!-- Ideally use actual image, referencing placeholder for now -->
                <img src="{{ asset('Foto/Logo.png') }}" class="guitar-icon-small" alt="Guitar Icon"
                    style="object-fit: contain;">
                <h1 class="logo-text">KING GITAR</h1>
                <img src="{{ asset('Foto/Logo.png') }}" class="guitar-icon-small right" alt="Guitar Icon"
                    style="object-fit: contain;">
            </a>

            <!-- Right Icons -->
            <div class="header-right">
                <div class="location">
                    Lokasi <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="icon-btn menu" id="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="user-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="search-section">
        <div class="container" style="display: flex; justify-content: center;">
            <div class="search-bar">
                <a href="{{ url('/detail-katalog?jenis=classic') }}" class="search-option"
                    style="text-decoration: none; color: inherit;">
                    <span class="search-title">Classic</span>
                    <span class="search-subtitle">Lembut</span>
                </a>
                <a href="{{ url('/detail-katalog?jenis=akustik') }}" class="search-option"
                    style="text-decoration: none; color: inherit;">
                    <span class="search-title">Akustik</span>
                    <span class="search-subtitle">Nyaring</span>
                </a>
                <a href="{{ url('/detail-katalog?jenis=elektrik') }}" class="search-option"
                    style="text-decoration: none; color: inherit;">
                    <span class="search-title">Elektrik</span>
                    <span class="search-subtitle">Bertenaga</span>
                </a>
                <button class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="hero-image-container">
                <!-- Using a visually similar placeholder or one of the files if suitable. -->
                <!-- Assuming 8.png is large based on file size earlier -->
                <img src="{{ asset('Foto/8.png') }}" alt="Hero Image - Man playing guitar">
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <section class="products">
        <div class="container">
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card reveal">
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                        <a href="{{ route('produk.detail', ['id' => $product['id']]) }}"
                            style="text-decoration: none; color: inherit;">
                            <img src="{{ asset($product['gambar']) }}" alt="{{ $product['nama'] }}" class="product-image"
                                loading="lazy">
                            <h3 class="product-name">{{ $product['nama'] }}</h3>
                            <p class="product-price">{{ $product['harga'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <h2 class="footer-title">Inspiration for the future</h2>
            <div class="footer-grid">
                <!-- Column 1 -->
                <div class="footer-col">
                    <h4>Jelajahi Gitar</h4>
                    <ul class="footer-links">
                        <li><a href="#">Gitar Akustik</a></li>
                        <li><a href="#">Gitar Elektrik</a></li>
                        <li><a href="#">Gitar Klasik</a></li>
                        <li><a href="#">Gitar Custom</a></li>
                    </ul>

                    <h4 style="margin-top: 30px;">Panduan Pembeli</h4>
                    <ul class="footer-links">
                        <li><a href="#">Cara Memilih Gitar</a></li>
                        <li><a href="#">Perbedaan Jenis Gitar</a></li>
                        <li><a href="#">Ukuran & Skala Gitar</a></li>
                        <li><a href="#">Tips Beli Gitar Online</a></li>
                        <li><a href="#">Panduan Budget</a></li>
                        <li><a href="#">Rekomendasi Level Pemula-Pro</a></li>
                    </ul>
                </div>

                <!-- Column 2 -->
                <div class="footer-col">
                    <h4>Layanan Pelanggan</h4>
                    <ul class="footer-links">
                        <li><a href="#">Cara Pemesanan</a></li>
                        <li><a href="#">Metode Pembayaran</a></li>
                        <li><a href="#">Pengiriman & Ongkir</a></li>
                        <li><a href="#">Garansi Produk</a></li>
                    </ul>

                    <h4 style="margin-top: 30px;">Hosting</h4>
                    <ul class="footer-links">
                        <li><a href="#">Hostinger</a></li>
                        <li><a href="#">Arenthousie</a></li>
                        <li><a href="#">Rumah Web</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div class="footer-col">
                    <h4>Tips & Edukasi</h4>
                    <ul class="footer-links">
                        <li><a href="#">Belajar Gitar Pemula</a></li>
                        <li><a href="#">Tips Perawatan Gitar</a></li>
                        <li><a href="#">Review Produk</a></li>
                        <li><a href="#">Tutorial Chord</a></li>
                    </ul>

                    <h4 style="margin-top: 30px;">Servis & Custom Gitar</h4>
                    <ul class="footer-links">
                        <li><a href="#">Setup & Tune Up</a></li>
                        <li><a href="#">Perbaikan Gitar</a></li>
                        <li><a href="#">Custom Body & Neck</a></li>
                        <li><a href="#">Upgrade Pickup</a></li>
                        <li><a href="#">Ganti Senar</a></li>
                        <li><a href="#">Restorasi Gitar Lama</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div class="footer-col">
                    <h4>Tentang King Gitar</h4>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Visi & Misi</a></li>
                        <li><a href="#">Testimoni Pelanggan</a></li>
                        <li><a href="#">Kontak Kami</a></li>
                    </ul>

                    <h4 style="margin-top: 30px;">Support & Bantuan</h4>
                    <ul class="footer-links">
                        <li><a href="#">FAQ (Pertanyaan Umum)</a></li>
                        <li><a href="#">Bantuan Teknis</a></li>
                        <li><a href="#">Panduan Website</a></li>
                        <li><a href="#">Live Chat Support</a></li>
                        <li><a href="#">Laporkan Masalah</a></li>
                        <li><a href="#">Hubungi Admin</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Container -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
    <div class="mobile-menu-drawer" id="mobile-menu-drawer">
        <div class="mobile-menu-header">
            <span class="mobile-menu-title">Menu</span>
            <button class="mobile-menu-close" id="mobile-menu-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-menu-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/') }}#about">About Us</a></li>
            <li><a href="{{ url('/katalog') }}" class="active">Katalog</a></li>
            <li><a href="{{ url('/') }}#contact">Contact</a></li>
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menu Toggle Login
            const menuBtn = document.getElementById('mobile-menu-btn'); // Changed from 'menu-btn' to 'mobile-menu-btn'
            const menuCloseBtn = document.getElementById('mobile-menu-close'); // Changed from 'menu-close' to 'mobile-menu-close'
            const menuOverlay = document.getElementById('mobile-menu-overlay'); // Changed from 'menu-overlay' to 'mobile-menu-overlay'
            const sideMenu = document.getElementById('mobile-menu-drawer'); // Changed from 'side-menu' to 'mobile-menu-drawer'

            function openMenu() {
                sideMenu.classList.add('active');
                menuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                sideMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (menuBtn) menuBtn.addEventListener('click', openMenu);
            if (menuCloseBtn) menuCloseBtn.addEventListener('click', closeMenu);
            if (menuOverlay) menuOverlay.addEventListener('click', closeMenu);

            // Scroll Reveal Animation with Intersection Observer
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('active');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const revealElements = document.querySelectorAll('.reveal');
            revealElements.forEach(el => revealObserver.observe(el));

            // Sticky Header Logic
            const header = document.querySelector('header');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 10) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
            });
        });
    </script>
</body>

</html>