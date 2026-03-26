# 🎸 NASKAH VIDEO TEKNIS — King Gitar Katalog
> **Proyek:** King Gitar | **Framework:** Laravel 12 | **Durasi Video Estimasi:** 20–35 menit

---

## BAGIAN 0 — PEMBUKA (Intro Video)

> *[Kamera / layar menampilkan landing page King Gitar]*

"Hai! Di video ini kita akan bahas secara teknis project **King Gitar** — sebuah aplikasi katalog gitar berbasis web yang dibangun dengan Laravel 12, lengkap dengan fitur-fitur modern seperti REST API, chatbot AI, login Google, dokumentasi API otomatis dengan Scramble, dan banyak lagi. Kita akan bahas dari sisi stack yang digunakan, gaya coding-nya, fitur-fitur menariknya, letak code-nya di mana, sampai ke demo teknis pakai Postman."

---

## BAGIAN 1 — OVERVIEW PROYEK & TECH STACK

### 1.1 Apa itu King Gitar?
King Gitar adalah aplikasi **web katalog produk gitar** yang memiliki dua sisi:
1. **Sisi Publik (Guest)** — pengunjung bisa browsing produk, filter kategori, dan chat dengan AI.
2. **Sisi Admin** — admin bisa manage data produk, kategori, banner, testimoni, dan user via dashboard web maupun REST API.

### 1.2 Tech Stack yang Digunakan

| Lapisan | Teknologi | Alasan Dipilih |
|---|---|---|
| **Backend Framework** | Laravel 12 | Ekosistem paling mature di PHP, MVC yang rapih, built-in ORM, CLI tools |
| **Bahasa** | PHP 8.2+ | Fitur terbaru (typed properties, enums, fibers, match expression) |
| **Database** | MySQL (prod) / SQLite (dev) | SQLite cocok buat dev cepat tanpa setup server |
| **Auth (Session)** | Laravel built-in Auth | Simple, aman, terintegrasi langsung dengan middleware |
| **Auth (API Token)** | Laravel Sanctum | Token-based auth untuk REST API, lightweight dibanding Passport |
| **Google OAuth** | Laravel Socialite | Library resmi Laravel, abstraksi OAuth2 yang simpel |
| **Chatbot AI** | Groq API (llama-3.1-8b-instant) | Gratis dengan free tier, latency rendah (Groq chip sangat cepat untuk inference) |
| **API Docs** | Dedoc Scramble | Auto-generate dokumentasi API dari kode PHP langsung, tanpa nulis YAML |
| **Frontend** | Blade + Vanilla CSS + Tailwind CLI | Blade untuk templating server-side, Tailwind buat utility class cepat |
| **Asset Bundler** | Vite | Hot Module Replacement (HMR) yang cepat, modern standard |
| **Image Storage** | Laravel Storage (public disk) | Manajemen file terintegrasi, mudah symlink ke public |
| **HTTP Client** | Laravel Http Facade (Guzzle) | Wrapper Guzzle yang fluent, mudah dibaca |
| **Hosting** | InfinityFree / Railway | InfinityFree buat produksi gratis, Railway buat testing CI |

> **Mengapa Laravel?** Laravel memberikan "developer experience" terbaik di PHP: routing ekspresif, Eloquent ORM, migration sistem, middleware, service container — semua tersedia out-of-the-box. Untuk project PSAJ skala ini, Laravel adalah pilihan paling produktif.

---

## BAGIAN 2 — STRUKTUR FOLDER & GAYA CODING

### 2.1 Struktur Folder Penting

