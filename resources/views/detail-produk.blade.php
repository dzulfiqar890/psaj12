<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="pageTitle">Produk - KING GITAR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FFFBF5;
            --dark: #1A1A1A;
            --gray: #666666;
            --gold: #D4AF37;
            --green: #25D366;
            --border: #ebebeb;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f5f5f5; color: var(--dark); }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* ===== NAVBAR ===== */
        .nav-header {
            background: white;
            border-bottom: 1px solid #f0ede8;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: box-shadow .3s;
        }
        .nav-header.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,.08); }

        .nav-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 14px 0;
        }

        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; color: var(--dark); flex-shrink: 0;
        }
        .nav-logo img { height: 38px; object-fit: contain; }
        .nav-logo-name {
            font-size: 1.15rem; font-weight: 700;
            letter-spacing: 1.5px; font-family: 'Playfair Display', serif;
            text-transform: uppercase;
        }

        .nav-search {
            flex: 1; max-width: 540px;
            display: flex; align-items: center;
            background: #f5f3f0; border-radius: 50px;
            padding: 0 6px 0 18px;
            border: 1.5px solid transparent;
            transition: border-color .3s, background .3s;
        }
        .nav-search:focus-within {
            background: white; border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212,175,55,.1);
        }
        .nav-search input {
            flex: 1; min-width: 0; border: none; background: transparent;
            outline: none; font-size: .9rem; color: var(--dark);
            padding: 10px 0; font-family: 'Poppins', sans-serif;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .nav-search input::placeholder { color: #aaa; }
        .nav-search-btn {
            background: var(--gold); border: none; border-radius: 50px;
            padding: 9px 18px; color: white; font-size: .82rem;
            font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            transition: background .2s; white-space: nowrap;
        }
        .nav-search-btn:hover { background: #c9a22e; }

        .nav-actions { display: flex; align-items: center; gap: 18px; flex-shrink: 0; }
        .nav-icon-btn {
            display: flex; align-items: center; gap: 6px;
            text-decoration: none; color: #444;
            font-size: .82rem; font-weight: 500; cursor: pointer;
            transition: color .2s; background: none; border: none;
            font-family: 'Poppins', sans-serif;
        }
        .nav-icon-btn i { font-size: 1.1rem; }
        .nav-icon-btn:hover { color: var(--gold); }
        .nav-login-btn {
            background: var(--dark); color: white; border: none;
            border-radius: 50px; padding: 8px 22px;
            font-size: .82rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: background .2s;
            font-family: 'Poppins', sans-serif;
        }
        .nav-login-btn:hover { background: var(--gold); }

        /* ===== MAP POPUP ===== */
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
            padding: 16px 20px; border-bottom: 1px solid var(--border);
        }
        .map-modal-header h3 { font-size: 1rem; font-weight: 600; }
        .map-close-btn {
            background: none; border: none; font-size: 1.3rem;
            cursor: pointer; color: #999; transition: color .2s;
        }
        .map-close-btn:hover { color: #e74c3c; }
        .map-modal iframe { width: 100%; height: 380px; border: none; display: block; }

        /* ===== MAIN LAYOUT ===== */
        .page-wrapper { padding: 28px 0 60px; }

        .product-layout {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 30px;
            align-items: flex-start;
            min-width: 0;
        }

        /* ===== LEFT COLUMN ===== */
        .left-col { min-width: 0; overflow: hidden; }

        .product-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 18px;
            line-height: 1.35;
        }

        .product-image-card {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            position: relative;
            margin-bottom: 22px;
        }

        .back-btn {
            position: absolute;
            top: 14px; left: 14px;
            background: rgba(255,255,255,.92);
            border: 1px solid #e0e0e0;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            text-decoration: none;
            display: flex; align-items: center; gap: 5px;
            transition: transform .2s;
            z-index: 2;
        }
        .back-btn:hover { transform: translateX(-3px); }

        .product-main-img {
            width: 100%;
            height: 380px;
            object-fit: contain;
            display: block;
            background: #f9f8f6;
            padding: 20px;
        }

        /* Description */
        .desc-card {
            background: white;
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 18px;
            overflow: hidden;
        }

        .desc-card h3 {
            font-size: .95rem;
            font-weight: 600;
            margin-bottom: 14px;
        }

        .desc-points { list-style: none; }
        .desc-points li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            font-size: .88rem;
            color: #444;
            line-height: 1.5;
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .desc-points li span.icon { flex-shrink: 0; font-size: 1rem; }

        .technician-note {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px dashed #eee;
            font-size: .82rem;
            color: var(--gray);
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .feature-item {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-item .fi-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--cream);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .feature-item .fi-text h4 {
            font-size: .82rem; font-weight: 700; margin-bottom: 2px;
        }
        .feature-item .fi-text p {
            font-size: .72rem; color: var(--gray); line-height: 1.4;
        }

        /* ===== RIGHT COLUMN ===== */
        .right-col {
            min-width: 0;
        }

        .sidebar-alert {
            background: #FFF5F5;
            border: 1px dashed #FFCCCC;
            border-radius: 12px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .85rem;
            font-weight: 600;
            color: #D32F2F;
            margin-bottom: 16px;
        }

        .purchase-card {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 26px;
            top: 90px;
        }

        .price-tag {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 22px;
            letter-spacing: -.5px;
            line-height: 1.2;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--border);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            margin-bottom: 22px;
        }

        .info-box {
            background: white;
            padding: 14px 16px;
        }

        .info-label {
            font-size: .72rem;
            color: var(--gray);
            display: block;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: .85rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .info-value a { color: inherit; text-decoration: none; }
        .info-value a:hover { color: var(--gold); text-decoration: underline; }
        .info-chevron { font-size: .7rem; color: #999; }

        .info-box.full {
            grid-column: 1 / -1;
        }

        .info-date-input {
            width: 100%; border: none; outline: none;
            font-size: .85rem; font-weight: 600;
            color: var(--dark); font-family: 'Poppins', sans-serif;
            background: transparent; cursor: pointer;
        }

        .stock-badge-in {
            display: inline-flex; align-items: center; gap: 5px;
            background: #E8F5E9; color: #2E7D32;
            padding: 3px 10px; border-radius: 20px;
            font-size: .72rem; font-weight: 600;
        }

        .stock-badge-out {
            display: inline-flex; align-items: center; gap: 5px;
            background: #FFEBEE; color: #C62828;
            padding: 3px 10px; border-radius: 20px;
            font-size: .72rem; font-weight: 600;
        }

        .cta-btn {
            display: flex; align-items: center; justify-content: center;
            gap: 10px; background: var(--green); color: white;
            width: 100%; padding: 17px;
            border-radius: 12px; font-weight: 700;
            font-size: 1.1rem; text-decoration: none;
            border: none; cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            margin-bottom: 12px;
            font-family: 'Poppins', sans-serif;
        }
        .cta-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(46, 204, 113, 0.2); }
        .cta-btn.disabled {
            background: #cbd5e0 !important;
            color: #718096 !important;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none !important;
            transform: none !important;
        }

        .disclaimer {
            font-size: .72rem; color: #999;
            text-align: center; line-height: 1.5;
        }

        /* --- Sidebar Map --- */
        .dk-map-container {
            border-radius: 20px; overflow: hidden; position: relative;
            height: 300px; border: 1px solid var(--border-light);
            box-shadow: 0 4px 20px rgba(0,0,0,0.06); margin-top: 24px;
        }
        .dk-map-container iframe { width: 100%; height: 100%; border: none; display: block; }
        .dk-map-label {
            position: absolute; bottom: 12px; left: 12px;
            background: white; padding: 6px 12px;
            border-radius: 50px; font-size: 0.75rem;
            font-weight: 600; color: #1a1a1a;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: flex; align-items: center; gap: 6px;
        }
        .dk-map-label i { color: #e74c3c; }

        /* ===== LOADING STATE ===== */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--cream);
            padding: 50px 0 30px;
            border-top: 1px solid var(--border);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h4 { font-size: .88rem; font-weight: 700; margin-bottom: 16px; }

        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a {
            text-decoration: none; color: var(--gray);
            font-size: .82rem; transition: color .2s;
        }
        .footer-links a:hover { color: var(--gold); }

        .footer-bottom {
            display: flex; justify-content: space-between; align-items: center;
            padding-top: 20px; border-top: 1px solid var(--border);
            font-size: .72rem; color: #999;
            flex-wrap: wrap; gap: 10px;
        }

        .footer-bottom-left { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
        .footer-bottom-left a { color: #999; text-decoration: none; }
        .footer-bottom-left a:hover { color: var(--dark); }

        .footer-social { display: flex; gap: 12px; }
        .footer-social a { color: #999; transition: color .2s; }
        .footer-social a:hover { color: var(--dark); }

        @media (max-width: 900px) {
            .product-layout { grid-template-columns: 1fr; }
            .right-col { position: static; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .features-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .nav-top { flex-wrap: nowrap; gap: 10px; padding: 10px 0; }
            .nav-logo { display: none; }
            .nav-search { flex: 1; margin-top: 0; }
            .nav-actions { display: none; }
            .mobile-burger-btn { display: flex !important; margin-left: 0; }
        }

        @media (max-width: 620px) {
            .nav-search-btn span { padding: 9px 12px; }
            .price-tag { font-size: 1.5rem; }
            .footer-grid { grid-template-columns: 1fr; }
            .info-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; text-align: center; }
            .nav-search { margin-top: 0; }
        }

        /* Mobile Burger Button */
        .mobile-burger-btn {
            display: none; align-items: center; justify-content: center; background: none;
            border: none; font-size: 1.5rem; color: #1a1a1a; cursor: pointer; padding: 5px;
        }

        /* Mobile Menu Drawer */
        .mobile-menu-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; }
        .mobile-menu-overlay.active { display: block; }
        .mobile-menu-drawer {
            position: fixed; top: 0; right: -280px; width: 280px; height: 100vh;
            background: white; z-index: 2001; transition: right 0.3s ease;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1); display: flex; flex-direction: column;
        }
        .mobile-menu-drawer.active { right: 0; }
        .mobile-menu-header {
            padding: 20px; border-bottom: 1px solid #f0ede8; display: flex; justify-content: space-between; align-items: center;
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
    </style>
</head>

<body>

    <!-- ===== NAVBAR ===== -->
    <header class="nav-header" id="mainHeader">
        <div class="container">
            <div class="nav-top">
                <a href="{{ url('/') }}" class="nav-logo">
                    <img src="{{ asset('Foto/Logo.png') }}" alt="King Gitar">
                    <span class="nav-logo-name">KING GITAR</span>
                </a>
                <div class="nav-search">
                    <i class="fas fa-search" style="color:#aaa;font-size:.85rem;flex-shrink:0;"></i>&nbsp;
                    <input type="text" placeholder="Cari gitar impianmu...">
                    <button class="nav-search-btn" onclick="window.location='/katalog'">
                        <i class="fas fa-search"></i> <span>Cari</span>
                    </button>
                </div>
                <div class="nav-actions">
                    <a href="{{ url('/katalog') }}" class="nav-icon-btn" title="Katalog">
                        <i class="fas fa-th-large"></i><span>Katalog</span>
                    </a>
                    <button class="nav-icon-btn" id="openMapBtn" title="Lokasi Toko">
                        <i class="fas fa-map-marker-alt"></i><span>Maps</span>
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
        </div>
    </header>

    <!-- MAP POPUP -->
    <div class="map-overlay" id="mapOverlay">
        <div class="map-modal">
            <div class="map-modal-header">
                <h3><i class="fas fa-map-marker-alt" style="color:#e74c3c;margin-right:6px;"></i> Lokasi Toko King Gitar</h3>
                <button class="map-close-btn" id="closeMapBtn"><i class="fas fa-times"></i></button>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2032374.2945433152!2d107.1970067!3d-5.7875148!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6939e4a1897f0b%3A0xdbb9cdb4a5a9b33a!2sLucky%20Gitar%20Store!5e0!3m2!1sid!2sid!4v1772457416730!5m2!1sid!2sid"
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
            <li><a href="{{ url('/katalog') }}"><i class="fas fa-th-large"></i> Katalog</a></li>
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

    <!-- ===== MAIN CONTENT ===== -->

    <div class="page-wrapper" id="pageContent" style="display:none;">
        <div class="container">
            <div class="product-layout">

                <!-- LEFT COLUMN -->
                <div class="left-col">
                    <h1 class="product-title" id="prodTitle">Memuat...</h1>

                    <div class="product-image-card">
                        <a href="{{ url('/katalog') }}" class="back-btn">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <img src="{{ asset('Foto/default-guitar.png') }}" id="prodImg" alt="Product" class="product-main-img" onerror="this.src='/Foto/default-guitar.png'">
                    </div>

                    <div class="desc-card">
                        <h3>Deskripsi Singkat</h3>
                        <div class="technician-note" id="prodDesc">
                            Memuat deskripsi...
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="right-col">
                    <div class="sidebar-alert">
                        <span>🏷️</span> Gak sempet antri? Pesan online
                    </div>

                    <div class="purchase-card">
                        <div class="price-tag" id="prodPrice">Rp –</div>

                        <div class="info-grid">
                            <div class="info-box">
                                <span class="info-label">Kategori produk</span>
                                <span class="info-value" id="prodCategory">
                                    – <span class="info-chevron">›</span>
                                </span>
                            </div>
                            <div class="info-box">
                                <span class="info-label">Jumlah Produk</span>
                                <span class="info-value" id="prodStock">
                                    – <span class="info-chevron">›</span>
                                </span>
                            </div>
                            <div class="info-box full">
                                <span class="info-label">Waktu Pengambilan / Pengiriman</span>
                                <span class="info-value">
                                    <input type="date" class="info-date-input" id="pickupDate">
                                    <span class="info-chevron">›</span>
                                </span>
                            </div>
                        </div>

                        <a href="#" class="cta-btn" id="ctaBtn">
                            <i class="fab fa-whatsapp"></i> Pesan
                        </a>

                        <p class="disclaimer">Pesanan kamu akan langsung kami proses, tinggal klik!</p>
                    </div>

                    <!-- Map Embed -->
                    <div class="dk-map-container">
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

            </div>
        </div>
    </div>

    <!-- Loading state -->
    <div class="container" id="loadingState" style="padding: 60px 0;">
        <div class="product-layout">
            <div class="left-col">
                <div class="skeleton" style="height:28px; width:70%; margin-bottom:20px;"></div>
                <div class="skeleton" style="height:380px; border-radius:16px; margin-bottom:22px;"></div>
                <div class="skeleton" style="height:180px; border-radius:14px;"></div>
            </div>
            <div class="right-col">
                <div class="skeleton" style="height:50px; border-radius:12px; margin-bottom:16px;"></div>
                <div class="skeleton" style="height:350px; border-radius:16px;"></div>
            </div>
        </div>
    </div>

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
            <li><a href="{{ url('/kategori') }}"><i class="fas fa-list"></i> Kategori</a></li>
            <li><a href="#" id="mobileOpenMapBtn"><i class="fas fa-map-marker-alt"></i> Lokasi Toko (Maps)</a></li>
        </ul>
        <div class="mobile-menu-footer">
            @auth
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" style="display:block; text-align:center; background:#1a1a1a; color:white; padding:12px; border-radius:12px; text-decoration:none; font-weight:600;">Dashboard</a>
                @else
                    <div style="display:flex; align-items:center; gap:12px; padding:12px; background:#f5f3f0; border-radius:12px;">
                        <i class="fas fa-user-circle" style="font-size:1.5rem; color:#666;"></i>
                        <span style="font-weight:600; color:#1a1a1a;">{{ Auth::user()->name }}</span>
                    </div>
                @endif
            @else
                <a href="{{ url('/login') }}" style="display:block; text-align:center; background:#D4AF37; color:white; padding:12px; border-radius:12px; text-decoration:none; font-weight:600;">Masuk / Daftar</a>
            @endauth
        </div>
    </div>

    <script>
        // Sticky header
        window.addEventListener('scroll', () => {
            document.getElementById('mainHeader').classList.toggle('scrolled', window.scrollY > 10);
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

        // Set default pickup date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('pickupDate').value = today;

        // Get slug from URL
        const pathParts = window.location.pathname.split('/');
        const slug = pathParts[pathParts.length - 1];

        // Fetch product from API
        async function loadProduct() {
            try {
                const res = await fetch(`/api/v1/products/${slug}`);
                const data = await res.json();

                if (!data.success || !data.data) {
                    document.getElementById('loadingState').innerHTML =
                        `<div style="text-align:center; padding: 80px 20px;">
                            <i class="fas fa-exclamation-circle" style="font-size:3rem; color:#ddd;"></i>
                            <p style="margin-top:16px; color:#999;">Produk tidak ditemukan.</p>
                            <a href="/katalog" style="display:inline-block; margin-top:16px; color:#D4AF37; font-weight:600;">← Kembali ke Katalog</a>
                        </div>`;
                    return;
                }

                const p = data.data;

                // Title
                document.title = `${p.name} - KING GITAR`;
                document.getElementById('prodTitle').textContent = `${p.name} – Kualitas Premium King Gitar`;
                document.getElementById('pageTitle').textContent = p.name + ' - KING GITAR';

                // Image
                const img = document.getElementById('prodImg');
                img.src = p.image_url || '/Foto/default-guitar.png';
                img.alt = p.name;

                // Description
                document.getElementById('prodDesc').innerHTML = p.description || 'Tidak ada deskripsi untuk produk ini.';

                // Price
                document.getElementById('prodPrice').textContent = p.formatted_price || `Rp ${Number(p.price).toLocaleString('id-ID')}`;

                // Category
                const catEl = document.getElementById('prodCategory');
                if (p.category) {
                    catEl.innerHTML = `<a href="/kategori?category_id=${p.category_id}">${p.category.name}</a> <span class="info-chevron">›</span>`;
                } else {
                    catEl.textContent = 'Umum';
                }

                // Stock
                const stockEl = document.getElementById('prodStock');
                stockEl.innerHTML = p.is_in_stock
                    ? `<span class="stock-badge-in"><i class="fas fa-check-circle"></i> Tersedia: ${p.stock} unit</span>`
                    : `<span class="stock-badge-out"><i class="fas fa-times-circle"></i> Habis</span>`;

                // WhatsApp CTA
                const waNumber = '{{ config("app.whatsapp_admin_number", "6285724453063") }}';
                const pickupDate = document.getElementById('pickupDate').value;
                function buildWaUrl() {
                    const pd = document.getElementById('pickupDate').value;
                    const msg = `Halo King Gitar \n\nSaya ingin memesan:\n *${p.name}*\n Harga: ${p.formatted_price || p.price}\n Pengambilan: ${pd}\n\nMohon informasi ketersediaan, terima kasih!`;
                    return `https://wa.me/${waNumber}?text=${encodeURIComponent(msg)}`;
                }

                const ctaBtn = document.getElementById('ctaBtn');
                if (p.is_in_stock) {
                    ctaBtn.href = buildWaUrl();
                    ctaBtn.target = '_blank';
                    ctaBtn.classList.remove('disabled');
                    ctaBtn.innerHTML = `<i class="fab fa-whatsapp"></i> Ambil Sekarang`;
                } else {
                    ctaBtn.href = '#';
                    ctaBtn.target = '';
                    ctaBtn.classList.add('disabled');
                    ctaBtn.innerHTML = `<i class="fas fa-times-circle"></i> Stok Habis`;
                }

                document.getElementById('pickupDate').addEventListener('change', () => {
                    if (p.is_in_stock) ctaBtn.href = buildWaUrl();
                });

                // Show content
                document.getElementById('loadingState').style.display = 'none';
                document.getElementById('pageContent').style.display = 'block';

            } catch (err) {
                console.error(err);
                document.getElementById('loadingState').innerHTML =
                    `<div style="text-align:center; padding: 80px;">
                        <p style="color:#999;">Gagal memuat produk. Silakan coba lagi.</p>
                        <a href="/katalog" style="display:inline-block; margin-top:16px; color:#D4AF37; font-weight:600;">← Kembali ke Katalog</a>
                    </div>`;
            }
        }

        loadProduct();
    </script>

    @include('partials.chatbot')

</body>

</html>