<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['nama'] }} - KING GITAR</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-cream: #FFFBF5;
            --text-dark: #1A1A1A;
            --text-gray: #666666;
            --gold: #D4AF37;
            --green: #25D366;
            /* WhatsApp Green */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #F8F9FA;
            /* Light gray background for contrast with white cards */
            color: var(--text-dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- Header Specific --- */
        header {
            background-color: white;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 40px;
        }

        .search-container {
            flex-grow: 1;
            max-width: 600px;
            margin: 0 40px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px;
            border-radius: 50px;
            border: 1px solid #ddd;
            background-color: #f5f5f5;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s;
        }

        .search-input:focus {
            background-color: white;
            border-color: var(--gold);
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.2);
        }

        .user-actions {
            display: flex;
            gap: 20px;
            align-items: center;
            font-size: 1.2rem;
            color: #555;
        }

        .user-actions i {
            cursor: pointer;
            transition: color 0.2s;
        }

        .user-actions i:hover {
            color: var(--gold);
        }

        /* --- Main Layout --- */
        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 30px;
            margin-bottom: 60px;
        }

        /* Left Side */
        .product-title-section {
            margin-bottom: 20px;
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .product-hero {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            height: 400px;
            /* Fixed height to reduce size */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
        }

        .product-hero img {
            width: auto;
            height: 100%;
            max-width: 100%;
            object-fit: contain;
            /* Ensure image fits nicely */
            display: block;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 5px;
            transition: transform 0.2s;
        }

        .back-btn:hover {
            transform: translateX(-3px);
        }

        .description-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            margin-bottom: 30px;
        }

        .desc-point {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .desc-icon {
            width: 40px;
            height: 40px;
            background: #FFFBF5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .desc-text h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .desc-text p {
            font-size: 0.9rem;
            color: var(--text-gray);
            line-height: 1.5;
        }

        .technician-info {
            font-style: italic;
            color: var(--text-gray);
            font-size: 0.9rem;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px dashed #eee;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .feature-item {
            background: white;
            padding: 15px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .feature-item i {
            color: var(--gold);
            font-size: 1.2rem;
        }

        .feature-item span {
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Right Side (Sidebar) */
        .sidebar-banner {
            background: #FFF5F5;
            color: #E74C3C;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            border: 1px dashed #FFCCCC;
        }

        .purchase-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            /* Strong shadow */
            position: sticky;
            top: 100px;
        }

        .price-tag {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 25px;
            letter-spacing: -1px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-box {
            background: #FAFAFA;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #eee;
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--text-gray);
            margin-bottom: 5px;
            display: block;
        }

        .info-value {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Date Input inside info-box */
        .info-date-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            margin-top: 4px;
        }

        .info-date-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        }

        .info-date-input:hover {
            border-color: #ccc;
        }

        .cta-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background-color: var(--green);
            color: white;
            width: 100%;
            padding: 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 15px;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        .disclaimer {
            font-size: 0.75rem;
            color: #999;
            text-align: center;
            line-height: 1.4;
        }

        /* --- Footer (Copied from Catalog) --- */
        footer {
            background-color: var(--bg-cream);
            padding: 60px 0;
            margin-top: 60px;
            border-top: 1px solid #eee;
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
            color: var(--gold);
        }

        @media (max-width: 900px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .search-container {
                display: none;
                /* Hide on small screens for simplicity or move to toggle */
            }

            .purchase-card {
                position: static;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container header-content">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('Foto/Logo.png') }}" alt="King Gitar">
                KING GITAR
            </a>

            <div class="search-container">
                <input type="text" class="search-input" placeholder="......">
            </div>

            <div class="user-actions">
                <i class="far fa-user-circle"></i>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container main-content">

        <!-- Left Column -->
        <div class="left-col">
            <div class="product-title-section">
                <h1 class="product-title">{{ $product['nama'] }} – Kualitas Premium King Gitar</h1>
            </div>

            <div class="product-hero">
                <a href="{{ url('/katalog') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <img src="{{ asset($product['gambar']) }}" alt="{{ $product['nama'] }}">
            </div>

            <div class="description-box">
                <div class="desc-point">
                    <div class="desc-icon"><i class="fas fa-guitar"></i></div>
                    <div class="desc-text">
                        <h4>Material Premium</h4>
                        <p>Body Solid Top Spruce dengan Mahogany Back & Sides, menghasilkan suara yang hangat dan
                            jernih.</p>
                    </div>
                </div>
                <div class="desc-point">
                    <div class="desc-icon"><i class="fas fa-music"></i></div>
                    <div class="desc-text">
                        <h4>Suara Jernih</h4>
                        <p>Didesain untuk proyeksi suara maksimal, cocok untuk fingerstyle maupun strumming.</p>
                    </div>
                </div>
                <div class="desc-point">
                    <div class="desc-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="desc-text">
                        <h4>Lokasi Toko</h4>
                        <p>Tersedia untuk dicoba langsung di showroom kami di Jakarta Selatan.</p>
                    </div>
                </div>

                <div class="technician-info">
                    Disiapkan oleh: Lucky & Teknisi King Gitar – Setup Expert
                </div>
            </div>

            <div class="feature-grid">
                <div class="feature-item">
                    <i class="fas fa-trophy"></i>
                    <span>Top Quality Sound</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-clock"></i>
                    <span>Siap Pakai</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-sliders-h"></i>
                    <span>Bisa Custom</span>
                </div>
            </div>
        </div>

        <!-- Right Column (Sidebar) -->
        <div class="right-col">
            <div class="sidebar-banner">
                <i class="fas fa-tag"></i> Gak sempet antri? Pesan online
            </div>

            <div class="purchase-card">
                <div class="price-tag">{{ $product['harga'] }}</div>

                <div class="info-grid">
                    <div class="info-box">
                        <span class="info-label">Kategori produk</span>
                        <span class="info-value">{{ $product['kategori'] }}</span>
                    </div>
                    <div class="info-box">
                        <span class="info-label">Jumlah Produk</span>
                        <span class="info-value">1 Unit</span>
                    </div>
                    <div class="info-box">
                        <span class="info-label">Waktu Pengambilan</span>
                        <input type="date" class="info-date-input" id="pickup-date" name="pickup_date">
                    </div>
                </div>

                <a href="#" class="cta-button">
                    <i class="fab fa-whatsapp"></i> Pesan Sekarang
                </a>

                <p class="disclaimer">
                    *Harga dapat berubah sewaktu-waktu. Hubungi kami untuk ketersediaan warna dan spesifikasi khusus.
                </p>
            </div>
        </div>
    </div>

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
                </div>

                <!-- Column 3 -->
                <div class="footer-col">
                    <h4>Tips & Edukasi</h4>
                    <ul class="footer-links">
                        <li><a href="#">Belajar Gitar Pemula</a></li>
                        <li><a href="#">Tips Perawatan Gitar</a></li>
                        <li><a href="#">Review Produk</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div class="footer-col">
                    <h4>Tentang King Gitar</h4>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Visi & Misi</a></li>
                        <li><a href="#">Kontak Kami</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>