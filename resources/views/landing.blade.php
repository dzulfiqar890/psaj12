<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Gitar - Premium Guitar Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        gold: {
                            500: '#D4AF37',
                            600: '#C5A028',
                        },
                        dark: {
                            900: '#1a1a1a',
                            800: '#2d2d2d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-bg {
            position: relative;
            background-image: url('{{ asset("Foto/1.png") }}');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .hero-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            /* tingkat gelap */
            backdrop-filter: blur(3px);
            /* blur halus */
            z-index: 1;
        }

        .hero-bg>* {
            position: relative;
            z-index: 2;
            /* konten tetap tajam */
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #C5A028;
        }

        /* Glassmorphism for Testimonial Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
        }

        /* Smooth transitions for navbar */
        .nav-scrolled {
            background-color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .nav-transparent {
            background-color: transparent;
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        /* Active Link Scroll State */
        .nav-link.active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>

<body class="font-sans text-gray-800 antialiased bg-[#FAF9F6]">

    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6 px-6 lg:px-12 nav-transparent">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#"
                class="text-2xl font-serif font-bold text-white transition-colors duration-300 flex items-center gap-2 group">
                <span class="text-gold-500 text-3xl group-hover:scale-110 transition-transform duration-300"><img
                        src="{{ asset('Foto/Logo.png') }}" alt="" class="w-10 h-10"></span>
                <span id="brand-name">King Gitar</span>
            </a>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="#home"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Home</a>
                <a href="{{ url('/katalog') }}"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Catalog</a>
                <a href="#about"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">About</a>
                <a href="#contact"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Contact</a>

                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="nav-link text-white/90 hover:text-gold-500 transition-all duration-300 font-medium text-sm uppercase tracking-wider border border-current rounded-full px-6 py-2 hover:bg-gold-500/10">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="nav-link text-white/90 hover:text-gold-500 transition-all duration-300 font-medium text-sm uppercase tracking-wider border border-current rounded-full px-6 py-2 hover:bg-gold-500/10">
                        Login
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu-overlay"
            class="fixed inset-0 bg-black/50 z-[60] hidden transition-opacity duration-300 opacity-0 md:hidden"
            aria-hidden="true"></div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu-drawer"
            class="fixed inset-y-0 right-0 w-64 bg-white z-[70] transform translate-x-full transition-transform duration-300 ease-in-out md:hidden shadow-2xl flex flex-col">
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <span class="text-xl font-serif font-bold text-dark-900">Menu</span>
                <button id="mobile-menu-close"
                    class="text-gray-500 hover:text-red-500 focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <nav class="flex flex-col space-y-1 px-4">
                    <a href="#home"
                        class="block px-4 py-3 bg-gold-500/10 text-gold-500 rounded-lg transition-colors font-bold border-l-4 border-gold-500">Home</a>
                    <a href="#about"
                        class="block px-4 py-3 text-gray-800 hover:bg-gold-500/10 hover:text-gold-500 rounded-lg transition-colors font-medium">About
                        Us</a>
                    <a href="{{ url('/katalog') }}"
                        class="block px-4 py-3 text-gray-800 hover:bg-gold-500/10 hover:text-gold-500 rounded-lg transition-colors font-medium">Katalog</a>
                    <a href="#contact"
                        class="block px-4 py-3 text-gray-800 hover:bg-gold-500/10 hover:text-gold-500 rounded-lg transition-colors font-medium">Contact</a>
                </nav>
            </div>
            <div class="p-4 border-t border-gray-100">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full text-center px-4 py-3 bg-dark-900 hover:bg-gold-500 text-white font-medium rounded-lg transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative h-screen flex items-center justify-start hero-bg">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/20 to-transparent"></div>
        <div class="relative z-10 px-6 lg:px-12 max-w-7xl mx-auto w-full fade-in-up flex justify-start">
            <div class="max-w-2xl text-left">
                <h1 class="text-5xl md:text-7xl font-serif font-bold text-white mb-6 leading-tight drop-shadow-2xl">
                    King Gitar <br>

                </h1>
                <p class="text-lg md:text-xl text-gray-200 mb-10 font-light leading-relaxed">
                    King Gitar adalah platform e-commerce yang menyediakan berbagai pilihan gitar berkualitas, mulai
                    dari gitar akustik hingga elektrik. Kami menghadirkan produk dengan desain modern, material pilihan,
                    dan suara yang jernih untuk menunjang pengalaman bermusik Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-start">
                    <a href="{{ url('/katalog') }}"
                        class="group px-8 py-4 bg-white text-dark-900 font-bold rounded-full transition-all duration-300 hover:bg-gold-500 hover:text-white shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(212,175,55,0.6)] flex items-center justify-center gap-2">
                        View Collection
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section CSS -->
    <style>
        /* ===== Catalog Section ===== */
        .catalog-section {
            padding: 80px 0;
            background-color: #ffffff;
        }

        .catalog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Header */
        .catalog-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 50px;
        }

        .catalog-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
            line-height: 1.2;
        }

        .catalog-title-underline {
            width: 90px;
            height: 5px;
            background-color: #D4AF37;
            border-radius: 3px;
        }

        .catalog-view-all {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #D4AF37;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .catalog-view-all:hover {
            color: #1a1a1a;
        }

        .catalog-view-all svg {
            width: 16px;
            height: 16px;
        }

        /* Product Grid */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        /* Product Card */
        .catalog-card {
            position: relative;
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.4s ease, transform 0.4s ease;
            overflow: hidden;
        }

        .catalog-card:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            transform: translateY(-4px);
        }

        /* Badge */
        .catalog-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 5px 14px;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            z-index: 2;
        }

        .catalog-badge--gray {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .catalog-badge--gold {
            background-color: #D4AF37;
            color: #ffffff;
        }

        /* Image Container — CRITICAL FIX */
        .catalog-card__image-wrap {
            width: 100%;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .catalog-card__image-wrap a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .catalog-card__image-wrap img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .catalog-card:hover .catalog-card__image-wrap img {
            transform: scale(1.05);
        }

        /* Product Info */
        .catalog-card__info {
            text-align: center;
            width: 100%;
            background: #ffffff;
            position: relative;
            z-index: 2;
            padding-top: 4px;
        }

        .catalog-card__name {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
            transition: color 0.3s ease;
        }

        .catalog-card__name a {
            color: inherit;
            text-decoration: none;
        }

        .catalog-card:hover .catalog-card__name {
            color: #D4AF37;
        }

        /* Price Row */
        .catalog-card__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            border-top: 1px solid #f0f0f0;
            padding-top: 16px;
            margin-top: 10px;
        }

        .catalog-card__price {
            font-family: 'Inter', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .catalog-card__add-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background-color: #1a1a1a;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .catalog-card__add-btn:hover {
            background-color: #D4AF37;
        }

        .catalog-card__add-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .catalog-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .catalog-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 640px) {
            .catalog-section {
                padding: 50px 0;
            }

            .catalog-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 30px;
            }

            .catalog-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .catalog-title {
                font-size: 1.8rem;
            }

            .catalog-card__image-wrap {
                height: 200px;
            }
        }
    </style>

    <!-- Catalog Section -->
    <section id="catalog" class="catalog-section">
        <div class="catalog-container">
            <!-- Header -->
            <div class="catalog-header fade-in-up">
                <div>
                    <h2 class="catalog-title">Catalog Produk</h2>
                    <div class="catalog-title-underline"></div>
                </div>
                <a href="{{ url('/katalog') }}" class="catalog-view-all">
                    View All
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
            </div>

            <!-- Product Grid -->
            <div class="catalog-grid">

                <!-- Product Card 1 -->
                <div class="catalog-card fade-in-up">
                    <span class="catalog-badge catalog-badge--gray">STOCK READY</span>
                    <div class="catalog-card__image-wrap">
                        <a href="{{ url('/produk/detail') }}">
                            <img src="{{ asset('Foto/2.png') }}" alt="Classic Acoustic Guitar">
                        </a>
                    </div>
                    <div class="catalog-card__info">
                        <h3 class="catalog-card__name"><a href="{{ url('/produk/detail') }}">Classic Acoustic</a></h3>
                        <div class="catalog-card__footer">
                            <span class="catalog-card__price">Rp 2.500.000</span>
                            <button class="catalog-card__add-btn" aria-label="Tambah ke keranjang">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="catalog-card fade-in-up">
                    <span class="catalog-badge catalog-badge--gold">BEST SELLER</span>
                    <div class="catalog-card__image-wrap">
                        <a href="{{ url('/produk/detail') }}">
                            <img src="{{ asset('Foto/3.png') }}" alt="Premium Classic Guitar">
                        </a>
                    </div>
                    <div class="catalog-card__info">
                        <h3 class="catalog-card__name"><a href="{{ url('/produk/detail') }}">Premium Classic</a></h3>
                        <div class="catalog-card__footer">
                            <span class="catalog-card__price">Rp 4.200.000</span>
                            <button class="catalog-card__add-btn" aria-label="Tambah ke keranjang">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="catalog-card fade-in-up">
                    <span class="catalog-badge catalog-badge--gray">NEW</span>
                    <div class="catalog-card__image-wrap">
                        <a href="{{ url('/produk/detail') }}">
                            <img src="{{ asset('Foto/4.png') }}" alt="Electric Jazz Guitar">
                        </a>
                    </div>
                    <div class="catalog-card__info">
                        <h3 class="catalog-card__name"><a href="{{ url('/produk/detail') }}">Electric Jazz</a></h3>
                        <div class="catalog-card__footer">
                            <span class="catalog-card__price">Rp 3.800.000</span>
                            <button class="catalog-card__add-btn" aria-label="Tambah ke keranjang">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>

    <!-- Branding Section (Mid) -->
    <section class="h-[60vh] md:h-[80vh] relative flex items-center justify-center bg-fixed bg-center bg-cover"
        style="background-image: url('{{ asset('Foto/6.png') }}');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 text-center fade-in-up">
            <h2 class="text-6xl md:text-9xl font-serif font-bold text-white tracking-widest uppercase opacity-90">KING
                GITAR</h2>
            <p class="text-white/80 text-xl tracking-[0.5em] mt-4 uppercase">Est. 2026</p>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-[#FFF4E6] relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-dark-900 mb-4">About King Gitar</h2>
                <div class="w-full h-px bg-dark-900 mx-auto max-w-4xl"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Left Column -->
                <div class="fade-in-up flex flex-col gap-8">
                    <div>
                        <p class="text-lg text-dark-900 leading-relaxed font-serif mb-6">
                            King Gitar hadir sebagai ruang bagi para pecinta musik untuk menemukan gitar dengan kualitas
                            terbaik dan karakter suara yang otentik. Setiap instrumen dipilih dengan standar tinggi,
                            mengutamakan detail, kenyamanan, dan keindahan desain.
                        </p>
                        <p class="text-lg text-dark-900 leading-relaxed font-serif">
                            Kami percaya bahwa gitar bukan sekadar alat musik, tetapi bagian dari perjalanan musikal
                            setiap pemain. Oleh karena itu, King Gitar menghadirkan koleksi gitar yang memadukan
                            craftsmanship klasik, material berkualitas, dan sentuhan modern.
                        </p>
                    </div>
                    <div>
                        <img src="{{ asset('Foto/7.png') }}" alt="Acoustic Detail"
                            class="w-full h-auto object-cover rounded shadow-lg">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="fade-in-up flex flex-col gap-8">
                    <div>
                        <p class="text-lg text-dark-900 leading-relaxed font-serif">
                            Dengan tampilan elegan dan proses kurasi yang cermat, King Gitar berkomitmen menjadi
                            destinasi terpercaya bagi musisi pemula hingga profesional untuk menemukan instrumen yang
                            tepat dan bernilai jangka panjang.
                        </p>
                    </div>
                    <div>
                        <img src="{{ asset('Foto/6.png') }}" alt="Fretboard Detail"
                            class="w-full h-auto object-cover rounded shadow-lg">
                    </div>
                    <div>
                        <p class="text-lg text-dark-900 leading-relaxed font-serif mb-6">
                            Kami menghadirkan pengalaman berbelanja yang sederhana, tenang, dan terkurasi. Mulai dari
                            pemilihan produk hingga penyajian katalog, semuanya dirancang agar pelanggan dapat fokus
                            menemukan gitar yang benar-benar sesuai dengan karakter dan kebutuhan musikal mereka.
                        </p>
                        <p class="text-lg text-dark-900 leading-relaxed font-serif">
                            Dengan komitmen pada kualitas dan pelayanan, King Gitar terus berupaya menjaga kepercayaan
                            sebagai rumah bagi gitar-gitar pilihan yang siap menemani setiap perjalanan bermusik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-24 bg-cover bg-center relative" style="background-image: url('{{ asset('Foto/7.png') }}');">
        <div class="absolute inset-0 bg-dark-900/60 backdrop-blur-sm"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4">What Our Customers Say</h2>
                <div class="w-16 h-1 bg-gold-500 mx-auto"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial Card 1 -->
                <div
                    class="glass-card p-10 rounded-2xl text-center fade-in-up hover:transform hover:-translate-y-2 transition-transform duration-300">
                    <div
                        class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-6 overflow-hidden border-2 border-gold-500 p-0.5">
                        <div class="w-full h-full bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mx-auto mb-3"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto mb-6"></div>
                    <div class="h-20 bg-gray-100 rounded mb-4"></div>
                </div>
                <!-- ... other cards ... -->
                <div class="glass-card p-10 rounded-2xl text-center fade-in-up hover:transform hover:-translate-y-2 transition-transform duration-300"
                    style="transition-delay: 100ms;">
                    <div
                        class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-6 overflow-hidden border-2 border-gold-500 p-0.5">
                        <div class="w-full h-full bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mx-auto mb-3"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto mb-6"></div>
                    <div class="h-20 bg-gray-100 rounded mb-4"></div>
                </div>
                <div class="glass-card p-10 rounded-2xl text-center fade-in-up hover:transform hover:-translate-y-2 transition-transform duration-300"
                    style="transition-delay: 200ms;">
                    <div
                        class="w-16 h-16 bg-gray-200 rounded-full mx-auto mb-6 overflow-hidden border-2 border-gold-500 p-0.5">
                        <div class="w-full h-full bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="h-4 bg-gray-200 rounded w-3/4 mx-auto mb-3"></div>
                    <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto mb-6"></div>
                    <div class="h-20 bg-gray-100 rounded mb-4"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="mt-16 pt-12 border-t border-gray-200 mb-16 ">
        <div class="bg-white p-8 rounded-2xl shadow-lg max-w-3xl mx-auto">
            <h3 class="text-2xl font-serif font-bold text-center mb-6">Masukan & Saran</h3>
            <form class="space-y-5">
                <input type="text" placeholder="Judul"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold-500 transition-all">
                <textarea rows="4" placeholder="Tulis masukan Anda disini..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gold-500 transition-all"></textarea>
                <button type="submit"
                    class="w-full py-4 bg-dark-900 text-white font-bold rounded-lg hover:bg-gold-500 transition-colors uppercase tracking-widest">Kirim
                    Masukan</button>
            </form>
        </div>
    </div>

    <!-- Suggestions & Form Section -->
    <section id="contact" class="py-24 bg-[#FFF4E6]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-3xl font-serif font-bold text-dark-900 mb-6 uppercase tracking-wider">Support</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-sm">
                <div class="space-y-4">
                    <h3 class="font-bold text-lg mb-4">Support</h3>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Pusat Bantuan</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Kebijakan Pengembalian</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Syarat & Ketentuan</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Panduan Pengguna</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Layanan Darurat 24/7</p>
                </div>
                <div class="space-y-4">
                    <h3 class="font-bold text-lg mb-4">Hosting</h3>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Go-Host for Property Owners</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Go-Host Experience Partner</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Gabung Jadi Supir & Guide</p>
                </div>
                <div class="space-y-4">
                    <h3 class="font-bold text-lg mb-4">GoFoot</h3>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">GoFoot 2026 Experience Update</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Pusat Berita GoFoot</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Karier di GoFoot</p>
                </div>
                <div class="space-y-4">
                    <h3 class="font-bold text-lg mb-4">Pusat Bantuan</h3>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Tanya Jawab Umum (FAQ)</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Panduan Penggunaan Aplikasi</p>
                    <p class="text-gray-600 hover:text-gold-500 cursor-pointer">Cara Booking Layanan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#FFF4E6] py-6 border-t border-gray-200">
        <div
            class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <div>&copy; 2026 King Gitar. Developed with precision.</div>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-gold-500">Privacy</a>
                <a href="#" class="hover:text-gold-500">Terms</a>
                <a href="#" class="hover:text-gold-500">Sitemap</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Navbar Scroll Effect
        const navbar = document.getElementById('navbar');
        const brandName = document.getElementById('brand-name');
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');

        function updateNavbar() {
            if (window.scrollY > 50) {
                navbar.classList.remove('nav-transparent');
                navbar.classList.add('nav-scrolled');

                // Text Dark
                brandName.parentElement.classList.remove('text-white');
                brandName.parentElement.classList.add('text-dark-900');

                navLinks.forEach(link => {
                    link.classList.remove('text-white/90');
                    link.classList.add('text-gray-700');
                });

                mobileMenuBtn.classList.remove('text-white');
                mobileMenuBtn.classList.add('text-dark-900');
            } else {
                navbar.classList.add('nav-transparent');
                navbar.classList.remove('nav-scrolled');

                // Text White
                brandName.parentElement.classList.remove('text-dark-900');
                brandName.parentElement.classList.add('text-white');

                navLinks.forEach(link => {
                    link.classList.remove('text-gray-700');
                    link.classList.add('text-white/90');
                });

                mobileMenuBtn.classList.remove('text-dark-900');
                mobileMenuBtn.classList.add('text-white');
            }
        }

        window.addEventListener('scroll', updateNavbar);

        // Mobile Menu Logic
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
        const mobileMenuCloseBtn = document.getElementById('mobile-menu-close');

        function openMenu() {
            mobileMenuOverlay.classList.remove('hidden');
            // Small delay to allow display:block to apply before opacity transition
            setTimeout(() => {
                mobileMenuOverlay.classList.remove('opacity-0');
                mobileMenuDrawer.classList.remove('translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeMenu() {
            mobileMenuOverlay.classList.add('opacity-0');
            mobileMenuDrawer.classList.add('translate-x-full');

            // Wait for transition to finish before hiding
            setTimeout(() => {
                mobileMenuOverlay.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            }, 300);
        }

        mobileMenuBtn.addEventListener('click', openMenu);

        if (mobileMenuCloseBtn) {
            mobileMenuCloseBtn.addEventListener('click', closeMenu);
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMenu);
        }

        // Close on link click
        document.querySelectorAll('#mobile-menu-drawer a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Intersection Observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in-up').forEach((el) => observer.observe(el));

        // Scroll Spy Logic
        const sections = document.querySelectorAll('section[id]');
        const desktopNavLinks = document.querySelectorAll('.hidden.md\\:flex .nav-link');

        function scrollSpy() {
            let current = '';

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                if (window.scrollY >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            desktopNavLinks.forEach(link => {
                link.classList.remove('active');

                // Match Logic
                const href = link.getAttribute('href');

                // Matching standard anchors (#home, #about, #contact)
                if (href.includes('#' + current)) {
                    link.classList.add('active');
                }

                // Special case for Catalog (External link but exists as section)
                if (current === 'catalog' && href.includes('katalog')) {
                    link.classList.add('active');
                }

                // Special case for Home when at very top
                if (window.scrollY < 100 && href.includes('#home')) {
                    link.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', scrollSpy);
        // Run on load
        scrollSpy();
    </script>
</body>

</html>