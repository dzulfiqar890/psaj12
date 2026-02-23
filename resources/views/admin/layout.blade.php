<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - KING GITAR Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        gold: { DEFAULT: '#D4AF37', light: '#FFE5B4' },
                        cream: { DEFAULT: '#FFF4E6' },
                    }
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidebar-item {
            transition: all 0.3s ease;
        }

        .sidebar-item:hover,
        .sidebar-item.active {
            background-color: #FFF4E6;
        }

        .sidebar-item:hover svg,
        .sidebar-item.active svg {
            color: #D4AF37;
        }

        .sidebar-item:hover span,
        .sidebar-item.active span {
            color: #D4AF37;
            font-weight: 500;
        }

        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.05), 0 8px 10px -6px rgb(0 0 0 / 0.05);
        }
    </style>
</head>

<body class="bg-[#F0F4F8] text-slate-800 font-sans antialiased">

    <!-- Mobile Header -->
    <div class="lg:hidden flex items-center justify-between p-4 bg-white shadow-sm z-50 sticky top-0">
        <div class="flex items-center gap-2">
            <img src="/Foto/Logo.png" alt="Logo" class="h-8 w-auto">
            <span class="font-bold text-gold text-lg">KING GITAR</span>
        </div>
        <button id="mobileMenuBtn" class="text-slate-600 hover:text-gold transition">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-60 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
            <!-- Logo -->
            <div class="h-20 flex items-center justify-center border-b border-slate-100 flex-shrink-0">
                <img src="/Foto/Logo.png" alt="King Gitar" class="h-14 w-auto object-contain">
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                @php
                    $menuItems = [
                        ['route' => 'admin.dashboard', 'icon' => 'home', 'label' => 'Home'],
                        ['route' => 'admin.categories.index', 'icon' => 'layers', 'label' => 'Categories'],
                        ['route' => 'admin.testimonials.index', 'icon' => 'message-square', 'label' => 'Testimonials'],
                        ['route' => 'admin.products.index', 'icon' => 'guitar', 'label' => 'Products'],
                        ['route' => 'admin.contacts.index', 'icon' => 'mail', 'label' => 'Contacts'],
                        ['route' => 'admin.banners.index', 'icon' => 'image', 'label' => 'Banners'],
                        ['route' => 'admin.users.index', 'icon' => 'users', 'label' => 'Users'],
                    ];
                @endphp

                @foreach ($menuItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-xl {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 text-slate-400"></i>
                        <span class="text-sm text-slate-600">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Logout -->
            <div class="p-3 border-t border-slate-100 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-xl hover:!bg-red-50 group">
                        <i data-lucide="log-out" class="w-5 h-5 text-slate-400 group-hover:!text-red-500"></i>
                        <span class="text-sm text-slate-600 group-hover:!text-red-500">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

        <!-- Main -->
        <main class="flex-1 lg:ml-60 min-h-screen w-full overflow-x-hidden relative">
            <!-- Top Bar -->
            <div
                class="sticky top-0 z-20 bg-white/80 backdrop-blur-md border-b border-slate-100 px-6 py-4 hidden lg:flex items-center justify-between">
                <!-- <div class="relative w-80">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Search orders..."
                        class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold text-sm transition">
                </div> -->
                <div class="w-full flex items-center justify-between">

                    <!-- Bagian Kiri -->
                    <div>
                        <h1 class="text-sm font-semibold text-slate-700">
                            Halo, <span id="typewriter-global" class="text-gold"></span> !!
                        </h1>
                    </div>

                    <!-- Bagian Kanan (Profile) -->
                    <div>
                        @if(Auth::user() && Auth::user()->image)
                            <img src="{{ Auth::user()->image_url }}"
                                alt="Profile"
                                class="w-9 h-9 rounded-full object-cover border border-gold/20">
                        @else
                            <div class="w-9 h-9 rounded-full bg-cream flex items-center justify-center text-gold font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->username ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="p-6 lg:p-8 max-w-7xl mx-auto space-y-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Admin API Helper -->
    <script>
        // Global config
        const API_BASE = '/api/v1/admin';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const AUTH_USERNAME = "{{ Auth::user()->username ?? 'Admin' }}";

        // API Helper
        function getCookie(name) {
            const v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
            return v ? decodeURIComponent(v.pop()) : null;
        }

        const Api = {
            async request(endpoint, options = {}) {
                const url = endpoint.startsWith('http') ? endpoint : `${API_BASE}${endpoint}`;
                const xsrf = getCookie('XSRF-TOKEN');
                const config = {
                    ...options,
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(xsrf ? { 'X-XSRF-TOKEN': xsrf } : {}),
                        ...options.headers,
                    },
                };
                // Add JSON content-type for non-FormData bodies
                if (options.body && !(options.body instanceof FormData)) {
                    config.headers['Content-Type'] = 'application/json';
                }
                try {
                    const response = await fetch(url, config);
                    if (response.status === 401) { 
                        window.location.href = '/login'; 
                        throw { status: 401, message: 'Unauthorized' }; 
                    }
                    const data = await response.json();
                    if (!response.ok) throw { response: data, status: response.status };
                    return data;
                } catch (error) {
                    console.error('API Error:', error);
                    throw error;
                }
            },
            get: (e) => Api.request(e),
            post: (e, b) => Api.request(e, { method: 'POST', body: b instanceof FormData ? b : JSON.stringify(b) }),
            put: (e, b) => Api.request(e, { method: 'PUT', body: b instanceof FormData ? b : JSON.stringify(b) }),
            delete: (e) => Api.request(e, { method: 'DELETE' }),
        };


        // Format Rupiah
        function formatRupiah(n) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);
        }

        // Typewriter effect (global)
        function startTypewriter(elId, text) {
            const el = document.getElementById(elId);
            if (!el) return;
            let i = 0, deleting = false;
            function tick() {
                el.textContent = text.substring(0, i);
                if (!deleting) {
                    i++;
                    if (i > text.length) { deleting = true; setTimeout(tick, 2000); return; }
                } else {
                    i--;
                    if (i < 0) { deleting = false; setTimeout(tick, 500); return; }
                }
                setTimeout(tick, deleting ? 80 : 150);
            }
            tick();
        }

        // Confirm Delete
        function confirmDelete(title, callback) {
            Swal.fire({
                title: 'Hapus ' + title + '?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) callback();
            });
        }

        // Toast
        function showToast(msg, icon = 'success') {
            Swal.fire({ toast: true, position: 'top-end', icon, title: msg, showConfirmButton: false, timer: 2500, timerProgressBar: true });
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            startTypewriter('typewriter-global', AUTH_USERNAME);

            // Mobile sidebar
            const btn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
            btn?.addEventListener('click', toggleSidebar);
            overlay?.addEventListener('click', toggleSidebar);
        });
    </script>
    @stack('scripts')
</body>

</html>