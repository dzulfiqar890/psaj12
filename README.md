<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  <br>
  <h1>🎸 Katalog Gitar</h1>
  <p>
    <strong>Aplikasi Web Katalog Gitar Berbasis Laravel 12</strong>
  </p>
  <p>
    <a href="https://king-gitar.gt.tc/" target="_blank">
      <img src="https://img.shields.io/badge/Demo-Live_Website-success?style=for-the-badge&logo=vercel" alt="Live Demo">
    </a>
    <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  </p>
</div>

<hr>

## 📖 Tentang Projek

**Katalog Gitar** adalah sebuah platform aplikasi web yang dirancang untuk menampilkan berbagai jenis gitar dengan tampilan yang elegan, modern, dan responsif. Dibangun menggunakan framework terdepan **Laravel 12** dan dikombinasikan dengan kemudahan styling dari **Tailwind CSS 4**, aplikasi ini memberikan pengalaman pengguna yang cepat dan dinamis.

Projek ini dibuat untuk keperluan *Production* di layanan shared hosting serta testing menggunakan cloud platforms.

## 🚀 Live Demo & Hosting

- **🌐 Final Hosting (Production):** [https://king-gitar.gt.tc/](https://king-gitar.gt.tc/)  
  *(Dihosting menggunakan **InfinityFree** untuk performa stabil pada lingkungan shared hosting)*
- **🧪 Testing Hosting:** **Railway**  
  *(Digunakan untuk keperluan testing, CI/CD otomatis, dan staging sebelum rilis ke production)*

## ✨ Fitur Utama

- **Tampilan Modern & Responsif:** Desain UI/UX yang memukau dan dioptimalkan untuk perangkat mobile dan desktop menggunakan Tailwind CSS.
- **Katalog Produk Dinamis:** Menampilkan daftar koleksi gitar, detail spesifikasi produk, dan gambar dengan tajam.
- **Sistem Kategori:** Pengelompokan gitar berdasarkan jenis (Akustik, Elektrik, Bass, dll).
- **Backend Tangguh (Laravel 12):** Menggunakan fitur-fitur terbaru Laravel dengan keamanan yang terjamin.
- **Performa Cepat:** Integrasi dengan **Vite** untuk build aset frontend yang super cepat.

## 🛠️ Tech Stack

- **Backend:** PHP 8.2+, Laravel 12.x
- **Frontend:** Tailwind CSS v4.0, Vite, Blade Templating
- **Database:** MySQL / SQLite
- **API Documentation:** Scramble (dedoc/scramble)
- **Deployment:** InfinityFree (Production), Railway (Staging)

---

## 💻 Panduan Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi ini di komputer lokal Anda:

### 1. Persyaratan Sistem
Pastikan Anda sudah menginstal:
- [PHP](https://www.php.net/downloads) (Versi 8.2 atau lebih baru)
- [Composer](https://getcomposer.org/)
- [Node.js & npm](https://nodejs.org/en/)
- Database MySQL / MariaDB (contoh: XAMPP, Laragon, dll)

### 2. Langkah Instalasi

```bash
# 1. Clone repositori ini
git clone https://github.com/username/gitar-katalog.git

# 2. Masuk ke direktori projek
cd gitar-katalog

# 3. Instal dependensi PHP menggunakan Composer
composer install

# 4. Instal dependensi Javascript/Node
npm install

# 5. Salin file konfigurasi environment
cp .env.example .env

# 6. Generate application key
php artisan key:generate
```

### 3. Konfigurasi Database
Buka file `.env` dan sesuaikan kredensial database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seed Data
Jalankan migrasi untuk membuat tabel beserta data dummy (opsional):
```bash
php artisan migrate --seed
```

### 5. Menjalankan Server Lokal
Jalankan perintah ini di dua terminal terpisah:

**Terminal 1 (Backend Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Frontend Vite):**
```bash
npm run dev
```

Buka browser dan akses: `http://localhost:8000`

---

## ☁️ Panduan Deployment

### 1. Deploy ke InfinityFree (Final Hosting)
Karena InfinityFree merupakan *shared hosting*, terdapat beberapa konfigurasi khusus:
1. Pastikan seluruh folder **vendor** sudah dipaketkan atau lakukan install sebelumnya.
2. Upload seluruh isi projek (kecuali direktori `.git` dan `node_modules` yang tidak diperlukan untuk production) ke dalam `htdocs`.
3. Pindahkan isi folder `public/` ke *root directory* atau sesuaikan menggunakan file `.htaccess`.
4. Import database MySQL yang telah di-ekspor dari lokal ke **phpMyAdmin** InfinityFree.
5. Sesuaikan file `.env` dengan kredensial database InfinityFree.

### 2. Deploy ke Railway (Testing)
Railway mendukung deployment langsung dari repositori GitHub:
1. Hubungkan akun GitHub dengan Railway.
2. Buat layanan baru di Railway dan pilih repositori `gitar-katalog`.
3. Tambahkan layanan **MySQL** dan sambungkan ke aplikasi.
4. Set *Environment Variables* di Railway sesuai dengan isi file `.env`.
5. Railway akan otomatis mendeteksi kebutuhan Laravel menggunakan file *Nixpacks* (tersedia dalam repositori) dan menjalankan aplikasinya secara otomatis.

---

## 👨‍💻 Kontribusi

Pengembangan lebih lanjut dari aplikasi ini sangat terbuka. Silakan lakukan **Fork**, buat *branch* fitur Anda, dan kirimkan **Pull Request**.

---

<div align="center">
  <p>Dibuat dengan ❤️ menggunakan <a href="https://laravel.com/">Laravel</a> & <a href="https://tailwindcss.com/">Tailwind CSS</a>.</p>
</div>
