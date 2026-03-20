<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Model Product
 * 
 * Mengelola data produk gitar.
 * Mendukung soft deletes, auto-generate slug, dan WhatsApp link generator.
 * 
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $slug
 * @property float $price
 * @property string|null $description
 * @property string|null $image
 * @property int $stock
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'slug',
        'price',
        'description',
        'image',
        'stock',
        'created_by',
    ];

    /**
     * Atribut yang ditambahkan ke response array/JSON.
     *
     * @var list<string>
     */
    protected $appends = [
        'image_url',
    ];

    /**
     * Casting atribut ke tipe tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * Boot method untuk event model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug saat creating
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        // Auto-update slug saat updating jika nama berubah
        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    /**
     * Generate unique slug dari nama.
     */
    public static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        $query = static::withTrashed()->where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            $query = static::withTrashed()->where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    /**
     * Accessor untuk mendapatkan URL gambar lengkap.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::url($this->image);
    }

    /**
     * Accessor untuk format harga dalam Rupiah.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Cek apakah produk tersedia (stok > 0).
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Generate link WhatsApp untuk pemesanan.
     */
    public function getWhatsAppLink(): string
    {
        $phoneNumber = config('app.whatsapp_admin_number', env('WHATSAPP_ADMIN_NUMBER', '6285747938471'));

        $message = urlencode(
            "Halo Admin, saya ingin memesan {$this->name} dengan harga {$this->formatted_price}. Apakah stok masih tersedia?"
        );

        return "https://wa.me/{$phoneNumber}?text={$message}";
    }

    /**
     * Get pesan stok habis.
     */
    public function getStockMessage(): ?string
    {
        if (!$this->isInStock()) {
            return 'Stok produk sedang habis.';
        }

        return null;
    }

    /**
     * Relationship: Product dibuat oleh User tertentu.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: Product belongs to Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope untuk filter produk yang tersedia.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope untuk search produk berdasarkan nama.
     */
    public function scopeSearch($query, ?string $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%");
        }
        return $query;
    }

    /**
     * Scope untuk filter produk berdasarkan kategori.
     */
    public function scopeByCategory($query, ?int $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Scope untuk filter produk berdasarkan range harga.
     */
    public function scopeByPriceRange($query, ?float $minPrice, ?float $maxPrice)
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * Get route key name untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
