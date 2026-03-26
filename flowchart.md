# Flowchart Sistem King Gitar

Dokumen ini berisi diagram alur (Flowchart) dari fitur-fitur utama di dalam sistem **King Gitar**. Diagram digambarkan menggunakan sintaks Mermaid.

---

## 📖 Panduan Simbol Flowchart

Berikut adalah jenis-jenis simbol dasar yang digunakan dalam flowchart ini beserta maknanya:

1. **Terminal / Terminator (Bentuk Oval / Kapsul)**
   - Simbol: `([ Teks ])`
   - Fungsi: Menunjukkan titik **AWAL (Mulai)** atau **AKHIR (Selesai)** dari sebuah alur program.
2. **Process / Proses (Bentuk Persegi Panjang)**
   - Simbol: `[ Teks ]`
   - Fungsi: Menunjukkan suatu **proses, perhitungan, atau aksi** yang dilakukan oleh sistem atau user.
3. **Data / Input-Output (Bentuk Jajar Genjang)**
   - Simbol: `[/ Teks /]`
   - Fungsi: Menunjukkan operasi **input** (memasukkan data) atau **output** (menampilkan hasil).
4. **Decision / Keputusan (Bentuk Belah Ketupat / Diamond)**
   - Simbol: `{ Teks }`
   - Fungsi: Menunjukkan titik **percabangan atau evaluasi kondisi** (Biasanya memiliki jawaban Ya / Tidak).
5. **Database / Penyimpanan (Bentuk Tabung / Silinder)**
   - Simbol: `[( Teks )]`
   - Fungsi: Menunjukkan proses mengambil atau menyimpan data ke dalam **Database**.

---

## 1. Alur Pemesanan / Pembelian Produk (Pengunjung Umum)
Alur ketika pengunjung website melihat katalog produk dan melakukan pemesanan via WhatsApp.

```mermaid
flowchart TD
    A([Mulai]) --> B[/"Buka Website King Gitar"/]
    B --> C["Akses Halaman Katalog"]
    C --> D[/"Input Kata Kunci / Filter Kategori"/]
    D --> E[("Ambil Data dari Database / Cache")]
    E --> F{"Apakah Produk Ditemukan?"}
    
    F -- Ya --> G[/"Tampilkan List Produk"/]
    F -- Tidak --> H[/"Tampilkan 'Produk Kosong'"/]
    H --> D
    
    G --> I["Pilih & Klik Detail Produk"]
    I --> J["Klik Tombol 'Pesan WhatsApp'"]
    J --> K["Sistem Generate Pesan Otomatis"]
    K --> L[/"Diarahkan ke Chat WhatsApp Admin"/]
    L --> M([Selesai])
```

---

## 2. Alur Interaksi Chatbot AI (King Gitar AI)
Alur ketika pengunjung menggunakan fitur live chat AI untuk bertanya atau meminta rekomendasi.

```mermaid
flowchart TD
    A([Mulai]) --> B[/"User Membuka Widget Chatbot"/] 
    B --> C[/"Input Pertanyaan di Textbox"/]
    C --> D["Klik Tombol Kirim / Enter"]
    D --> E["Aplikasi Meneruskan Pesan ke API Backend"]
    E --> F[("Ambil Konteks: Data Toko & Produk dari Database")]
    F --> G["Susun Payload beserta Riwayat Chat"]
    G --> H["Kirim Request ke Groq API (Model Llama-3)"]
    H --> I{"Apakah Berhasil (Status 200)?"}
    
    I -- Ya --> J["Ekstrak Jawaban dari Groq"]
    J --> K[/"Tampilkan Jawaban dengan Efek Ketik (Typewriter)"/]
    
    I -- Tidak --> L[/"Tampilkan Peringatan Error / Gagal Terhubung"/]
    
    K --> M(["Selesai / Menunggu Pertanyaan Berikutnya"])
    L --> M
```

---

## 3. Alur Autentikasi Admin (Login Standar: Email & Password)
Alur ketika admin masuk ke sistem panel dashboard menggunakan input email dan password secara manual.

```mermaid
flowchart TD
    A([Mulai]) --> B[/"Akses Halaman Login (/login)"/]
    B --> C[/"Input Email dan Password"/]
    C --> D["Klik Tombol Login"]
    D --> E["API Auth Mendapat Request"]
    E --> F{"Auth::attempt (Cek Kredensial Database)"}
    
    F -- Tidak Valid --> G[/"Tampilkan Pesan Error (401 Unauthorized)"/]
    G --> B
    
    F -- Valid --> H["Hapus Token Lama (Revoke)"]
    H --> I["Generate Token Baru (Sanctum)"]
    I --> J[("Catat di Activity Log 'User logged in'")]
    J --> K[/"Kembalikan Response Sukses + Token"/]
    K --> L[/"Redirect ke Halaman Admin Dashboard"/]
    L --> M([Selesai])
```