```
gitar-katalog/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               ← Controller view admin (web)
│   │   │   ├── Api/
│   │   │   │   ├── Admin/           ← API controller untuk admin (CRUD)
│   │   │   │   ├── PublicApi/       ← API controller publik (read-only)
│   │   │   │   ├── AuthController.php
│   │   │   │   └── ChatbotController.php
│   │   │   └── SocialiteController.php  ← Google OAuth
│   │   ├── Middleware/
│   │   └── Requests/                ← Form Request Validation
│   ├── Models/                      ← Eloquent Models
│   │   ├── Product.php
│   │   ├── Category.php
│   │   ├── Banner.php
│   │   ├── Testimonial.php
│   │   ├── ActivityLog.php
│   │   └── User.php
│   ├── Services/                    ← Business Logic Layer
│   │   ├── ChatbotService.php       ← Integrasi Groq AI
│   │   ├── ChatbotContextService.php← Builder konteks AI dari DB
│   │   └── ImageService.php         ← Upload/delete gambar
│   └── Helpers/
├── database/
│   ├── migrations/                  ← Versi skema database
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── landing.blade.php        ← Halaman utama (hero, fitur, testimoni)
│   │   ├── katalog.blade.php        ← Halaman katalog produk
│   │   ├── kategori.blade.php       ← Halaman per kategori
│   │   ├── detail-produk.blade.php  ← Halaman detail produk
│   │   ├── admin/                   ← View dashboard admin
│   │   └── auth/                    ← Login page
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                      ← Route halaman web (session-based)
│   └── api.php                      ← Route REST API (token-based)
└── composer.json                    ← Dependency PHP
```

### 2.2 Gaya Coding yang Digunakan

#### ✅ Service Layer Pattern
Logika bisnis **tidak ditaruh di Controller**, melainkan dipisahkan ke kelas **Service** di `app/Services/`. Ini menjaga controller tetap tipis dan mudah di-test.

```
Controller (terima request, validasi) 
    → Service (proses logika)
        → Model (akses database)
```

Contoh: `ChatbotController` → `ChatbotService` → `ChatbotContextService`

#### ✅ Form Request Validation
Validasi input dipisahkan ke kelas `Request` di `app/Http/Requests/`, bukan ditulis inline di controller. Ini lebih rapi dan reusable.

#### ✅ Eloquent Scopes
Di `Product.php`, filter-filter query ditulis sebagai **Eloquent Scope** sehingga bisa di-chain dengan fluent syntax:

```php
// Letak: app/Models/Product.php
Product::search('gitar akustik')
       ->byCategory(2)
       ->byPriceRange(500000, 5000000)
       ->inStock()
       ->get();
```

#### ✅ Route Model Binding dengan Slug
URL produk pakai **slug** (bukan ID) agar SEO-friendly. Ketika route menerima `{product:slug}`, Laravel otomatis cari produk berdasarkan slug.

```php
// Letak: app/Models/Product.php
public function getRouteKeyName(): string {
    return 'slug'; // Route Model Binding pakai slug
}
```

#### ✅ Accessor & Mutator (Eloquent)
Model secara otomatis menghasilkan properti tambahan tanpa query baru:
```php
// Letak: app/Models/Product.php - $appends = ['image_url']
public function getImageUrlAttribute(): ?string {
    return Storage::url($this->image); // otomatis URL lengkap
}
```

#### ✅ Model Events (Boot Method)
Slug di-generate **otomatis** saat produk dibuat, tanpa perlu developer ingat set mannual:
```php
// Letak: app/Models/Product.php
protected static function boot() {
    parent::boot();
    static::creating(function ($product) {
        if (empty($product->slug)) {
            $product->slug = static::generateUniqueSlug($product->name);
        }
    });
}
```

#### ✅ SoftDeletes
Product menggunakan `SoftDeletes` — data tidak benar-benar dihapus dari DB, hanya ditandai `deleted_at`. Data bisa dipulihkan kapan saja.
```php
// Letak: app/Models/Product.php
use SoftDeletes;
```

---

## BAGIAN 3 — FITUR-FITUR MENARIK (Detail Lengkap)

### 🤖 Fitur 1: Chatbot AI (King Gitar AI)

**Letak code:**
- `app/Services/ChatbotService.php` — Inti logika chatbot, panggil Groq API
- `app/Services/ChatbotContextService.php` — Ambil data produk/testimoni dari DB untuk jadi konteks AI
- `app/Http/Controllers/Api/ChatbotController.php` — Controller API endpoint chatbot
- `routes/api.php` line 61-62 — Route: `POST /api/v1/chatbot`

