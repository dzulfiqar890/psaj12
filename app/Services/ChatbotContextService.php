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

        // --- Kategori Produk ---
        $categories = Category::select('name', 'description')
            ->orderBy('name')
            ->get();

        if ($categories->isNotEmpty()) {
            $lines[] = '=== KATEGORI PRODUK KING GITAR ===';
            foreach ($categories as $cat) {
                $desc = $cat->description ? " – {$cat->description}" : '';
                $lines[] = "- {$cat->name}{$desc}";
            }
            $lines[] = '';
        }

        // --- Daftar Produk (max 50, diurutkan terbaru) ---
        $products = Product::with('category:id,name')
            ->select('name', 'price', 'stock', 'description', 'category_id')
            ->latest()
            ->limit(50)
            ->get();

        if ($products->isNotEmpty()) {
            $lines[] = '=== DAFTAR PRODUK (DATA REAL) ===';
            foreach ($products as $p) {
                $categoryName = $p->category?->name ?? 'Umum';
                $harga        = 'Rp ' . number_format((float) $p->price, 0, ',', '.');
                $stok         = $p->stock > 0 ? "Stok: {$p->stock}" : 'Stok: Habis';
                $desc         = $p->description
                    ? ' | Deskripsi: ' . \Illuminate\Support\Str::limit(strip_tags($p->description), 80)
                    : '';
                $lines[] = "- [{$categoryName}] {$p->name} | Harga: {$harga} | {$stok}{$desc}";
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
                $lines[] = "- {$t->name}: \"{$t->testimony}\"";
            }
            $lines[] = '';
        }

        if (empty($lines)) {
            return '';
        }

        return implode("\n", $lines);
    }
}
