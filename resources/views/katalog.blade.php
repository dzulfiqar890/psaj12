<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KING GITAR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        /* ===== NAV ===== */
        header {
            background-color: white;
            border-bottom: 1px solid #f0ede8;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: box-shadow 0.3s ease;
        }

        header.header-scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .nav-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 14px 20px;
        }

        /* Logo */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #1a1a1a;
            flex-shrink: 0;
        }

        .nav-logo img {
            height: 38px;
            object-fit: contain;
        }

        .nav-logo-name {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            font-family: 'Playfair Display', serif;
            text-transform: uppercase;
        }

        /* Search */
        .nav-search {
            flex: 1;
            max-width: 560px;
            display: flex;
            align-items: center;
            background: #f5f3f0;
            border-radius: 50px;
            padding: 0 6px 0 20px;
            border: 1.5px solid transparent;
            transition: border-color 0.3s, background 0.3s;
        }

        .nav-search:focus-within {
            background: white;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
        }

        .nav-search input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.9rem;
            color: #1a1a1a;
            padding: 10px 0;
            font-family: 'Poppins', sans-serif;
        }

        .nav-search input::placeholder { color: #aaa; }

        .nav-search-btn {
            background: #D4AF37;
            border: none;
            border-radius: 50px;
            padding: 9px 18px;
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .nav-search-btn:hover { background: #c9a22e; }

        /* Right icons */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .nav-icon-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            outline: none;
            border: none;
            background: none;
            box-shadow: none;
            color: #444;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            transition: color 0.2s;
        }

        .nav-icon-btn i {
            font-size: 1.1rem;
        }

        .nav-icon-btn:hover { color: #D4AF37; }

        .nav-login-btn {
            background: #1a1a1a;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 22px;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .nav-login-btn:hover { background: #D4AF37; }

        /* Category Pills Bar */
        .nav-cats {
            background: white;
            border-top: 1px solid #f0ede8;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 4px;
            overflow-x: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
        }
        
        .nav-cats::after { content: ''; display: block; padding-right: 20px; } /* Add padding to end of scroll */

        .nav-cats::-webkit-scrollbar { display: none; }

        .nav-cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            white-space: nowrap;
            text-decoration: none;
            color: #666;
            font-size: 0.82rem;
            font-weight: 500;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            scroll-snap-align: start;
        }

        .nav-cat-pill:hover,
        .nav-cat-pill.active {
            color: #D4AF37;
            border-bottom-color: #D4AF37;
        }

        .nav-cat-pill i { font-size: 0.85rem; }

        /* Banner Spinner */
        .banner-loader-wrap {
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            width: 100%;
        }
        .banner-spinner {
            width: 45px;
            height: 45px;
            border: 4px solid rgba(212, 175, 55, 0.1);
            border-left-color: #D4AF37;
            border-radius: 50%;
            animation: banner-spin 1s linear infinite;
        }
        @keyframes banner-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }      /* Search Section no longer needed - merge into header */
        .search-section { display: none !important; }


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
            /* background-color: var(--bg-cream); */
            padding-bottom: 0;
            overflow: hidden;
        }

        .hero .container {
            padding-top: 20px;
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
            transition: all 0.3s ease;
            will-change: transform, opacity;
        }

        /* Scroll Reveal Base */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
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
            .products-grid { grid-template-columns: repeat(3, 1fr); }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .products-grid { grid-template-columns: repeat(2, 1fr); }
            .nav-top { flex-wrap: nowrap; gap: 10px; padding: 10px 0; }
            .nav-logo { display: none; }
            .nav-search { flex: 1; margin-top: 0; }
            .nav-actions { display: none; }
            .mobile-burger-btn { display: flex !important; margin-left: 0; }
        }

        @media (max-width: 576px) {
            .products-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .nav-search-btn span { display: none; }
        }

        /* Mobile Burger Button */
        .mobile-burger-btn {
            display: none;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #1a1a1a;
            cursor: pointer;
            padding: 5px;
        }

        /* Mobile Menu Drawer */
        .mobile-menu-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000;
        }
        .mobile-menu-overlay.active { display: block; }

        .mobile-menu-drawer {
            position: fixed; top: 0; right: -280px; width: 280px; height: 100vh;
            background: white; z-index: 2001; transition: right 0.3s ease;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1); display: flex; flex-direction: column;
        }
        .mobile-menu-drawer.active { right: 0; }

        .mobile-menu-header {
            padding: 20px; border-bottom: 1px solid #f0ede8;
            display: flex; justify-content: space-between; align-items: center;
        }
        .mobile-menu-title { font-weight: 700; font-size: 1.1rem; font-family: 'Times New Roman', serif; text-transform: uppercase; letter-spacing: 1px; }
        .mobile-menu-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #666; transition: color 0.2s; }
        .mobile-menu-close:hover { color: #e74c3c; }

        .mobile-menu-links { list-style: none; padding: 20px 0; overflow-y: auto; flex: 1; }
        .mobile-menu-links li { margin-bottom: 5px; }
        .mobile-menu-links a {
            display: flex; align-items: center; gap: 12px; padding: 12px 20px; text-decoration: none; color: #444;
            font-size: 0.95rem; font-weight: 500; transition: background 0.2s, color 0.2s;
        }
        .mobile-menu-links a i { font-size: 1.1rem; width: 24px; text-align: center; }
        .mobile-menu-links a:hover, .mobile-menu-links a.active { background: #fefcf9; color: #D4AF37; }
        
        .mobile-menu-footer { padding: 20px; border-top: 1px solid #f0ede8; }


        /* Map popup */
        .map-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 2000;
            align-items: center; justify-content: center;
        }
        .map-overlay.active { display: flex; }
        .map-modal {
            background: white; border-radius: 20px;
            overflow: hidden; width: 90%; max-width: 700px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
        }
        .map-modal-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 16px 20px; border-bottom: 1px solid #ebebeb;
        }
        .map-modal-header h3 { font-size: 1rem; font-weight: 600; }
        .map-close-btn {
            background: none; border: none; font-size: 1.3rem;
            cursor: pointer; color: #999; transition: color .2s;
        }
        .map-close-btn:hover { color: #e74c3c; }
        .map-modal iframe { width: 100%; height: 380px; border: none; display: block; }

        /* Pagination */
        .page-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 40px; height: 40px;
            padding: 0 14px;
            border: 1.5px solid #e6e6e6;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            font-size: .85rem;
            font-weight: 500;
            color: #444;
            transition: all .2s;
            font-family: 'Poppins', sans-serif;
        }
        .page-btn:not([disabled]):hover {
            border-color: #D4AF37;
            color: #D4AF37;
        }
        .page-btn.active-page {
            background: #D4AF37;
            color: white;
            border-color: #D4AF37;
            font-weight: 700;
        }
        .page-btn[disabled] {
            opacity: .4; cursor: not-allowed;
        }

        /* remove unused mobile menu styles */
    </style>
</head>



    <!-- ===== HEADER ===== -->
    <header id="mainHeader">
        <div class="container">
            <div class="nav-top">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="nav-logo">
                    <img src="{{ asset('Foto/Logo.png') }}" alt="King Gitar Logo">
                    <span class="nav-logo-name">KING GITAR</span>
                </a>
                <!-- Search -->
                <div class="nav-search">
                    <i class="fas fa-search" style="color:#aaa; font-size:0.85rem; flex-shrink:0;"></i>&nbsp;
                    <input type="text" id="searchInput" placeholder="Cari gitar berkualitas, coba lihat...">
                    <button class="nav-search-btn" id="searchBtn">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
                <!-- Right Actions -->
                <div class="nav-actions">
                    <a href="{{ url('/kategori') }}" class="nav-icon-btn" title="Kategori">
                        <i class="fas fa-th-large"></i>
                        <span>Kategori</span>
                    </a>
                    <button class="nav-icon-btn" id="openMapBtn" title="Lokasi Toko">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Maps</span>
                    </button>
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="nav-login-btn">Dashboard</a>
                        @else
                            <span class="nav-icon-btn"><i class="fas fa-user-circle"></i></span>
                        @endif
                    @else
                        <a href="{{ url('/login') }}" class="nav-login-btn">Masuk</a>
                    @endauth
                </div>
                <button class="mobile-burger-btn" id="mobileBurgerBtn" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <!-- Category Pills -->
            <nav class="nav-cats" id="navCatPills">
                <a href="{{ url('/katalog') }}" class="nav-cat-pill active">
                    <i class="fas fa-border-all"></i> Semua
                </a>
            </nav>
        </div>
    </header>

    <!-- MAP POPUP -->
    <div class="map-overlay" id="mapOverlay">
        <div class="map-modal">
            <div class="map-modal-header">
                <h3><i class="fas fa-map-marker-alt" style="color:#e74c3c; margin-right:6px;"></i> Lokasi Toko King Gitar</h3>
                <button class="map-close-btn" id="closeMapBtn"><i class="fas fa-times"></i></button>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0!2d106.8!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    <div class="mobile-menu-drawer" id="mobileMenuDrawer">
        <div class="mobile-menu-header">
            <div class="mobile-menu-title"><img src="{{ asset('Foto/Logo.png') }}" style="height:24px;" alt="Logo"> KING GITAR</div>
            <button class="mobile-menu-close" id="mobileMenuClose"><i class="fas fa-times"></i></button>
        </div>
        <ul class="mobile-menu-links">
            <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ url('/katalog') }}" class="active"><i class="fas fa-th-large"></i> Katalog</a></li>
            <li><a href="{{ url('/kategori') }}"><i class="fas fa-list"></i> Kategori</a></li>
            <li><a href="#" id="mobileOpenMapBtn"><i class="fas fa-map-marker-alt"></i> Lokasi Toko</a></li>
        </ul>
        <div class="mobile-menu-footer">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" style="display:block;text-align:center;background:#1a1a1a;color:white;padding:12px;border-radius:12px;text-decoration:none;font-weight:600;">Dashboard</a>
                @else
                    <div style="display:flex;align-items:center;gap:12px;padding:12px;background:#f5f3f0;border-radius:12px;">
                        <i class="fas fa-user-circle" style="font-size:1.5rem;color:#666;"></i>
                        <span style="font-weight:600;color:#1a1a1a;">{{ Auth::user()->name }}</span>
                    </div>
                @endif
            @else
                <a href="{{ url('/login') }}" style="display:block;text-align:center;background:#D4AF37;color:white;padding:12px;border-radius:12px;text-decoration:none;font-weight:600;">Masuk</a>
            @endauth
        </div>
    </div>

    {{-- Hero Banner Slider --}}

    <div class="hero">
        <div class="container">
            <div style="position:relative; border-radius:20px; overflow:hidden; background: #f8fafc;" id="bannerSlider">
                <!-- Loader placeholder -->
                <div id="bannerLoader" class="banner-loader-wrap">
                    <div class="banner-spinner"></div>
                </div>
                <!-- Slides injected by JS -->
                <div style="display:flex; transition:transform .6s cubic-bezier(.4,0,.2,1); opacity: 0;" id="bannerTrack">
                </div>

                <!-- Arrows -->
                <button onclick="moveBanner(-1)" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); background:rgba(0,0,0,.35); border:none; border-radius:50%; width:40px; height:40px; color:white; font-size:1.2rem; cursor:pointer; display:flex; align-items:center; justify-content:center;" aria-label="Prev"><i class="fas fa-chevron-left"></i></button>
                <button onclick="moveBanner(1)"  style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:rgba(0,0,0,.35); border:none; border-radius:50%; width:40px; height:40px; color:white; font-size:1.2rem; cursor:pointer; display:flex; align-items:center; justify-content:center;" aria-label="Next"><i class="fas fa-chevron-right"></i></button>

                <!-- Dots -->
                <div id="bannerDots" style="position:absolute; bottom:14px; left:50%; transform:translateX(-50%); display:flex; gap:7px;"></div>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <section class="products">
        <div class="container">
            <div class="products-grid" id="productsGrid">
                <!-- Products rendered via JS -->
            </div>
            <!-- Pagination -->
            <div id="pagination" style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;"></div>
        </div>
    </section>

    <!-- no sidebar styles needed anymore -->

    <!-- Unified Footer -->
    <style>
        .u-footer-wrap { background-color: #FFF4E6; padding: 60px 24px; color: #666; font-family: 'Poppins', sans-serif; font-size: 14px; }
        .u-footer-top { max-width: 1280px; margin: 0 auto; text-align: center; margin-bottom: 60px; }
        .u-footer-top h2 { font-size: 1.875rem; font-weight: 700; color: #1a1a1a; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 24px; font-family: serif; }
        .u-footer-grid { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: repeat(1, 1fr); gap: 32px; text-align: left; }
        @media (min-width: 768px) { .u-footer-grid { grid-template-columns: repeat(4, 1fr); } }
        .u-footer-col h3 { font-weight: 700; font-size: 1.125rem; margin-bottom: 16px; color: #1a1a1a; }
        .u-footer-col p { margin-bottom: 16px; cursor: pointer; transition: color 0.2s; }
        .u-footer-col p:hover { color: #D4AF37; }
        .u-footer-bottom-wrap { background-color: #FFF4E6; border-top: 1px solid #ebebeb; padding: 24px; }
        .u-footer-bottom { max-width: 1280px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; justify-content: space-between; gap: 16px; font-size: 14px; color: #666; }
        @media (min-width: 768px) { .u-footer-bottom { flex-direction: row; } }
        .u-footer-links { display: flex; gap: 24px; }
        .u-footer-links a { color: inherit; text-decoration: none; transition: color 0.2s; }
        .u-footer-links a:hover { color: #D4AF37; }
    </style>
    <section class="u-footer-wrap">
        <div class="u-footer-top">
            <h2 style="font-family: 'Playfair Display', serif;">Support</h2>
        </div>
        <div class="u-footer-grid">
            <div class="u-footer-col">
                <h3>Support</h3>
                <p>Pusat Bantuan</p>
                <p>Kebijakan Pengembalian</p>
                <p>Syarat & Ketentuan</p>
                <p>Panduan Pengguna</p>
                <p>Layanan Darurat 24/7</p>
            </div>
            <div class="u-footer-col">
                <h3>Hosting</h3>
                <p>Go-Host for Property Owners</p>
                <p>Go-Host Experience Partner</p>
                <p>Gabung Jadi Supir & Guide</p>
            </div>
            <div class="u-footer-col">
                <h3>GoFoot</h3>
                <p>GoFoot 2026 Experience Update</p>
                <p>Pusat Berita GoFoot</p>
                <p>Karier di GoFoot</p>
            </div>
            <div class="u-footer-col">
                <h3>Pusat Bantuan</h3>
                <p>Tanya Jawab Umum (FAQ)</p>
                <p>Panduan Penggunaan Aplikasi</p>
                <p>Cara Booking Layanan</p>
            </div>
        </div>
    </section>
    <footer class="u-footer-bottom-wrap">
        <div class="u-footer-bottom">
            <div>&copy; 2026 King Gitar. Developed with precision.</div>
            <div class="u-footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Sitemap</a>
            </div>
        </div>
    </footer>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

            // API Consumption Logic
            let currentPage = 1;
            let currentSearch = '';
            let currentCategory = '';

            const productsGrid = document.getElementById('productsGrid');
            const paginationMenu = document.getElementById('pagination');
            const navCatPills = document.getElementById('navCatPills');
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            // Banner slider globals (populated by fetchBanners)
            window.moveBanner = function() {}; // safe default before API loads
            window.goBanner   = function() {};

            function fetchBanners() {
                fetch('/api/v1/banners')
                    .then(res => res.json())
                    .then(res => {
                        if (!res.success || !res.data.length) return;
                        const banners = res.data;

                        const track = document.getElementById('bannerTrack');
                        const dotsEl = document.getElementById('bannerDots');
                        const loader = document.getElementById('bannerLoader');

                        track.innerHTML = banners.map(b => {
                            const img = b.image_url || '/Foto/8.png';
                            const inner = b.link
                                ? `<a href="${b.link}"><img src="${img}" style="width:100%; height:420px; object-fit:cover; display:block;" alt="${b.title||'Banner'}" onerror="this.src='/Foto/8.png'"></a>`
                                : `<img src="${img}" style="width:100%; height:420px; object-fit:cover; display:block;" alt="${b.title||'Banner'}" onerror="this.src='/Foto/8.png'">`;
                            return `<div style="flex-shrink:0; width:100%;">${inner}</div>`;
                        }).join('');

                        // Hide loader, show track
                        if (loader) loader.style.display = 'none';
                        track.style.opacity = '1';

                        // Dots
                        dotsEl.innerHTML = banners.map((_, i) =>
                            `<button onclick="goBanner(${i})" data-bidx="${i}" style="width:9px; height:9px; border-radius:50%; border:none; background:${i===0?'#D4AF37':'rgba(255,255,255,.55)'}; cursor:pointer; transition:background .3s;"></button>`
                        ).join('');

                        // Auto-slide
                        let bannerIdx = 0;
                        window.goBanner = function(idx) {
                            bannerIdx = idx;
                            track.style.transform = `translateX(-${idx * 100}%)`;
                            dotsEl.querySelectorAll('button').forEach((d, i) =>
                                d.style.background = i === idx ? '#D4AF37' : 'rgba(255,255,255,.55)');
                        };
                        window.moveBanner = function(dir) {
                            goBanner((bannerIdx + dir + banners.length) % banners.length);
                        };

                        setInterval(() => moveBanner(1), 3500);
                    })
                    .catch(err => console.error(err));
            }

            function fetchCategories() {
                fetch('/api/v1/categories')
                    .then(res => res.json())
                    .then(res => {
                        // Start with the 'Semua' pill already in HTML
                        let pillsHtml = `<a href="{{ url('/katalog') }}" class="nav-cat-pill active"><i class="fas fa-border-all"></i> Semua</a>`;
                        if (res.success) {
                            res.data.forEach(cat => {
                                pillsHtml += `<a href="/kategori?category_id=${cat.id}" class="nav-cat-pill">🎸 ${cat.name}</a>`;
                            });
                        }
                        navCatPills.innerHTML = pillsHtml;
                    })
                    .catch(err => console.error(err));
            }

            function fetchProducts() {
                productsGrid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 40px;"><p>Sedang memuat produk...</p></div>';
                let url = `/api/v1/products?page=${currentPage}`;
                if (currentSearch) url += `&search=${encodeURIComponent(currentSearch)}`;
                if (currentCategory) url += `&category_id=${currentCategory}`;

                fetch(url)
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            renderProducts(res.data);
                            renderPagination(res.pagination);
                        } else {
                            productsGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center;">Gagal memuat produk.</p>';
                        }
                    })
                    .catch(() => {
                        productsGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center;">Terjadi kesalahan sistem.</p>';
                    });
            }

            function renderProducts(products) {
                if (products.length === 0) {
                    productsGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; padding: 40px; color:#666;">Tidak ada produk ditemukan.</p>';
                    return;
                }

                let html = '';
                products.forEach((p, idx) => {
                    let img = p.image_url ? p.image_url : '/Foto/default-guitar.png';
                    html += `
                        <div class="product-card reveal" style="animation-delay: ${idx * 100}ms">
                            <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                            <a href="/produk/${p.slug}" style="text-decoration: none; color: inherit;">
                                <img src="${img}" alt="${p.name}" class="product-image" loading="lazy" onerror="this.src='/Foto/default-guitar.png'">
                                <h3 class="product-name">${p.name}</h3>
                                <p class="product-price">${p.formatted_price}</p>
                            </a>
                        </div>
                    `;
                });
                productsGrid.innerHTML = html;

                // Trigger reveal functionality on dynamically added elements
                setTimeout(() => {
                    const revealElements = document.querySelectorAll('.product-card.reveal');
                    revealElements.forEach(el => revealObserver.observe(el));
                }, 100);
            }

            function renderPagination(meta) {
                if (!meta || meta.last_page <= 1) {
                    paginationMenu.innerHTML = '';
                    return;
                }

                let html = '';

                // Prev
                if (meta.current_page > 1) {
                    html += `<button class="page-btn" data-page="${meta.current_page - 1}">Previous</button>`;
                } else {
                    html += `<button class="page-btn" disabled style="opacity:0.5; cursor:not-allowed;">Previous</button>`;
                }

                // Pages
                for (let i = 1; i <= meta.last_page; i++) {
                    if (i === meta.current_page) {
                        html += `<button class="page-btn active-page" style="background:#D4AF37; color:white; border-color:#D4AF37;">${i}</button>`;
                    } else {
                        html += `<button class="page-btn" data-page="${i}">${i}</button>`;
                    }
                }

                // Next
                if (meta.current_page < meta.last_page) {
                    html += `<button class="page-btn" data-page="${meta.current_page + 1}">Next</button>`;
                } else {
                    html += `<button class="page-btn" disabled style="opacity:0.5; cursor:not-allowed;">Next</button>`;
                }

                paginationMenu.innerHTML = html;

                document.querySelectorAll('.page-btn[data-page]').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        currentPage = parseInt(e.currentTarget.getAttribute('data-page'));
                        fetchProducts();
                        window.scrollTo({ top: document.querySelector('.products').offsetTop - 100, behavior: 'smooth' });
                    });
                });
            }

            searchBtn.addEventListener('click', () => {
                currentSearch = searchInput.value;
                currentPage = 1;
                fetchProducts();
            });

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    currentSearch = searchInput.value;
                    currentPage = 1;
                    fetchProducts();
                }
            });

            // Mobile Menu Drawer Logic
            const mobileBurgerBtn = document.getElementById('mobileBurgerBtn');
            const mobileMenuClose = document.getElementById('mobileMenuClose');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const mobileMenuDrawer = document.getElementById('mobileMenuDrawer');

            function openMobileMenu() {
                mobileMenuOverlay.classList.add('active');
                mobileMenuDrawer.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileMenu() {
                mobileMenuOverlay.classList.remove('active');
                mobileMenuDrawer.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (mobileBurgerBtn) mobileBurgerBtn.addEventListener('click', openMobileMenu);
            if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMobileMenu);
            if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMobileMenu);

            // Map popup
            const openMapBtn = document.getElementById('openMapBtn');
            const mobileOpenMapBtn = document.getElementById('mobileOpenMapBtn');
            const closeMapBtn = document.getElementById('closeMapBtn');
            const mapOverlay = document.getElementById('mapOverlay');

            function openMap() {
                mapOverlay.classList.add('active');
                closeMobileMenu(); // close mobile drawer if open
            }

            if (openMapBtn) openMapBtn.addEventListener('click', openMap);
            if (mobileOpenMapBtn) mobileOpenMapBtn.addEventListener('click', (e) => { e.preventDefault(); openMap(); });
            if (closeMapBtn) closeMapBtn.addEventListener('click', () => mapOverlay.classList.remove('active'));
            if (mapOverlay) mapOverlay.addEventListener('click', (e) => { if (e.target === mapOverlay) mapOverlay.classList.remove('active'); });

            // Initialize
            fetchBanners();
            fetchCategories();
            fetchProducts();
        });
    </script>

    @include('partials.chatbot')
</body>

</html>