**Cara Kerja:**
1. User kirim pesan dari frontend
2. `ChatbotContextService::buildContext()` mengambil data produk asli, kategori, dan testimoni dari database dalam format string
3. Data tersebut dijadikan **System Instruction** sebelum prompt user
4. `ChatbotService::chat()` mengirim request ke **Groq API** dengan model `llama-3.1-8b-instant`
5. AI menjawab **hanya berdasarkan data real dari DB** — tidak bisa mengarang produk

**Mengapa Groq?**
- Groq Chip (LPU) sangat cepat untuk inference AI, latency jauh lebih rendah dibanding OpenAI biasa
- Memiliki **free tier** yang cukup untuk project sekolah
- Kompatibel dengan format OpenAI Chat API, jadi tidak perlu ganti library

**Fitur Keamanan Chatbot:**
- Rate limit: 30 request per menit via Laravel throttle middleware (`throttle:30,1`)
- AI diberi system prompt dengan aturan yang tidak bisa dilihat user (aturan rahasia)
- Max response 1300 karakter agar tidak spam panjang
- Error handling lengkap: koneksi gagal, rate limit (HTTP 429), auth error (HTTP 401/403)

---

### 🔐 Fitur 2: Login Google (OAuth2 via Socialite)

**Letak code:**
- `app/Http/Controllers/SocialiteController.php` — Logika redirect dan callback Google
- `routes/web.php` line 41-42 — Route: `GET /auth/google/redirect`, `/auth/google/callback`
- `database/migrations/2026_02_23_000002_add_google_id_to_users_table.php` — Kolom `google_id` di tabel users

**Cara Kerja:**
1. User klik "Login dengan Google"
2. `redirectToGoogle()` → redirect ke halaman consent OAuth Google
3. Google callback ke `/auth/google/callback`
4. `handleGoogleCallback()` → cari user di DB berdasarkan `google_id` atau email
5. Jika user ada & adalah admin → login dan redirect ke dashboard
6. Jika tidak terdaftar → tolak dengan pesan error

**Mengapa Socialite?**
Library resmi Laravel yang meng-abstraksi seluruh flow OAuth2. Tanpa Socialite, developer harus manual handle token exchange, HTTP request ke Google, parsing response, dll — sangat rumit dan rawan bug.

**Fitur penting:** Di local development, ada fix SSL bypass (`['verify' => false]`) karena cURL di localhost sering error sertifikat. Di production (env bukan `local`), SSL tetap diverifikasi secara penuh.

---

### 📄 Fitur 3: REST API + Dokumentasi Otomatis (Scramble)

**Letak code:**
- `routes/api.php` — Semua route API dengan versi prefix `/api/v1`
- `app/Http/Controllers/Api/` — Semua API controller
- `routes/web.php` line 31-38 — Token gate untuk akses Scramble docs

**Struktur API:**
```
GET  /api/v1/                → Info API
POST /api/v1/login           → Login (dapat token Sanctum)
POST /api/v1/logout          → Logout
GET  /api/v1/me              → Info user yang login

GET  /api/v1/products        → Daftar produk (search, filter, pagination)
GET  /api/v1/products/{slug} → Detail produk by slug
GET  /api/v1/categories      → Daftar kategori
GET  /api/v1/banners         → Banner aktif
GET  /api/v1/testimonials    → Testimoni aktif
POST /api/v1/chatbot         → Chat dengan AI

# Admin (butuh token Sanctum + is_admin)
GET/POST/PUT/DELETE /api/v1/admin/products
GET/POST/PUT/DELETE /api/v1/admin/categories
GET/POST/PUT/DELETE /api/v1/admin/banners
GET/POST/PUT/DELETE /api/v1/admin/testimonials
GET/POST/PUT/DELETE /api/v1/admin/users
GET                  /api/v1/admin/stats        ← Dashboard statistik
```

**Mengapa Scramble (bukan Swagger biasa)?**
Scramble dari package `dedoc/scramble` membaca kode PHP (type hints, PHPDoc, Form Request) dan **auto-generate dokumentasi interaktif** tanpa menulis satu baris YAML/JSON pun. Aksesnya di `/docs/api`.

