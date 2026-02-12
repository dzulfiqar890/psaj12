<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Katalog Gitar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <p class="absolute top-4 left-4 text-gray-800"><a href="/" class="text-gold hover:underline font-semibold">Kembali</a></p>
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg border border-slate-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">Daftar Akun Baru</h1>
            <p class="text-slate-500">Bergabung dengan komunitas Katalog Gitar</p>
        </div>

        <form id="registerForm" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                <input type="text" name="username" required placeholder="johndoe"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                <div class="flex gap-2">
                    <input type="email" name="email" id="email" required placeholder="nama@email.com"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
                    <button type="button" id="btnSendCode" onclick="sendVerificationCode()"
                        class="whitespace-nowrap bg-slate-800 hover:bg-slate-700 text-white px-4 py-3 rounded-xl transition text-sm font-medium">
                        Kirim Kode
                    </button>
                </div>
                <p class="text-xs text-slate-400 mt-1">*Kode verifikasi akan dikirim ke email ini</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kode Verifikasi</label>
                <input type="text" name="code" required placeholder="Masukkan 6 digit kode"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition tracking-widest text-center text-lg">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="********"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="********"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon (Opsional)</label>
                <input type="text" name="no_telephone" placeholder="08123456789"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-gold/20 focus:border-gold outline-none transition">
            </div>

            <button type="submit" id="btnRegister"
                class="w-full bg-gold hover:bg-yellow-600 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-gold/20 mt-4">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-500">
            Sudah punya akun? <a href="/login" class="text-gold hover:underline font-semibold">Login disini</a>
        </div>
    </div>

    <script>
        const API_URL = '/api/v1';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function sendVerificationCode() {
            const email = document.getElementById('email').value;
            const btn = document.getElementById('btnSendCode');

            if (!email) {
                Swal.fire('Error', 'Silakan isi email terlebih dahulu', 'error');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="animate-pulse">Mengirim...</span>';

            try {
                const response = await fetch(`${API_URL}/register/send-verification`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire('Sukses', data.message, 'success');
                } else {
                    Swal.fire('Gagal', data.message || 'Terjadi kesalahan', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Gagal menghubungi server', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Kirim Kode';
            }
        }

        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btnRegister');
            const formData = new FormData(e.target);

            btn.disabled = true;
            btn.innerHTML = '<span class="animate-pulse">Memproses...</span>';

            try {
                const response = await fetch(`${API_URL}/register`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire({
                        title: 'Registrasi Berhasil!',
                        text: 'Anda akan dialihkan ke halaman login.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/login';
                    });
                } else {
                    let message = data.message;
                    if (data.errors) {
                        message = Object.values(data.errors).flat().join('\n');
                    }
                    Swal.fire('Registrasi Gagal', message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Gagal menghubungi server', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Daftar Sekarang';
            }
        });
    </script>
</body>

</html>