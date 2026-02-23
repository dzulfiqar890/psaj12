<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - King Gitar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
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
</head>

<body class="bg-[#FAF9F6] h-screen flex font-sans text-gray-800">
    <!-- Left: Cover Image (Hidden on Mobile) -->
    <div class="hidden lg:block lg:w-1/2 relative bg-dark-900">
        <img src="{{ asset('Foto/8.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Guitar Cover">
        <div class="absolute inset-0 bg-gradient-to-t from-dark-900/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-dark-900/40 to-transparent"></div>
        <div class="absolute bottom-16 left-16 text-white pr-16">
            <h2 class="text-5xl font-serif font-bold mb-4 drop-shadow-lg">Temukan Harmoni Sejatimu</h2>
            <p class="text-gray-200 text-lg font-light tracking-wide drop-shadow">Akses dashboard admin dan kelola katalog gitar premium untuk pelanggan terbaik Anda.</p>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 lg:p-16 relative">
        <a href="/" class="absolute top-8 left-8 text-gray-500 hover:text-gold-500 font-medium flex items-center gap-2 transition duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="w-full max-w-md mt-10 lg:mt-0">
            <!-- Icon/Star aesthetic -->
            <div class="text-gold-500 mb-6 flex items-center gap-2">
                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2Z"/>
                </svg>
            </div>

            <h1 class="text-4xl md:text-5xl font-serif font-bold text-dark-900 mb-3 tracking-tight">Welcome back.</h1>
            <p class="text-gray-500 mb-10 font-light">Masuk untuk mengelola dashboard King Gitar</p>

            <form action="/login" method="POST" class="space-y-5">
                @csrf

                @error('email')
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 outline-none transition bg-white shadow-sm"
                        placeholder="admin@example.com">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-gold-500/20 focus:border-gold-500 outline-none transition bg-white shadow-sm"
                        placeholder="••••••••">
                </div>

                <!-- <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-gold-500 focus:ring-gold-500 transition">
                        <span class="text-sm text-gray-500 group-hover:text-dark-900 transition">Keep me logged in</span>
                    </label>
                    <a href="#" class="text-sm text-gray-500 hover:text-gold-500 transition">Forgot password?</a>
                </div> -->

                <button type="submit"
                    class="w-full bg-[#D4AF37] hover:bg-[#D4AF37] text-white font-medium py-3.5 rounded-xl transition shadow-[0_4px_14px_rgba(212,175,55,0.3)] hover:shadow-[0_6px_20px_rgba(212,175,55,0.5)] active:scale-[0.98] mt-4">
                    Login
                </button>
                
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <button type="button" class="flex items-center justify-center gap-2 py-3 border border-gray-200 hover:border-gray-300 rounded-xl bg-white hover:bg-gray-50 transition text-sm font-medium text-gray-700 shadow-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                        </svg>
                        Google
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 py-3 border border-gray-200 hover:border-gray-300 rounded-xl bg-white hover:bg-gray-50 transition text-sm font-medium text-gray-700 shadow-sm">
                        <svg class="w-4 h-4" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg"><path d="M10 0h11v11H10z" fill="#f25022"/><path d="M-1 0h11v11H-1z" fill="#7fba00"/><path d="M10 11h11v11H10z" fill="#00a4ef"/><path d="M-1 11h11v11H-1z" fill="#ffb900"/></svg>
                        Microsoft
                    </button>
                </div>
            </form>

            <!-- <div class="mt-10 md:mt-16 justify-center flex text-sm text-gray-500">
                <p>Belum punya akun? <a href="/register" class="text-dark-900 font-medium hover:text-gold-500 transition underline decoration-gray-300 hover:decoration-gold-500 underline-offset-4 ml-1">Daftar sekarang</a></p>
            </div> -->
        </div>
    </div>
</body>

</html>