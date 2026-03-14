# 🚀 Railway Hosting Guide — King Gitar

## Yang Sudah Disiapkan di Project Ini

| File | Fungsi |
|------|--------|
| [nixpacks.toml](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/nixpacks.toml) | Konfigurasi build untuk Railway (PHP 8.3 + Composer) |
| [Procfile](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/Procfile) | Perintah start server untuk Railway |
| [.env.example](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/.env.example) | Template environment variables untuk produksi |

---

## Langkah-Langkah Hosting

### 1. Push ke GitHub

Pastikan semua kode sudah di-push ke repository GitHub (private OK):

```bash
git add .
git commit -m "chore: ready for Railway deployment"
git push origin main
```

> [!IMPORTANT]
> Pastikan file [.env](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/.env) ada di [.gitignore](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/.gitignore) (sudah ada). Jangan pernah push [.env](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/.env) ke GitHub!

---

### 2. Buat Akun Railway

1. Buka [railway.app](https://railway.app)
2. Klik **Login with GitHub** — pakai akun GitHub yang sama tempat repo kamu berada
3. Verifikasi akun lewat email

---

### 3. Buat Project Baru

1. Di dashboard Railway, klik **New Project**
2. Pilih **Deploy from GitHub repo**
3. Cari dan pilih repository `gitar-katalog` kamu
4. Railway otomatis mendeteksi file [nixpacks.toml](file:///d:/Sekolah/Kelas%20XII/MK-2/PSAJ/gitar-katalog/nixpacks.toml) dan mulai build

---

### 4. Tambah Database MySQL

Di dalam project Railway:
1. Klik tombol **+ New** (di dalam project yang sama)
2. Pilih **Database → Add MySQL**
3. Railway otomatis membuat database dan menyediakan environment variables:
   - `MYSQLHOST`, `MYSQLPORT`, `MYSQLDATABASE`, `MYSQLUSER`, `MYSQLPASSWORD`

---

### 5. Set Environment Variables

Di Railway, buka tab **Variables** pada service Laravel kamu, lalu masukkan:

```env
APP_NAME=King Gitar
APP_ENV=production
APP_KEY=          # Railway akan generate otomatis via nixpacks
APP_DEBUG=false
APP_URL=https://URL-KAMU.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

SESSION_DRIVER=database

GOOGLE_CLIENT_ID=ISI_DARI_GOOGLE_CONSOLE
GOOGLE_CLIENT_SECRET=ISI_DARI_GOOGLE_CONSOLE
GOOGLE_REDIRECT_URL=https://URL-KAMU.up.railway.app/auth/google/callback

GROQ_API_KEY=ISI_GROQ_API_KEY_KAMU
SCRAMBLE_TOKEN=token-rahasia-kamu
SANCTUM_STATEFUL_DOMAINS=URL-KAMU.up.railway.app
```

> [!CAUTION]
> Ganti `URL-KAMU` dengan URL Railway yang diberikan setelah deploy pertama. URL bisa dilihat di tab **Settings → Domains**.

---

### 6. Update Google OAuth

Di [Google Cloud Console](https://console.cloud.google.com):
1. Buka **APIs & Services → Credentials**
2. Edit OAuth Client ID kamu
3. Tambahkan ke **Authorized redirect URIs**:
   ```
   https://URL-KAMU.up.railway.app/auth/google/callback
   ```

---

### 7. Tunggu Deploy Selesai

Railway akan otomatis:
1. Install PHP & Composer dependencies
2. Generate APP_KEY
3. Jalankan `php artisan migrate --force`
4. Jalankan `php artisan optimize`
5. Mulai server

Kalau build berhasil, kamu akan lihat status **✅ Active** dan bisa buka URL-nya.

---

## Setelah Deploy

- Buka `https://URL-KAMU.up.railway.app` untuk cek landing page
- Buka `https://URL-KAMU.up.railway.app/docs/api` untuk cek Scramble (masukkan token)
- Buka `https://URL-KAMU.up.railway.app/login` untuk masuk sebagai admin

> [!TIP]
> Setiap kali kamu push ke GitHub (`git push`), Railway akan otomatis deploy ulang. Tidak perlu setting manual lagi!
