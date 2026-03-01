<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder untuk data awal aplikasi Katalog Gitar.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ============================================================
        // USERS
        // ============================================================

        // Admin default
        User::create([
            'username' => 'admin',
            'email' => 'admin@gitarkatalog.com',
            'password' => 'password123',
            'no_telephone' => '6285747938471',
            'is_admin' => true,
        ]);

        $this->command->info('✓ Users seeded');

        // ============================================================
        // CATEGORIES
        // ============================================================

        $categories = [
            [
                'name' => 'Gitar Akustik',
                'description' => 'Koleksi gitar akustik berkualitas tinggi dengan suara jernih dan natural. Cocok untuk pemula hingga profesional.',
            ],
            [
                'name' => 'Gitar Elektrik',
                'description' => 'Gitar elektrik dengan berbagai pickup dan finishing menarik. Ideal untuk genre rock, jazz, hingga metal.',
            ],
            [
                'name' => 'Gitar Klasik',
                'description' => 'Gitar klasik dengan senar nilon untuk musik klasik, flamenco, dan fingerstyle.',
            ],
            [
                'name' => 'Bass',
                'description' => 'Bass guitar untuk rhythm section yang solid. Tersedia berbagai ukuran dan tipe.',
            ],
            [
                'name' => 'Ukulele',
                'description' => 'Ukulele berbagai ukuran dari soprano hingga baritone. Portable dan mudah dipelajari.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✓ Categories seeded');

        // ============================================================
        // PRODUCTS
        // ============================================================

        $products = [
            [
                'name' => 'Yamaha F310 Acoustic Guitar',
                'category_id' => 1,
                'price' => 1850000,
                'description' => 'Gitar akustik entry-level terbaik dari Yamaha. Memiliki suara yang jelas dan nyaman dimainkan. Top material: Spruce, Back/Side: Meranti.',
                'stock' => 15,
            ],
            [
                'name' => 'Taylor GS Mini Mahogany',
                'category_id' => 1,
                'price' => 8500000,
                'description' => 'Gitar travel size dengan suara full-size. Body mahogany solid memberikan tone yang warm dan rich.',
                'stock' => 5,
            ],
            [
                'name' => 'Fender Player Stratocaster',
                'category_id' => 2,
                'price' => 15000000,
                'description' => 'Stratocaster legendaris dengan pickup Alnico 5 Single-Coil. Tersedia dalam berbagai warna menarik.',
                'stock' => 8,
            ],
            [
                'name' => 'Gibson Les Paul Standard',
                'category_id' => 2,
                'price' => 35000000,
                'description' => 'Ikon gitar rock dengan dual Burstbucker Pro pickups. Maple top dengan mahogany body.',
                'stock' => 3,
            ],
            [
                'name' => 'Ibanez RG421',
                'category_id' => 2,
                'price' => 5500000,
                'description' => 'Gitar elektrik dengan neck tipis dan cepat. Cocok untuk shredding dan metal.',
                'stock' => 0,
            ],
            [
                'name' => 'Yamaha C40 Classical Guitar',
                'category_id' => 3,
                'price' => 1200000,
                'description' => 'Gitar klasik full-size untuk pemula. Senar nilon yang lembut di jari.',
                'stock' => 20,
            ],
            [
                'name' => 'Cordoba C5',
                'category_id' => 3,
                'price' => 4500000,
                'description' => 'Gitar klasik dengan cedar top dan rosewood sides. Suara warm dan resonan.',
                'stock' => 7,
            ],
            [
                'name' => 'Fender Player Jazz Bass',
                'category_id' => 4,
                'price' => 14000000,
                'description' => 'Bass jazz legendaris dengan dual single-coil pickup. Tone versatile untuk berbagai genre.',
                'stock' => 4,
            ],
            [
                'name' => 'Kala KA-15S Soprano Ukulele',
                'category_id' => 5,
                'price' => 750000,
                'description' => 'Ukulele soprano dengan mahogany body. Ringan dan mudah dibawa kemana-mana.',
                'stock' => 25,
            ],
            [
                'name' => 'Epiphone DR-100 Acoustic',
                'category_id' => 1,
                'price' => 1650000,
                'description' => 'Dreadnought acoustic dengan spruce top. Suara bold dan cocok untuk strumming.',
                'stock' => 12,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('✓ Products seeded');

        // ============================================================
        // BANNERS
        // ============================================================

        Banner::create([
            'title' => 'Selamat Datang di Katalog Gitar',
            'image' => 'banners/default-banner-1.jpg',
            'link' => '/products',
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Promo Gitar Akustik',
            'image' => 'banners/default-banner-2.jpg',
            'link' => '/categories/gitar-akustik',
            'is_active' => true,
        ]);

        $this->command->info('✓ Banners seeded');

        // ============================================================
        // TESTIMONIALS
        // ============================================================

        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'testimony' => 'Gitar yang saya beli berkualitas sangat bagus dan harganya terjangkau. Pengiriman juga cepat. Sangat recommended!',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahayu',
                'testimony' => 'Pelayanannya ramah dan responsif. Saya konsultasi dulu sebelum beli dan dibantu dengan baik. Terima kasih Katalog Gitar!',
                'is_active' => true,
            ],
            [
                'name' => 'Ahmad Ridwan',
                'testimony' => 'Sudah 3 kali beli gitar di sini dan selalu puas. Kualitas terjamin dan original. Mantap!',
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        $this->command->info('✓ Testimonials seeded');

        $this->command->info('');
        $this->command->info('🎸 Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('Login credentials:');
        $this->command->info('  Admin: admin@gitarkatalog.com / password123');
    }
}