---

## 4. Alur Autentikasi Admin (Login via Google OAuth)
Alternatif login admin menggunakan akun Google.

```mermaid
flowchart TD
    A([Mulai]) --> B[/"Akses Halaman Login (/login)"/]
    B --> C["Klik Tombol 'Login with Google'"]
    C --> D["Redirect User ke Server Google"]
    D --> E[/"User Memilih Akun Google"/]
    E --> F["Google Mengirim Callback ke Sistem"]
    F --> G{"Pengecekan: Apakah Email Terdaftar?"}
    
    G -- Tidak Terdaftar --> H[/"Tolak Akses & Redirect kembali ke Login"/]
    H --> Z([Selesai])
    
    G -- Terdaftar --> I{"Pengecekan: Apakah User is_admin = 1?"}
    
    I -- Bukan Admin --> H
    
    I -- Admin --> J["Buat API Token (Sanctum)"]
    J --> K["Simpan Session Login"]
    K --> L[/"Buka Halaman Admin Dashboard"/]
    L --> Z
```

---

## 5. Alur Manajemen Data Admin (Create / Menambah Data)
Alur ketika admin berhasil login dan melakukan proses tambah data produk baru beserta gambar (Berlaku juga untuk kategori/banner).

```mermaid
flowchart TD
    A([Mulai]) --> B[/"Buka Menu Kelola Produk"/]
    B --> C["Klik Tombol 'Tambah Produk'"]
    C --> D[/"Muncul Form Input Produk"/]
    D --> E[/"Input Nama, Harga, Deskripsi, Kategori, Foto"/]
    E --> |Submit Form| F["Backend Memproses Request API"]
    F --> G{"Apakah Validasi Lolos?"}
    
    G -- Tidak Lolos / Data Kosong --> H[/"Kembalikan Pesan Error Validasi (422)"/]
    H --> D
    
    G -- Lolos Validasi --> I["Upload Foto ke Storage Disk Publik"]
    I --> J["Generate Slug Otomatis"]
    J --> K[("Simpan Record Baru ke Tabel Products")]
    K --> L[("Catat Aktivitas di Activity Logs")]
    L --> M[("Hapus Cache 'products_index' -> Invalidasi")]
    M --> N[/"Tampilkan Notifikasi 'Berhasil' & Tutup Form"/]
    N --> O([Selesai])
```

---

## 6. Alur Manajemen Data Admin (Update & Delete Data)
Alur ketika admin mengubah (Update) data atau menghapus (Delete) data.

```mermaid
flowchart TD
    A([Mulai]) --> B[/"Buka Menu List Produk"/]
    B --> C{"Apa yang ingin dilakukan?"}
    
    %% Alur Update
    C -- Update Data --> U1["Klik Edit Data"]
    U1 --> U2[/"Ubah Kolom / Upload Foto Baru"/]
    U2 --> U3["Submit (PUT / PATCH)"]
    U3 --> U4{"Validasi Lolos?"}
    U4 -- Tidak --> U5[/"Tampilkan Error"/]
    U4 -- Ya --> U6["Service Hapus Foto Lama (Jika ada foto baru)"]
    U6 --> U7["Upload Foto Baru"]
    U7 --> U8[("Update Database & Generate Slug Baru")]
    U8 --> EndMem[("Catat Log & Invalidasi Cache Detail/List")]
    EndMem --> EndProg([Selesai])
    
    %% Alur Delete
    C -- Delete Data --> D1["Klik Hapus (Trash)"]
    D1 --> D2[/"Muncul Konfirmasi Hapus"/]
    D2 --> D3{"Admin Konfirmasi Yakin?"}
    D3 -- Batal --> B
    D3 -- Ya (DELETE request) --> D4{"Pengecekan Relasi Foreign Key"}
    
    D4 -- Digunakan di Tabel Lain --> D5[/"Tolak Hapus (Error 409 Conflict)"/]
    D5 --> EndProg
    
    D4 -- Aman Dihapus --> D6["Hapus Foto dari Storage Publik"]
    D6 --> D7[("SoftDelete / Hapus Permanen dari DB")]
    D7 --> EndMem
```