**Token Gate Scramble:**
Karena `/docs/api` berisi semua struktur API (termasuk endpoint admin), ada mekanisme token gate yang harus diinputkan dulu sebelum bisa melihat dokumentasi. Token disimpan di `.env` sebagai `SCRAMBLE_TOKEN`.

---

### 🔑 Fitur 4: Authentication Dual-Mode (Session + API Token)

**Session-based (Web):**
- Pakai `Auth::guard('web')` built-in Laravel
- Cocok untuk admin yang akses via browser (state tersimpan di session/cookie)
- Protected dengan middleware `auth` + `admin` custom middleware

**Token-based (API):**
- Pakai **Laravel Sanctum** (`auth:sanctum`)
- Admin POST ke `/api/v1/login` dapat token, lalu sertakan token di header `Authorization: Bearer <token>`
- Rate limiting berbeda: login 5x/menit (brute force protection), endpoint umum 60x/menit, admin 120x/menit

---

### 🗃️ Fitur 5: Database Migration & Versioning

**Letak code:** `database/migrations/`

| File Migration | Fungsi |
|---|---|
| `create_users_table.php` | Tabel users dengan `is_admin` flag |
| `create_categories_table.php` | Tabel kategori produk |
| `create_products_table.php` | Tabel produk dengan foreign key ke category |
| `create_banners_table.php` | Tabel banner promosi |
| `create_testimonials_table.php` | Tabel testimoni pelanggan |
| `create_activity_logs_table.php` | Log aktivitas admin |
| `add_google_id_to_users_table.php` | Tambah kolom `google_id` (Google OAuth) |
| `add_created_by_to_crud_tables.php` | Tambah `created_by` (foreign key ke users) |
| `change_role_to_is_admin.php` | Refactor kolom `role` menjadi boolean `is_admin` |

**Mengapa Migration?** Migration adalah "version control untuk database". Tim bisa tahu persis perubahan skema apa yang terjadi, kapan, dan bisa rollback kalau ada masalah.

---

### 🖼️ Fitur 6: Image Upload & Management (ImageService)

**Letak code:** `app/Services/ImageService.php`

```php
// Upload: nama file UUID supaya tidak bentrok
$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
$path = $file->storeAs($folder, $filename, 'public');

// Update: hapus file lama dulu, baru upload baru
public function update($newFile, $oldPath, $folder): string {
    $this->delete($oldPath); // Cegah file orphan/sampah
    return $this->upload($newFile, $folder);
}
```

**Mengapa UUID untuk nama file?** UUID (Universally Unique Identifier) menjamin nama file selalu unik meski di-upload ribuan file dengan nama sama. Ini mencegah file saling overwrite.

---

### 📱 Fitur 7: WhatsApp Order Generator

**Letak code:** `app/Models/Product.php` — method `getWhatsAppLink()`

```php
public function getWhatsAppLink(): string {
    $phoneNumber = config('app.whatsapp_admin_number');
    $message = urlencode(
        "Halo Admin, saya ingin memesan {$this->name} dengan harga {$this->formatted_price}."
    );
    return "https://wa.me/{$phoneNumber}?text={$message}";
}
```

Tombol "Pesan" di halaman detail produk langsung membuka WhatsApp dengan pesan pre-filled berisi nama produk dan harga. Ini mempermudah proses pemesanan tanpa perlu payment gateway.

---

### 🔍 Fitur 8: SEO-Friendly URLs dengan Slug

**Letak code:** `app/Models/Product.php` — method `generateUniqueSlug()`

URL produk: `/produk/yamaha-f310-acoustic-guitar` (bukan `/produk/42`)

Slug di-generate otomatis dari nama produk saat dibuat:
1. `Str::slug('Yamaha F310')` → `yamaha-f310`
2. Kalau sudah ada yang sama → `yamaha-f310-2`, dst.
3. Pengecekan pakai `withTrashed()` agar slug produk yang di-soft-delete juga dicek, mencegah konflik.

