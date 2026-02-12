<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - King Gitar Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: { gold: '#D4AF37' }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <p class="absolute top-4 left-4 text-gray-800"><a href="/" class="text-gold hover:underline font-semibold">Kembali</a></p>
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md border border-slate-100">
        <div class="text-center mb-8">
            <img src="/Foto/Logo.png" alt="King Gitar" class="h-16 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-slate-800">Selamat Datang Kembali</h1>
            <p class="text-slate-500">Masuk untuk mengelola dashboard</p>
        </div>

        <form action="/login" method="POST" class="space-y-6">
            @csrf

            <!-- Menampilkan error login jika ada -->
            @error('email')
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm text-center">
                    {{ $message }}
                </div>
            @enderror

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition"
                    placeholder="nama@email.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition"
                    placeholder="********">
            </div>

            <button type="submit"
                class="w-full bg-gold hover:bg-yellow-600 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-gold/20">
                Masuk Dashboard
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-500">
            Belum punya akun? <a href="/register" class="text-gold hover:underline font-semibold">Daftar sekarang</a>
        </div>

        <div class="mt-8 text-center text-sm text-slate-400 border-t pt-4">
            &copy; 2026 King Gitar. All rights reserved.
        </div>
    </div>
</body>

</html>