<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Catalog - KING GITAR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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

        /* ===== Header ===== */
        .dk-header {
            background-color: var(--bg-cream-light);
            padding: 16px 0;
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .dk-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        /* Logo */
        .dk-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-dark);
            flex-shrink: 0;
        }

        .dk-logo img {
            height: 40px;
            object-fit: contain;
        }

        .dk-logo-text {
            font-size: 1rem;
            font-weight: 700;
            font-style: italic;
            letter-spacing: 0.5px;
        }

        /* Category Pills */
        .dk-pills {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dk-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 50px;
            border: 1.5px solid var(--text-dark);
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .dk-pill:hover {
            background-color: var(--text-dark);
            color: #fff;
        }

        .dk-pill.active {
            background-color: var(--text-dark);
            color: #fff;
        }

        .dk-pill-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }

        /* Header Right Actions */
        .dk-actions {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-shrink: 0;
        }

        .dk-search-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--green);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .dk-search-btn:hover {
            transform: scale(1.08);
        }

        .dk-search-btn i {
            color: white;
            font-size: 0.95rem;
        }

        .dk-filter-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1.5px solid var(--border-light);
            border-radius: 8px;
            background: white;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .dk-filter-btn:hover {
            border-color: var(--text-dark);
        }

        .dk-filter-btn i {
            font-size: 0.9rem;
        }

        .dk-location {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
            cursor: pointer;
        }

        .dk-location-pin {
            color: var(--red-pin);
            font-size: 1.1rem;
        }

        .dk-profile {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .dk-profile:hover {
            opacity: 0.8;
        }

        .dk-profile i {
            color: white;
            font-size: 1rem;
        }

        /* ===== Main Content ===== */
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
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="dk-header">
        <div class="container dk-header-inner">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="dk-logo">
                <img src="{{ asset('Foto/Logo.png') }}" alt="King Gitar">
                <span class="dk-logo-text">King Gitar</span>
            </a>

            <!-- Category Pills -->
            <nav class="dk-pills">
                <a href="{{ url('/detail-katalog?jenis=classic') }}"
                    class="dk-pill {{ $jenisAktif == 'classic' ? 'active' : '' }}">
                    <span>🎸</span>
                    Classic
                </a>
                <a href="{{ url('/detail-katalog?jenis=akustik') }}"
                    class="dk-pill {{ $jenisAktif == 'akustik' ? 'active' : '' }}">
                    <span>🎸</span>
                    Akustik
                </a>
                <a href="{{ url('/detail-katalog?jenis=elektrik') }}"
                    class="dk-pill {{ $jenisAktif == 'elektrik' ? 'active' : '' }}">
                    <span>🎸</span>
                    Elektrik
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="dk-actions">
                <button class="dk-search-btn" aria-label="Cari">
                    <i class="fas fa-search"></i>
                </button>
                <button class="dk-filter-btn">
                    <i class="fas fa-sliders-h"></i>
                    Filter
                </button>
                <div class="dk-location">
                    <i class="fas fa-map-marker-alt dk-location-pin"></i>
                    Lokasi
                </div>
                <div class="dk-profile">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="dk-main">
        <div class="container">
            <div class="dk-content">

                <!-- Left: Product Grid -->
                <div class="dk-grid-panel">
                    <h2 class="dk-grid-title">Katalog {{ $kategori }}</h2>
                    <div class="dk-product-grid">
                        @foreach($guitars as $guitar)
                            <a href="{{ url('/produk/detail') }}" class="dk-card reveal">
                                <img src="{{ asset($guitar['gambar']) }}" alt="{{ $guitar['nama'] }}" class="dk-card__img"
                                    loading="lazy">
                                <h3 class="dk-card__name">{{ $guitar['nama'] }}</h3>
                                <span class="dk-card__price">{{ $guitar['harga'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Map -->
                <div class="dk-map-panel">
                    <div class="dk-map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0!2d106.8!3d-6.2!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDgnMDAuMCJF!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid"
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
    </main>

    <!-- Footer -->
    <footer class="dk-footer">
        <div class="container">
            <div class="dk-footer-grid">
                <!-- Column 1 -->
                <div class="dk-footer-col">
                    <h4>Support & Bantuan</h4>
                    <ul class="dk-footer-links">
                        <li><a href="#">FAQ (Pertanyaan Umum)</a></li>
                        <li><a href="#">Bantuan Teknis</a></li>
                        <li><a href="#">Panduan Website</a></li>
                        <li><a href="#">Live Chat Support</a></li>
                        <li><a href="#">Laporkan Masalah</a></li>
                        <li><a href="#">Hubungi Admin</a></li>
                    </ul>
                </div>
                <!-- Column 2 -->
                <div class="dk-footer-col">
                    <h4>Hosting</h4>
                    <ul class="dk-footer-links">
                        <li><a href="#">Hostinger</a></li>
                        <li><a href="#">Avanthoust</a></li>
                        <li><a href="#">Rumah Web</a></li>
                    </ul>
                </div>
                <!-- Column 3 -->
                <div class="dk-footer-col">
                    <h4>Jelajahi Gitar</h4>
                    <ul class="dk-footer-links">
                        <li><a href="#">Gitar Akustik</a></li>
                        <li><a href="#">Gitar Elektrik</a></li>
                        <li><a href="#">Gitar Klasik</a></li>
                        <li><a href="#">Gitar Custom</a></li>
                    </ul>
                </div>
                <!-- Column 4 -->
                <div class="dk-footer-col">
                    <h4>Servis & Custom Gitar</h4>
                    <ul class="dk-footer-links">
                        <li><a href="#">Setup & Tune Up</a></li>
                        <li><a href="#">Perbaikan Gitar</a></li>
                        <li><a href="#">Custom Body & Neck</a></li>
                        <li><a href="#">Upgrade Pickup</a></li>
                        <li><a href="#">Ganti Senar</a></li>
                        <li><a href="#">Restorasi Gitar Lama</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="dk-footer-bottom">
                <div class="dk-footer-bottom-left">
                    <span>&copy; 2026 Guitar Inc.</span>
                    <a href="#">Terms</a>
                    <a href="#">Sitemap</a>
                    <a href="#">Privacy</a>
                    <a href="#">Your Privacy Choices</a>
                </div>
                <div class="dk-footer-bottom-right">
                    <div class="dk-footer-lang">
                        <i class="fas fa-globe"></i>
                        English (US)
                    </div>
                    <span>Rp · IDR</span>
                    <div class="dk-footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

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

            const revealElements = document.querySelectorAll('.reveal');
            revealElements.forEach(el => revealObserver.observe(el));
        });
    </script>
</body>

</html>