---

### 📊 Fitur 9: Activity Log (Audit Trail)

**Letak code:** `app/Models/ActivityLog.php`

Setiap aksi admin (create/update/delete produk, dll.) dicatat di tabel `activity_logs`. Ini berguna untuk:
- Audit siapa yang ubah apa
- Debugging kalau ada data yang tiba-tiba berubah
- Requirement enterprise (accountability)

---

### ⚡ Fitur 10: Skeleton Loading & UX Enhancement

Di halaman katalog, saat data belum dimuat (loading), ditampilkan **skeleton loading** — placeholder abu-abu yang beranimasi. Ini member kesan bahwa aplikasi responsif dan cepat, bukan hang.

Teknik ini diimplementasikan di `resources/views/katalog.blade.php` dan `kategori.blade.php` menggunakan CSS animation `@keyframes shimmer`.

---

### 🎨 Fitur 11: UI Publik — Landing Page yang Kaya

**Letak code:** `resources/views/landing.blade.php` (51KB — view terbesar)

Halaman landing berisi:
- **Hero section** dengan background gambar dan overlay gelap (glassmorphism effect)
- **Mid-branding section** dengan full-bleed image
- **Grid produk unggulan** dari API `/api/v1/products`
- **Kartu kategori** interaktif
- **Section testimoni** dengan fixed-height cards
- **Chatbot floating button** — bisa dibuka dari halaman mana saja
- **Navbar responsif** dengan mobile menu toggle

---

## BAGIAN 4 — PENJELASAN CODE INTI (Live Code Walkthrough)

> *Bagian ini cocok ditampilkan sambil buka VS Code dan sorot kode satu per satu*

### 4.1 Routes (Penentuan Alur Aplikasi)

**File:** `routes/web.php`

```php
// Halaman publik — tidak perlu login
Route::get('/', fn() => view('landing'));
Route::get('/katalog', fn() => view('katalog'));
Route::get('/produk/{slug}', fn($slug) => view('detail-produk', ['slug' => $slug]))->name('produk.detail');

// Admin — harus login DAN is_admin = true
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('admin.dashboard');
    // dst...
});

// Google OAuth
Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
```

**File:** `routes/api.php` — Ada 3 kelompok route:
1. Public (tanpa auth) — siapa saja bisa akses
2. Authenticated (dengan Sanctum token) — user login biasa
3. Admin (Sanctum + is_admin) — hanya admin

### 4.2 Product Model (Paling Fitur-Kaya)

**File:** `app/Models/Product.php`

Tunjukkan satu per satu:
- `use SoftDeletes;` — soft delete
- `$fillable` — mass assignment protection
- `$appends = ['image_url']` — accessor otomatis di JSON response
- `boot()` + `creating()`/`updating()` — model events untuk auto-slug
- `generateUniqueSlug()` — slug collision-safe dengan loop
- `getImageUrlAttribute()` — accessor image URL
- `getWhatsAppLink()` — generator link WA
- `scopeSearch()`, `scopeByCategory()`, `scopeByPriceRange()`, `scopeInStock()` — Eloquent scopes yang chainable

### 4.3 ChatbotService (Paling Kompleks & Menarik)

**File:** `app/Services/ChatbotService.php`

1. `private string $endpoint = 'https://api.groq.com/openai/v1/chat/completions'` — Groq pakai format OpenAI
2. `$contextService->buildContext()` — ambil data real dari DB  
3. `$systemInstruction` — instruksi panjang yang membentuk "kepribadian" AI (tunjukkan rules 1-9)
4. `$messages` array dengan `role: system`, `role: user`, `role: assistant` — format chat history
5. `'model' => 'llama-3.1-8b-instant'` — model yang dipakai, gratis dan cepat
6. `'temperature' => 0.3` — nilai rendah agar jawaban konsisten, tidak terlalu kreatif/ngawur
7. Error handling: HTTP 429 (rate limit), 401/403 (auth error), connection exception

**File:** `app/Services/ChatbotContextService.php`

