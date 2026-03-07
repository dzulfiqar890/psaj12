<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Gitar - Premium Guitar Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
                <span id="brand-name">KING GITAR</span>
            </a>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="#home"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Home</a>
                <a href="{{ url('/katalog') }}"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Catalog</a>
                <a href="#about"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">About</a>
                <a href="#contact"
                    class="nav-link text-white/90 hover:text-gold-500 transition-colors duration-300 font-medium text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-gold-500 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left">Contacts</a>

                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link text-white/90 hover:text-gold-500 transition-all duration-300 font-medium text-sm uppercase tracking-wider border border-current rounded-full px-6 py-2 hover:bg-gold-500/10">
                            Dashboard
                        </a>
                    @else
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="nav-link text-white/90 hover:text-gold-500 transition-all duration-300 font-medium text-sm uppercase tracking-wider border border-current rounded-full px-6 py-2 hover:bg-gold-500/10">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="nav-link text-white/90 hover:text-gold-500 transition-all duration-300 font-medium text-sm uppercase tracking-wider border border-current rounded-full px-6 py-2 hover:bg-gold-500/10">
                        Masuk
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
                        class="block px-4 py-3 text-gray-800 hover:bg-gold-500/10 hover:text-gold-500 rounded-lg transition-colors font-medium">Contacts</a>
                </nav>
            </div>
            <div class="p-4 border-t border-gray-100">
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                            class="block w-full text-center px-4 py-3 bg-dark-900 hover:bg-gold-500 text-white font-medium rounded-lg transition-colors">
                            Dashboard
                        </a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg transition-colors">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full text-center px-4 py-3 bg-dark-900 hover:bg-gold-500 text-white font-medium rounded-lg transition-colors">
                        Masuk
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
                <p class="text-lg md:text-xl text-gray-200 mb-10  leading-relaxed">
                    King Gitar adalah platform katalog produk yang menyediakan berbagai pilihan gitar berkualitas, mulai
                    dari gitar akustik hingga elektrik. Kami menghadirkan produk dengan desain modern, material pilihan,
                    dan suara yang jernih untuk menunjang pengalaman bermusik Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-start">
                    <a href="{{ url('/katalog') }}"
                        class="group px-8 py-4 bg-white text-dark-900 font-bold rounded-full transition-all duration-300 hover:bg-gold-500 hover:text-white shadow-[0_0_20px_rgba(255,255,255,0.3)] hover:shadow-[0_0_30px_rgba(212,175,55,0.6)] flex items-center justify-center gap-2">
                        Lihat Lebih Banyak
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
            font-family: 'Poppins', sans-serif;
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
            font-family: 'Poppins', sans-serif;
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
            font-family: 'Poppins', sans-serif;
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
            <div class="catalog-grid" id="latest-products-grid">
                <!-- Skeleton Loading -->
                <div class="catalog-card fade-in-up" style="height: 380px; border-radius: 20px;">
                    <div class="skeleton" style="width: 100%; height: 250px; border-radius: 12px; margin-bottom: 24px;"></div>
                    <div class="skeleton" style="width: 70%; height: 20px; border-radius: 4px; margin: 0 auto 16px;"></div>
                    <div class="skeleton" style="width: 40%; height: 20px; border-radius: 4px; margin: 0 auto;"></div>
                </div>
                <div class="catalog-card fade-in-up" style="height: 380px; border-radius: 20px;">
                    <div class="skeleton" style="width: 100%; height: 250px; border-radius: 12px; margin-bottom: 24px;"></div>
                    <div class="skeleton" style="width: 70%; height: 20px; border-radius: 4px; margin: 0 auto 16px;"></div>
                    <div class="skeleton" style="width: 40%; height: 20px; border-radius: 4px; margin: 0 auto;"></div>
                </div>
                <div class="catalog-card fade-in-up" style="height: 380px; border-radius: 20px;">
                    <div class="skeleton" style="width: 100%; height: 250px; border-radius: 12px; margin-bottom: 24px;"></div>
                    <div class="skeleton" style="width: 70%; height: 20px; border-radius: 4px; margin: 0 auto 16px;"></div>
                    <div class="skeleton" style="width: 40%; height: 20px; border-radius: 4px; margin: 0 auto;"></div>
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
            {{-- <p class="text-white/80 text-xl tracking-[0.5em] mt-4 uppercase">Est. 2026</p> --}}
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

    <!-- Testimonials Section - 3-card Peek Slider -->
    <section id="testimonials" class="py-24 bg-cover bg-center relative overflow-hidden" style="background-image: url('{{ asset('Foto/7.png') }}');">
        <div class="absolute inset-0 bg-dark-900/65 backdrop-blur-sm"></div>

        <style>
            .testi-outer {
                position: relative;
                overflow: hidden;
                /* Fade edges to hint at adjacent cards */
                mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
                -webkit-mask-image: linear-gradient(to right, transparent 0%, black 10%, black 90%, transparent 100%);
            }
            .testi-track {
                display: flex;
                transition: transform 0.55s cubic-bezier(.4,0,.2,1);
                /* Each slide = 80% wide, leaving 10% peek on each side */
            }
            .testi-slide {
                flex: 0 0 80%;
                padding: 0 14px;
                box-sizing: border-box;
            }
            @media (max-width: 768px) { .testi-slide { flex: 0 0 100%; } }
            .testi-card {
                background: rgba(255,255,255,0.09);
                border: 1px solid rgba(255,255,255,0.14);
                backdrop-filter: blur(12px);
                border-radius: 20px;
                padding: 28px 30px;
                text-align: center;
                transition: box-shadow .3s;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 15px;
                min-height: 160px;
                height: 320px;
            }
            .testi-avatar {
                width: 60px;
                height: 60px;
                border: 2px solid #D4AF37;
                border-radius: 50%;
                background: transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.4rem;
                font-weight: 600;
                margin-bottom: 5px;
                text-transform: uppercase;
            }
            .testi-card.active-card { box-shadow: 0 4px 20px rgba(0,0,0,0.15); border-color: rgba(212,175,55,0.3); }
            .testi-dot {
                width: 9px; height: 9px;
                border-radius: 50%;
                background: rgba(255,255,255,0.3);
                border: none; cursor: pointer;
                transition: background .3s, transform .3s;
            }
            .testi-dot.active { background: #D4AF37; transform: scale(1.2); }
            .testi-arrow {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
                width: 44px; height: 44px;
                border-radius: 50%;
                background: rgba(255,255,255,0.12);
                border: 1px solid rgba(255,255,255,0.2);
                color: white;
                cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                transition: background .2s;
            }
            .testi-arrow:hover { background: #D4AF37; border-color: #D4AF37; }
            .testi-arrow.left  { left: 6px; }
            .testi-arrow.right { right: 6px; }
        </style>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-14 fade-in-up">
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4">What Our Customers Say</h2>
                <div class="w-16 h-1 bg-yellow-400 mx-auto"></div>
            </div>

            <!-- Slider wrapper with arrows absolutely positioned on sides -->
            <div style="position:relative; padding:0 56px;">

                <!-- Left Arrow -->
                <button onclick="goTesti((testiIdx-1+testiData.length)%testiData.length)" class="testi-arrow left">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <div class="testi-outer">
                    <div id="testiTrack" class="testi-track" style="padding: 8px 0 20px;">
                        <!-- Loading placeholder -->
                        <div class="testi-slide">
                            <div class="testi-card">
                                <div class="h-5 bg-white/20 rounded w-1/3 mb-2 animate-pulse"></div>
                                <div class="h-16 bg-white/10 rounded animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Arrow -->
                <button onclick="nextTesti()" class="testi-arrow right">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                </button>

            </div>

            <!-- Dots -->
            <div id="testiDots" class="flex justify-center gap-2 mt-6"></div>
        </div>
    </section>

    <!-- <div class="mt-16 pt-12 border-t border-gray-200 mb-16 ">
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
    </div> -->

    @include('partials.footer')

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
                if (href && href.includes('#' + current)) {
                    link.classList.add('active');
                }

                // Special case for Catalog (External link but exists as section)
                if (current === 'catalog' && href && href.includes('katalog')) {
                    link.classList.add('active');
                }

                // Special case for Home when at very top
                if (window.scrollY < 100 && href && href.includes('#home')) {
                    link.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', scrollSpy);
        // Run on load
        scrollSpy();
        
        // Fetch 3 Latest Products
        async function fetchLatestProducts() {
            try {
                const response = await fetch('/api/v1/products?per_page=3&sort=updated_at&order=desc');
                const result = await response.json();
                
                let productsData = [];
                if (result.data) {
                    if (Array.isArray(result.data.data)) productsData = result.data.data;
                    else productsData = result.data;
                } else if (result.products) {
                    productsData = result.products.data || result.products;
                } else if (Array.isArray(result)) {
                    productsData = result;
                }
                
                // Get exactly 3 items
                productsData = productsData.slice(0, 3);
                
                const grid = document.getElementById('latest-products-grid');
                if (productsData.length > 0) {
                    grid.innerHTML = productsData.map(product => {
                        let priceRaw = product.price || product.harga || 0;
                        let priceFmt = (typeof priceRaw === 'string' && priceRaw.toLowerCase().includes('rp')) ? priceRaw : new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(priceRaw);
                        
                        let imgSrc = product.image_url || '/Foto/default-guitar.png';
                        
                        const catName = product.category?.name || product.kategori || 'NEW';
                        const detailUrl = '/produk/' + (product.slug || product.id);
                        const nameDsp  = product.name || product.nama || 'Produk';
                        const priceFmt2 = product.formatted_price || new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(product.price || 0);
                        
                        return `
                            <div class="catalog-card fade-in-up visible">
                                <span class="catalog-badge catalog-badge--gold">${catName}</span>
                                <div class="catalog-card__image-wrap bg-gray-50/50 rounded-xl">
                                    <a href="${detailUrl}">
                                        <img src="${imgSrc}" alt="${nameDsp}" onerror="this.src='/Foto/default-guitar.png'">
                                    </a>
                                </div>
                                <div class="catalog-card__info">
                                    <h3 class="catalog-card__name"><a href="${detailUrl}">${nameDsp}</a></h3>
                                    <div class="catalog-card__footer">
                                        <span class="catalog-card__price">${priceFmt2}</span>
                                        <a href="${detailUrl}" class="catalog-card__add-btn" aria-label="Lihat Detail" style="text-decoration:none">
                                            <i class="ph-bold ph-arrow-right text-white"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                }
            } catch (error) {
                console.error('API Error:', error);
                document.getElementById('latest-products-grid').innerHTML = '<p class="text-center w-full col-span-3 text-gray-500 py-10">Gagal memuat produk dari server.</p>';
            }
        }
        fetchLatestProducts();

        // ===== Testimonials Slider =====
        let testiData = [];
        let testiIdx  = 0;
        let testiTimer = null;

        const testiTrack = document.getElementById('testiTrack');
        const testiDots  = document.getElementById('testiDots');

        function renderTesti() {
            if (!testiData.length || !testiTrack) return;
            testiTrack.innerHTML = testiData.map((t, i) => {
                const initial = (t.name || 'A').charAt(0).toUpperCase();
                return `
                <div class="testi-slide">
                    <div class="testi-card" id="tcard-${i}">
                        <div class="testi-avatar">${initial}</div>
                        <h4 style="color:white;font-weight:700;font-size:1rem;margin:0;">${t.name || 'Anonim'}</h4>
                        <p style="color:rgba(255,255,255,0.85);font-size:.9rem;line-height:1.7;font-style:italic;margin:0;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;">&ldquo;${t.testimony || ''}&rdquo;</p>
                    </div>
                </div>`;
            }).join('');

            // Dots
            if (testiDots) {
                testiDots.innerHTML = testiData.map((_, i) =>
                    `<button onclick="goTesti(${i})" class="testi-dot ${i===0?'active':''}" data-idx="${i}"></button>`
                ).join('');
            }

            goTesti(0);
        }

        function goTesti(idx) {
            testiIdx = idx;
            if (testiTrack) {
                // Each slide is 80%. To center it with 10% peeking on both sides:
                // offset = idx * 80 - 10  (in percent)
                const offset = Math.max(0, idx * 80 - 10);
                testiTrack.style.transform = `translateX(-${offset}%)`;
                // Highlight active card
                testiTrack.querySelectorAll('.testi-card').forEach((c, i) =>
                    c.classList.toggle('active-card', i === idx));
            }
            if (testiDots) {
                testiDots.querySelectorAll('.testi-dot').forEach((d, i) =>
                    d.classList.toggle('active', i === idx));
            }
        }

        function nextTesti() {
            goTesti((testiIdx + 1) % testiData.length);
        }

        function startTestiAuto() {
            if (testiTimer) clearInterval(testiTimer);
            testiTimer = setInterval(nextTesti, 2000);
        }

        async function fetchTestimonials() {
            try {
                const res  = await fetch('/api/v1/testimonials');
                const data = await res.json();
                testiData  = (data.success ? data.data : []) || [];
                if (!testiData.length) {
                    // Fallback placeholders
                    testiData = [
                        { name: 'Arya S.', role: 'Gitaris Akustik', message: 'King Gitar punya koleksi terbaik!', rating: 5 },
                        { name: 'Rina D.', role: 'Guru Musik', message: 'Kualitas premium, pelayanan ramah.', rating: 5 },
                        { name: 'Dika R.', role: 'Musisi Studio', message: 'Mudah order, gitar langsung siap pakai.', rating: 5 },
                    ];
                }
                renderTesti();
                startTestiAuto();
            } catch(e) {
                console.error('Testi error:', e);
            }
        }
        fetchTestimonials();

        // Chat Widget logic removed — replaced by partials.chatbot
    </script>

    @include('partials.chatbot')
</body>

</html>