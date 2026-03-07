<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;

/**
 * ChatbotContextService
 *
 * Mengambil data publik dari database untuk dijadikan konteks chatbot.
 * HANYA mengambil data yang tersedia secara publik di website:
 * - Daftar kategori produk
 * - Daftar produk (nama, harga, stok, kategori, deskripsi singkat)
 *
 * Data sensitif (user, admin, transaksi, dll.) TIDAK pernah diambil.
 */
class ChatbotContextService
{
    /**
     * Ambil ringkasan data publik untuk dijadikan konteks AI.
     */
    public function buildContext(): string
    {
        $lines = [];

        // --- Info Toko (Dari Landing Page) ---
        $lines[] = '=== PROFIL KING GITAR ===';
        $lines[] = 'King Gitar hadir sebagai ruang bagi para pecinta musik untuk menemukan gitar dengan kualitas terbaik dan karakter suara yang otentik. Setiap instrumen dipilih dengan standar tinggi, mengutamakan detail, kenyamanan, dan keindahan desain.';
        $lines[] = 'Kami percaya bahwa gitar bukan sekadar alat musik, tetapi bagian dari perjalanan musikal setiap pemain. Oleh karena itu, King Gitar menghadirkan koleksi gitar yang memadukan craftsmanship klasik, material berkualitas, dan sentuhan modern.';
        $lines[] = 'Dengan tampilan elegan dan proses kurasi yang cermat, King Gitar berkomitmen menjadi destinasi terpercaya bagi musisi pemula hingga profesional untuk menemukan instrumen yang tepat dan bernilai jangka panjang.';
        $lines[] = 'Kami menghadirkan pengalaman berbelanja yang sederhana, tenang, dan terkurasi. Mulai dari pemilihan produk hingga penyajian katalog, semuanya dirancang agar pelanggan dapat fokus menemukan gitar yang benar-benar sesuai dengan karakter dan kebutuhan musikal mereka.';
        $lines[] = '';

        // --- Info Kontak & Lokasi ---
        $lines[] = '=== KONTAK & LOKASI ===';
        $lines[] = 'Nomor WhatsApp / Kontak: 6285724453063';
        $lines[] = 'Google Maps / Lokasi Toko : https://maps.app.goo.gl/zhoiQYGW8puC2Cny5';
        $lines[] = '';

        // --- Kategori Produk ---
        $categories = Category::orderBy('name')->get();

        if ($categories->isNotEmpty()) {
            $lines[] = '=== KATEGORI PRODUK KING GITAR ===';
            foreach ($categories as $cat) {
                $lines[] = "- " . json_encode($cat->toArray());
            }
            $lines[] = '';
        }

        // --- Daftar Produk (max 50, diurutkan terbaru) ---
        $products = Product::with('category')
            ->latest()
            ->limit(50)
            ->get();

        if ($products->isNotEmpty()) {
            $lines[] = '=== DAFTAR PRODUK (DATA REAL) ===';
            foreach ($products as $p) {
                $data = $p->toArray();
                if (!empty($data['description'])) {
                    $data['description'] = \Illuminate\Support\Str::limit(strip_tags($data['description']), 80);
                }
                $lines[] = "- " . json_encode($data);
            }
            $lines[] = '';
        }

        // --- Testimoni Publik (Social Proof) ---
        $testimonials = Testimonial::active()
            ->latest()
            ->limit(5)
            ->get();

        if ($testimonials->isNotEmpty()) {
            $lines[] = '=== TESTIMONI PUBLIK ===';
            foreach ($testimonials as $t) {
                $lines[] = "- " . json_encode($t->toArray());
            }
            $lines[] = '';
        }

        if (empty($lines)) {
            return '';
        }

        return implode("\n", $lines);
    }
}