Tunjukkan bagaimana data produk dari DB di-serialize ke string untuk dijadikan "ingatan" AI:
```php
$products = Product::with('category')->latest()->limit(50)->get();
foreach ($products as $p) {
    $lines[] = "- " . json_encode($p->toArray());
}
```

### 4.4 SocialiteController (Google OAuth)

**File:** `app/Http/Controllers/SocialiteController.php`

1. `redirectToGoogle()` — kirim user ke halaman consent Google
2. `stateless()` — mencegah bug session saat callback
3. Cek `google_id` atau `email` — handle akun yang sudah ada sebelum Google OAuth ditambahkan
4. Hanya admin yang bisa login lewat Google (`is_admin` check)
5. SSL bypass di local environment — pragmatik, tidak mengorbankan keamanan production

### 4.5 ImageService (Clean & Reusable)

**File:** `app/Services/ImageService.php`

1. `Str::uuid()` → nama file unik, anti-overwrite
2. `storeAs($folder, $filename, 'public')` → simpan ke `storage/app/public/{folder}/`
3. `update()` → pattern "delete dulu, upload baru" mencegah file orphan/sampah di storage

---

## BAGIAN 5 — DEMO TEKNIS: POSTMAN

> *Buka Postman, siapkan collection*

### 5.1 Setup Postman

1. Buat Collection baru: **"King Gitar API"**
2. Set Base URL variable: `{{base_url}}` = `http://localhost:8000`
3. Jalankan server: `php artisan serve`

### 5.2 Demo Endpoint Publik (Tanpa Auth)

**Step 1 — Info API**
```
GET {{base_url}}/api/v1/
```
Response: info versi API

**Step 2 — Daftar Produk dengan Filter**
```
GET {{base_url}}/api/v1/products?search=gitar&per_page=5
```
Fitur yang terlihat:
- Pagination (`data`, `meta.total`, `meta.per_page`, `meta.current_page`)
- Search by nama
- `image_url` otomatis dari accessor

**Step 3 — Detail Produk by Slug (SEO URL)**
```
GET {{base_url}}/api/v1/products/yamaha-f310
```
Tunjukkan bahwa URL menggunakan slug, bukan `/products/42`

**Step 4 — Chatbot AI**
```
POST {{base_url}}/api/v1/chatbot
Content-Type: application/json

{
    "message": "Rekomendasikan gitar akustik untuk pemula",
    "history": []
}
```
Tunjukkan response dari AI yang hanya merekomendasikan produk asli dari DB.

Coba lagi: kirim pesan tidak relevan seperti `"Apa ibu kota Prancis?"`  
AI akan menolak karena di luar topik musik.

**Step 5 — Rate Limit Test**
Kirim request chatbot 31 kali berturut-turut → request ke-31 dapat response HTTP 429.

### 5.3 Demo Auth Login (Session API)

**Step 6 — Login**
```
POST {{base_url}}/api/v1/login
Content-Type: application/json

{
    "email": "admin@kinggitar.com",
    "password": "password123"
}
```
Simpan token dari response:
```json
{
    "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ..."
}
```

**Step 7 — Set Token di Header**
```
Authorization: Bearer 1|aBcDeFgHiJkLmNoPqRsTuVwXyZ...
```

**Step 8 — Cek Profil**
```
GET {{base_url}}/api/v1/me
```

### 5.4 Demo Admin CRUD via API

**Step 9 — Buat Produk Baru**
```
POST {{base_url}}/api/v1/admin/products
Authorization: Bearer {token}
Content-Type: multipart/form-data

name: Gitar Test Postman
price: 1500000
stock: 5
category_id: 1
description: Ini produk test dari Postman
```

Tunjukkan: slug otomatis di-generate dari nama (`gitar-test-postman`), tanpa perlu input slug.

**Step 10 — Dashboard Stats**
```
GET {{base_url}}/api/v1/admin/stats
Authorization: Bearer {token}
```
Response: total produk, kategori, testimoni, user.

**Step 11 — Coba Akses Admin Tanpa Token**
```
GET {{base_url}}/api/v1/admin/products
(tanpa Authorization header)
```
Response: HTTP 401 Unauthorized. Tunjukkan bahwa proteksi berjalan.

