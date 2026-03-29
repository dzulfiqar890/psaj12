<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Docs – Masukkan Token</title>
    @if(app()->environment('local'))
        <script src="https://cdn.tailwindcss.com"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #0f0f0f; font-family: 'Segoe UI', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
    <!-- Pop-up card -->
    <div class="bg-[#1a1a1a] border border-[#2a2a2a] rounded-2xl shadow-2xl w-full max-w-md p-8">
        <!-- Icon -->
        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-[#D4AF37]/10 border border-[#D4AF37]/20 mx-auto mb-6">
            <i class="fas fa-lock text-[#D4AF37] text-2xl"></i>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-white text-center mb-1 tracking-wide">API Documentation</h1>
        <p class="text-gray-500 text-sm text-center mb-8">Akses terbatas. Masukkan token untuk melanjutkan.</p>

        <!-- Error alert -->
        @if ($error)
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-sm px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                <i class="fas fa-circle-exclamation"></i>
                <span>{{ $error }}</span>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('scramble.verify') }}">
            @csrf
            <div class="mb-6">
                <label for="token" class="block text-xs text-gray-400 uppercase tracking-wider mb-2 font-semibold">Access Token</label>
                <div class="relative">
                    <input
                        id="token"
                        name="token"
                        type="password"
                        placeholder="Masukkan token akses…"
                        autocomplete="off"
                        required
                        class="w-full bg-[#111] border border-[#333] text-white text-sm rounded-lg px-4 py-3 pr-10 focus:outline-none focus:border-[#D4AF37] focus:ring-1 focus:ring-[#D4AF37] transition-colors"
                    >
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-500 hover:text-[#D4AF37] focus:outline-none transition-colors">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-[#D4AF37] hover:bg-[#c5a028] text-black font-bold py-3 rounded-lg transition-colors duration-200 text-sm tracking-wide"
            >
                <i class="fas fa-arrow-right-to-bracket mr-2"></i>Masuk ke API Docs
            </button>
        </form>

        <p class="text-center text-gray-600 text-xs mt-6">King Gitar &copy; {{ date('Y') }} &bull; Developer Access Only</p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('token');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
