<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Catalog - KING GITAR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @if(app()->environment('local'))
        <script src="https://cdn.tailwindcss.com"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"></head>

<body>

    <!-- ===== HEADER ===== -->
    <header class="kgn-header" id="kgnHeader">
        <div class="container">
            <div class="kgn-nav-top">
                <a href="{{ url('/') }}" class="kgn-logo">
                    <img src="{{ asset('Foto/Logo.png') }}" alt="King Gitar">
                    <span class="kgn-logo-name">KING GITAR</span>
                </a>
                <div class="kgn-search">
                    <i class="fas fa-search" style="color:#aaa;font-size:0.85rem;flex-shrink:0;"></i>&nbsp;
                    <input type="text" id="kgnSearchInput" placeholder="Cari gitar berdasarkan kategori...">
                    <button class="kgn-search-btn" id="kgnSearchBtn"><i class="fas fa-search"></i> Cari</button>
                </div>
                <div class="kgn-actions">
                    <a href="{{ url('/katalog') }}" class="kgn-icon-btn" title="Katalog">
                        <i class="fas fa-th"></i><span>Katalog</span>
                    </a>
                    <button class="kgn-icon-btn" id="openMapBtn" title="Lokasi Toko">
                        <i class="fas fa-map-marker-alt"></i><span>Lokasi</span>
                    </button>
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="kgn-btn-dark">Dashboard</a>
                        @else
                            <span class="kgn-icon-btn"><i class="fas fa-user-circle"></i></span>
                        @endif
                    @else
                        <a href="{{ url('/login') }}" class="kgn-btn-dark">Masuk</a>
                    @endauth
                </div>
                <button class="mobile-burger-btn" id="mobileBurgerBtn" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- MAP POPUP -->
    <div class="map-overlay" id="mapOverlay">
        <div class="map-modal">
            <div class="map-modal-header">
                <h3><i class="fas fa-map-marker-alt" style="color:#e74c3c;margin-right:6px;"></i> Lokasi Toko King Gitar
                </h3>
                <button class="map-close-btn" id="closeMapBtn"><i class="fas fa-times"></i></button>
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2032374.2945433152!2d107.1970067!3d-5.7875148!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6939e4a1897f0b%3A0xdbb9cdb4a5a9b33a!2sLucky%20Gitar%20Store!5e0!3m2!1sid!2sid!4v1772457416730!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    <div class="mobile-menu-drawer" id="mobileMenuDrawer">
        <div class="mobile-menu-header">
            <div class="mobile-menu-title"><img src="{{ asset('Foto/Logo.png') }}" style="height:24px;" alt="Logo"> KING
                GITAR</div>
            <button class="mobile-menu-close" id="mobileMenuClose"><i class="fas fa-times"></i></button>
        </div>
        <ul class="mobile-menu-links">
            <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ url('/katalog') }}"><i class="fas fa-th-large"></i> Katalog</a></li>
            <li><a href="{{ url('/kategori') }}" class="active"><i class="fas fa-list"></i> Kategori</a></li>
            <li><a href="#" id="mobileOpenMapBtn"><i class="fas fa-map-marker-alt"></i> Lokasi Toko</a></li>
        </ul>
        <div class="mobile-menu-footer">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        style="display:block;text-align:center;background:#1a1a1a;color:white;padding:12px;border-radius:8px;text-decoration:none;font-weight:500;">
                        Dashboard
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit"
                            style="width:100%;text-align:center;background:#f3f4f6;color:#1f2937;padding:12px;border-radius:8px;border:none;font-weight:500;cursor:pointer;">
                            Logout
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                    style="display:block;text-align:center;background:#1a1a1a;color:white;padding:12px;border-radius:8px;text-decoration:none;font-weight:500;">
                    Masuk
                </a>
            @endauth
        </div>
    </div>

    <!-- Main Content -->

    <main class="dk-main">
        <div class="container">
            <div class="dk-content">

                <!-- Left: Sidebar (Categories + Map) -->
                <div class="dk-map-panel" style="flex: 0 0 30%;">

                    <!-- Category Filter -->
                    <div
                        style="background: white; border-radius: 20px; border: 1px solid var(--border-light); padding: 24px; margin-bottom: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; color: var(--text-dark);">
                            Kategori Produk</h3>
                        <ul id="categoryList" style="list-style: none; padding: 0; margin: 0;">
                            <li><span style="color: #999; font-size: 0.9rem;">Memuat daftar kategori...</span></li>
                        </ul>
                    </div>

                    <!-- Map Embed -->
                    <div class="dk-map-container" style="height: 300px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2032374.2945433152!2d107.1970067!3d-5.7875148!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6939e4a1897f0b%3A0xdbb9cdb4a5a9b33a!2sLucky%20Gitar%20Store!5e0!3m2!1sid!2sid!4v1772457416730!5m2!1sid!2sid"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <div class="dk-map-label">
                            <i class="fas fa-map-marker-alt"></i>
                            King Electric Guitars
                        </div>
                    </div>
                </div>

                <!-- Right: Product Grid -->
                <div class="dk-grid-panel" style="flex: 0 0 68%;">
                    <h2 class="dk-grid-title" id="gridTitle">Semua Produk</h2>
                    <div class="dk-product-grid" id="productsGrid">
                        <!-- Products rendered via JS -->
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
                    </div>
                </div>

            </div>
        </div>
    </main>@include('partials.footer')

    <!-- Mobile Menu Container -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    <div class="mobile-menu-drawer" id="mobileMenuDrawer">
        <div class="mobile-menu-header">
            <div class="mobile-menu-title flex items-center gap-2">
                <img src="{{ asset('Foto/Logo.png') }}" style="height:24px;" alt="Logo"> KING GITAR
            </div>
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-menu-links">
            <li><a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ url('/katalog') }}"><i class="fas fa-th-large"></i> Katalog</a></li>
            <li><a href="{{ url('/kategori') }}" class="active"><i class="fas fa-list"></i> Kategori</a></li>
            <li><a href="#" id="mobileOpenMapBtn"><i class="fas fa-map-marker-alt"></i> Lokasi Toko (Maps)</a></li>
        </ul>
        <div class="mobile-menu-footer">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}"
                        style="display:block;text-align:center;background:#1a1a1a;color:white;padding:12px;border-radius:8px;text-decoration:none;font-weight:500;">
                        Dashboard
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit"
                            style="width:100%;text-align:center;background:#f3f4f6;color:#1f2937;padding:12px;border-radius:8px;border:none;font-weight:500;cursor:pointer;">
                            Logout
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}"
                    style="display:block;text-align:center;background:#1a1a1a;color:white;padding:12px;border-radius:8px;text-decoration:none;font-weight:500;">
                    Masuk
                </a>
            @endauth
        </div>
    </div>


    <style>

        html {
            scroll-behavior: smooth;
        }

        /* ===== Reset & Base ===== */
        :root {
            --bg-cream: #FFF8EE;
            --bg-cream-light: #FFFBF5;
            --text-dark: #1A1A1A;
            --text-gray: #666666;
            --gold: #D4AF37;
            --green: #25D366;
            --red-pin: #E74C3C;
            --border-light: #e8e8e8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-cream);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== NAV (Professional E-commerce) ===== */
        .kgn-header {
            background-color: white;
            border-bottom: 1px solid #f0ede8;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: box-shadow 0.3s ease;
        }

        .kgn-header.scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .kgn-nav-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 14px 0;
        }

        .kgn-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #1a1a1a;
            flex-shrink: 0;
        }

        .kgn-logo img {
            height: 38px;
            object-fit: contain;
        }

        .kgn-logo-name {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            font-family: 'Playfair Display', serif;
            text-transform: uppercase;
        }

        .kgn-search {
            flex: 1;
            max-width: 540px;
            display: flex;
            align-items: center;
            background: #f5f3f0;
            border-radius: 50px;
            padding: 0 6px 0 18px;
            border: 1.5px solid transparent;
            transition: border-color 0.3s, background 0.3s;
        }

        .kgn-search:focus-within {
            background: white;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .kgn-search input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.9rem;
            color: #1a1a1a;
            padding: 10px 0;
            font-family: 'Poppins', sans-serif;
        }

        .kgn-search input::placeholder {
            color: #aaa;
        }

        .kgn-search-btn {
            background: #D4AF37;
            border: none;
            border-radius: 50px;
            padding: 9px 18px;
            color: white;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .kgn-search-btn:hover {
            background: #c9a22e;
        }

        .kgn-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .kgn-icon-btn {
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

        .kgn-icon-btn i {
            font-size: 1.1rem;
        }

        .kgn-icon-btn:hover {
            color: #D4AF37;
        }

        .kgn-btn-dark {
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

        .kgn-btn-dark:hover {
            background: #D4AF37;
        }

        /* ===== Main Content ===== */
        /* ===== MAP POPUP ===== */
        .map-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .map-overlay.active {
            display: flex;
        }

        .map-modal {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            width: 90%;
            max-width: 700px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
        }

        .map-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-light);
        }

        .map-modal-header h3 {
            font-size: 1rem;
            font-weight: 600;
        }

        .map-close-btn {
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #999;
            transition: color .2s;
        }

        .map-close-btn:hover {
            color: #e74c3c;
        }

        .map-modal iframe {
            width: 100%;
            height: 380px;
            border: none;
            display: block;
        }

        .dk-main {
            padding: 30px 0 50px;
        }

        .dk-content {
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        /* --- Left: Product Grid --- */
        .dk-grid-panel {
            flex: 0 0 63%;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--border-light);
            padding: 28px;
            min-height: 700px;
        }

        .dk-grid-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        .dk-product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .dk-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 16px;
            border: 1px solid var(--border-light);
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            gap: 12px;
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

        .dk-card:hover {
            border-color: var(--gold);
            box-shadow: 0 4px 16px rgba(212, 175, 55, 0.12);
            transform: translateY(-2px);
        }

        .dk-card__img {
            width: 100%;
            height: 140px;
            object-fit: contain;
            margin: 0 auto;
        }

        .dk-card__name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .dk-card__price {
            font-size: 0.85rem;
            color: var(--gold);
            font-weight: 700;
        }

        /* --- Right: Map --- */
        .dk-map-panel {
            flex: 0 0 35%;
            position: sticky;
            top: 90px;
        }

        .dk-map-container {
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            height: 360px;
            border: 1px solid var(--border-light);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .dk-map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .dk-map-label {
            position: absolute;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-dark);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .dk-map-label i {
            color: var(--red-pin);
            font-size: 0.85rem;
        }

        /* ===== Footer ===== */
        .dk-footer {
            background-color: var(--bg-cream-light);
            padding: 50px 0 30px;
            border-top: 1px solid var(--border-light);
        }

        .dk-footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        .dk-footer-col h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 18px;
        }

        .dk-footer-links {
            list-style: none;
        }

        .dk-footer-links li {
            margin-bottom: 10px;
        }

        .dk-footer-links a {
            text-decoration: none;
            color: var(--text-gray);
            font-size: 0.82rem;
            transition: color 0.2s;
        }

        .dk-footer-links a:hover {
            color: var(--gold);
        }

        .dk-footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid var(--border-light);
            font-size: 0.75rem;
            color: #999;
        }

        .dk-footer-bottom-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .dk-footer-bottom-left a {
            color: #999;
            text-decoration: none;
            transition: color 0.2s;
        }

        .dk-footer-bottom-left a:hover {
            color: var(--text-dark);
        }

        .dk-footer-bottom-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .dk-footer-lang {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            color: var(--text-gray);
        }

        .dk-footer-social {
            display: flex;
            gap: 12px;
        }

        .dk-footer-social a {
            color: var(--text-gray);
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .dk-footer-social a:hover {
            color: var(--text-dark);
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .dk-content {
                flex-direction: column;
            }

            .dk-grid-panel,
            .dk-map-panel {
                flex: 0 0 100%;
                width: 100%;
            }

            .dk-map-panel {
                position: static;
            }

            .dk-map-container {
                height: 280px;
            }

            .dk-pills {
                display: none;
            }

            .dk-footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .kgn-nav-top {
                flex-wrap: nowrap;
                gap: 8px;
                padding: 10px 0;
            }

            .kgn-logo {
                display: none;
            }

            .kgn-search {
                flex: 1;
                min-width: 0;
                margin-top: 0;
                max-width: none;
            }

            .kgn-search input {
                min-width: 0;
            }

            .kgn-actions {
                display: none;
            }

            .mobile-burger-btn {
                display: flex !important;
                margin-left: 0;
                flex-shrink: 0;
            }
        }

        @media (max-width: 640px) {
            .dk-product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .dk-header-inner {
                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;
            }

            .dk-actions {
                gap: 12px;
            }

            .dk-footer-grid {
                grid-template-columns: 1fr;
            }

            .dk-footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .kgn-search {
                margin-top: 0;
            }

            .kgn-search-btn span {
                display: none;
            }

            .kgn-search-btn {
                padding: 9px 12px;
            }
        }

        .mobile-menu-title img {
            display: none !important;
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
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
        }

        .mobile-menu-overlay.active {
            display: block;
        }

        .mobile-menu-drawer {
            position: fixed;
            top: 0;
            right: -280px;
            width: 280px;
            height: 100vh;
            background: white;
            z-index: 2001;
            transition: right 0.3s ease;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .mobile-menu-drawer.active {
            right: 0;
        }

        .mobile-menu-header {
            padding: 20px;
            border-bottom: 1px solid #f0ede8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu-title {
            font-weight: 700;
            font-size: 1.1rem;
            font-family: 'Times New Roman', serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .mobile-menu-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
        }

        .mobile-menu-close:hover {
            color: #e74c3c;
        }

        .mobile-menu-links {
            list-style: none;
            padding: 20px 0;
            overflow-y: auto;
            flex: 1;
        }

        .mobile-menu-links li {
            margin-bottom: 5px;
        }

        .mobile-menu-links a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            text-decoration: none;
            color: #444;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }

        .mobile-menu-links a i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .mobile-menu-links a:hover,
        .mobile-menu-links a.active {
            background: #fefcf9;
            color: #D4AF37;
        }

        .mobile-menu-footer {
            padding: 20px;
            border-top: 1px solid #f0ede8;
        }


        .dk-footer-grid {
            grid-template-columns: 1fr;
        }

        .dk-footer-bottom {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }
        }
    

        .cat-sidebar-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            margin-bottom: 8px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-gray);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            background: #fafafa;
            border: 1px solid transparent;
        }

        .cat-sidebar-link:hover {
            background: var(--bg-cream);
            color: var(--gold);
            border-color: var(--gold);
        }

        .cat-sidebar-link.active {
            background: var(--gold);
            color: white;
            border-color: var(--gold);
        }

        .cat-sidebar-badge {
            background: #eaeaea;
            color: #666;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .cat-sidebar-link.active .cat-sidebar-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .page-btn {
            padding: 8px 16px;
            border: 1px solid var(--border-light);
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
            color: var(--text-dark);
        }

        .page-btn:not([disabled]):hover {
            background: #f8f8f8;
            border-color: #ddd;
        }

        .page-btn.active-page {
            background: var(--gold);
            color: white;
            border-color: var(--gold);
        }

        @media (max-width: 992px) {
            .dk-content {
                flex-direction: column-reverse;
            }

            .dk-map-panel,
            .dk-grid-panel {
                flex: 0 0 100% !important;
            }
        }
    
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Scroll Reveal Animation with Intersection Observer
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        // Staggered effect for cards in the same viewport
                        setTimeout(() => {
                            entry.target.classList.add('active');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // API fetching
            let currentPage = 1;
            let currentCategory = '';
            let currentSearch = '';

            // Allow category/search selection via URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('category_id')) {
                currentCategory = urlParams.get('category_id');
            }
            if (urlParams.has('search')) {
                currentSearch = urlParams.get('search');
                // Pre-fill search input
                const kgnSearchPrefill = document.getElementById('kgnSearchInput');
                if (kgnSearchPrefill) kgnSearchPrefill.value = currentSearch;
            }

            const productsGrid = document.getElementById('productsGrid');
            const categoryList = document.getElementById('categoryList');
            const paginationMenu = document.getElementById('pagination');
            const gridTitle = document.getElementById('gridTitle');

            function fetchCategories() {
                fetch('/api/v1/categories')
                    .then(res => res.json())
                    .then(res => {
                        let html = '';
                        // 'Semua Kategori' link
                        let activeAll = currentCategory === '' ? 'active' : '';
                        html += `<li><a href="#" class="cat-sidebar-link ${activeAll}" data-id="" data-name="Semua Produk">Semua Kategori</a></li>`;

                        if (res.success) {
                            res.data.forEach(cat => {
                                let activeCls = (currentCategory == cat.id) ? 'active' : '';
                                if (currentCategory == cat.id) {
                                    gridTitle.innerText = `Katalog: ${cat.name}`;
                                }
                                html += `<li>
                                    <a href="#" class="cat-sidebar-link ${activeCls}" data-id="${cat.id}" data-name="${cat.name}">
                                        ${cat.name} 
                                        <span class="cat-sidebar-badge">${cat.products_count}</span>
                                    </a>
                                </li>`;
                            });
                        }
                        categoryList.innerHTML = html;

                        document.querySelectorAll('.cat-sidebar-link').forEach(link => {
                            link.addEventListener('click', (e) => {
                                e.preventDefault();
                                document.querySelectorAll('.cat-sidebar-link').forEach(l => l.classList.remove('active'));
                                e.currentTarget.classList.add('active');

                                currentCategory = e.currentTarget.getAttribute('data-id');
                                let catName = e.currentTarget.getAttribute('data-name');
                                gridTitle.innerText = currentCategory ? `Katalog: ${catName}` : 'Semua Produk';

                                currentPage = 1;
                                fetchProducts();
                            });
                        });
                    })
                    .catch(err => console.error(err));
            }

            function fetchProducts() {
                productsGrid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 40px;"><p style="color:#666;">Sedang memuat produk...</p></div>';
                let url = `/api/v1/products?page=${currentPage}`;
                if (currentCategory) url += `&category_id=${currentCategory}`;
                if (currentSearch) url += `&search=${encodeURIComponent(currentSearch)}`;

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
                    productsGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; padding: 40px; color:#666;">Silakan cari produk lain. Produk belum tersedia.</p>';
                    return;
                }

                let html = '';
                products.forEach((p, idx) => {
                    let img = p.image_url ? p.image_url : '/Foto/default-guitar.png';
                    // Re-apply reveal animation dynamically
                    html += `
                        <a href="/produk/${p.slug}" class="dk-card reveal" style="animation-delay: ${idx * 100}ms">
                            <img src="${img}" alt="${p.name}" class="dk-card__img" loading="lazy" onerror="this.src='/Foto/default-guitar.png'">
                            <h3 class="dk-card__name">${p.name}</h3>
                            <span class="dk-card__price">${p.formatted_price}</span>
                        </a>
                    `;
                });
                productsGrid.innerHTML = html;

                // Trigger reveal functionality on dynamically added elements
                setTimeout(() => {
                    const revealElements = document.querySelectorAll('.dk-card.reveal');
                    revealElements.forEach(el => revealObserver.observe(el));
                }, 100);
            }

            function renderPagination(meta) {
                if (!meta || meta.last_page <= 1) {
                    paginationMenu.innerHTML = '';
                    return;
                }

                let html = '';
                if (meta.current_page > 1) {
                    html += `<button class="page-btn" data-page="${meta.current_page - 1}">Previous</button>`;
                } else {
                    html += `<button class="page-btn" disabled style="opacity:0.5; cursor:not-allowed;">Previous</button>`;
                }

                for (let i = 1; i <= meta.last_page; i++) {
                    if (i === meta.current_page) {
                        html += `<button class="page-btn active-page">${i}</button>`;
                    } else {
                        html += `<button class="page-btn" data-page="${i}">${i}</button>`;
                    }
                }

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
                        window.scrollTo({ top: document.querySelector('.dk-main').offsetTop - 100, behavior: 'smooth' });
                    });
                });
            }

            // Sticky header scroll effect
            window.addEventListener('scroll', function () {
                const h = document.getElementById('kgnHeader');
                if (h) h.classList.toggle('scrolled', window.scrollY > 10);
            });

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

            // Wire search bar
            const kgnSearch = document.getElementById('kgnSearchInput');
            const kgnSearchBtn = document.getElementById('kgnSearchBtn');

            function triggerSearch() {
                currentSearch = kgnSearch ? kgnSearch.value.trim() : '';
                currentPage = 1;
                fetchProducts();
            }

            if (kgnSearchBtn) kgnSearchBtn.addEventListener('click', triggerSearch);
            if (kgnSearch) kgnSearch.addEventListener('keypress', (e) => { if (e.key === 'Enter') triggerSearch(); });

            // Init
            fetchCategories();
            fetchProducts();
        });
    </script>

    @include('partials.chatbot')
</body>

</html>