**Step 12 — Logout**
```
POST {{base_url}}/api/v1/logout
Authorization: Bearer {token}
```
Token dihapus dari DB. Coba pakai token yang sama lagi → 401.

---

## BAGIAN 6 — DEMO SCRAMBLE (DOKUMENTASI API OTOMATIS)

> *Buka browser ke `http://localhost:8000/docs/api`*

### 6.1 Apa itu Scramble?

**Scramble** adalah package `dedoc/scramble` yang membaca kode PHP dan menghasilkan **dokumentasi API interaktif** (mirip Swagger UI) secara otomatis. Tidak perlu nulis satu baris YAML atau JSON annotation.

**Letak instalasi:** `composer.json` di bagian `require`:
```json
"dedoc/scramble": "^0.13.12"
```

### 6.2 Token Gate (Keamanan Akses Docs)

Sebelum bisa melihat `/docs/api`, ada halaman input token dulu. Token disimpan di `.env` sebagai `SCRAMBLE_TOKEN`.

**Letak code:** `routes/web.php` line 31-38:
```php
Route::post('/docs/api/verify', function (Request $request) {
    $token = env('SCRAMBLE_TOKEN');
    if ($request->input('token') === $token) {
        $request->session()->put('scramble_token_verified', true);
        return redirect('/docs/api');
    }
    return redirect('/docs/api')->with('scramble_error', 'Token salah.');
});
```

Cara kerja: session menyimpan flag `scramble_token_verified`. Middleware Scramble cek flag ini sebelum tampilkan docs.

### 6.3 Yang Bisa Dilakukan di Scramble

Tunjukkan di browser:
1. **Semua endpoint terdaftar otomatis** beserta method (GET/POST/PUT/DELETE)
2. **Parameter request** (query, body, path parameter) terbaca dari Form Request
3. **Response schema** terbaca dari return type dan PHPDoc
4. **Try it out** — bisa langsung test endpoint dari browser (mirip Postman tapi di docs)
5. Tunjukkan endpoint admin vs public dipisahkan

> Poin jual utama: "Dengan Scramble, developer lain yang mau integrasi dengan API ini bisa langsung buka `/docs/api` dan semua sudah terdokumentasi, tanpa programmer perlu nulis docs secara manual."

---

## BAGIAN 7 — RUNNING TEKNIS (Development Workflow)

### 7.1 Clone & Setup

```bash
# Clone project
git clone [url-repo]
cd gitar-katalog

# Install dependency PHP
composer install

# Copy .env
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database (SQLite untuk dev)
php artisan migrate

# Install dependency JS
npm install

# Build assets
npm run build
```

### 7.2 Menjalankan Development Server

Command `composer dev` menjalankan 4 proses sekaligus:

```bash
composer dev
```

Ini menjalankan:
1. `php artisan serve` — web server PHP
2. `php artisan queue:listen` — antrian background job
3. `php artisan pail` — real-time log viewer
4. `npm run dev` — Vite HMR untuk asset

**Mengapa pakai concurrently?** Satu terminal, 4 proses. Sangat praktis untuk development.

### 7.3 Command Penting Lainnya

```bash
# Lihat semua route
php artisan route:list

# Masuk mode interaktif (tinker)
php artisan tinker

# Contoh di tinker:
>>> App\Models\Product::count()
>>> App\Models\Product::inStock()->get()

# Reset database dan seed ulang
php artisan migrate:fresh --seed

# Build untuk produksi
npm run build
php artisan optimize
```

---

## BAGIAN 8 — POIN TAMBAHAN YANG MENARIK UNTUK DITONJOLKAN

### 🏗️ Arsitektur yang Bersih (MVC + Service Layer)
Project ini memisahkan concern dengan sangat baik: **Model** (data), **Controller** (terima request, kirim response), **Service** (logika bisnis), dan **View** (presentasi). Ini membuat kode mudah di-maintain dan scale.

### 🚦 Rate Limiting yang Berlapis
Setiap endpoint punya rate limit berbeda sesuai sensitivitasnya:
- Login: 5/menit (anti brute-force)
- Chatbot: 30/menit (anti spam AI)
- API umum: 60/menit
- Admin: 120/menit

### 📦 Composer Scripts yang Produktif
Script `composer dev` dan `composer setup` di `composer.json` mempermudah onboarding developer baru. Hanya perlu satu command untuk mulai development.

### 🌐 Dual Hosting Strategy
- **InfinityFree** — hosting produksi gratis untuk demo
- **Railway** — testing & CI deployment otomatis via git push

### 🔒 Keamanan yang Diperhatikan
- CSRF protection otomatis di semua form web (Laravel default)
- Mass assignment protection via `$fillable`
- Sanctum token dibuat per-device, bisa revoke individual
- SQL Injection terlindungi via Eloquent parameterized query
- Google OAuth hanya untuk admin terdaftar
- Dokumentasi API terlindungi token gate

### 📅 Audit Trail dengan created_by
Setiap produk, kategori, banner, dan testimoni menyimpan `created_by` sebagai foreign key ke tabel `users`. Ini memungkinkan pelacakan siapa yang membuat data apa.

---

## BAGIAN 9 — PENUTUP VIDEO

> *[Kamera / layar kembali ke landing page]*

"Jadi itulah overview teknis dari project King Gitar. Dari sisi stack kita pakai **Laravel 12** sebagai tulang punggung, **Sanctum** untuk API auth, **Socialite** untuk Google login, **Groq AI** untuk chatbot, **Scramble** untuk dokumentasi API otomatis. Dari sisi teknik coding, kita terapkan **Service Layer**, **Eloquent Scopes**, **Model Events**, **SoftDeletes**, dan **Route Model Binding** dengan slug.

Yang membuat project ini lebih dari sekedar CRUD biasa adalah fitur-fitur seperti chatbot AI yang sadar konteks produk, Google OAuth, WhatsApp order generator, SEO-friendly URL, skeleton loading, dan dokumentasi API otomatis yang bisa langsung di-test.

Semoga video ini bermanfaat! Kalau ada pertanyaan, tinggalkan di kolom komentar."

---

## APPENDIX — CHEAT SHEET UNTUK VIDEO

### File Paling Penting yang Disorot

| File | Baris Kunci | Topik |
|---|---|---|
| `routes/web.php` | 21-28, 31-42 | Admin routes, Google OAuth, Scramble gate |
| `routes/api.php` | 61-63, 68-73, 78-109 | Chatbot, Auth, Admin CRUD |
| `app/Models/Product.php` | 71-88, 93-113, 147-156 | Boot events, slug, WhatsApp |
| `app/Services/ChatbotService.php` | 35-49, 65-70 | System prompt, payload Groq |
| `app/Services/ChatbotContextService.php` | 53-68 | Context builder dari DB |
| `app/Services/ImageService.php` | 27-38, 84-91 | Upload UUID, update pattern |
| `app/Http/Controllers/SocialiteController.php` | 29-78 | Google callback flow |
| `composer.json` | 11-17, 54-57 | Dependencies, composer dev |

### Urutan Demo Postman yang Disarankan
1. `GET /api/v1/` — info API
2. `GET /api/v1/products?search=gitar` — publik, cek pagination
3. `POST /api/v1/chatbot` — tanya rekomendasi, coba topik non-musik
4. `POST /api/v1/login` — dapat token
5. `GET /api/v1/me` — verifikasi token
6. `POST /api/v1/admin/products` — buat produk, cek slug auto
7. `GET /api/v1/admin/stats` — dashboard stats
8. Coba akses admin tanpa token → 401
9. `POST /api/v1/logout` — hapus token

### Urutan Demo Scramble
1. Buka `/docs/api` → minta token
2. Input SCRAMBLE_TOKEN dari `.env` → masuk
3. Tunjukkan endpoint list yang auto-generated
4. "Try it out" endpoint publik
5. Tambahkan Bearer token di Authorize → test endpoint admin
