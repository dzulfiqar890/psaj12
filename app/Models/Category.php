<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Model Category
 * 
 * Mengelola data kategori produk gitar.
 * Mendukung soft deletes dan auto-generate slug.
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $slug
 */
class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'created_by',
    ];

    /**
     * Boot method untuk event model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug saat creating
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name);
            }
        });

        // Auto-update slug saat updating jika nama berubah
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name, $category->id);
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
     * Relationship: Category dibuat oleh User tertentu.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: Category memiliki banyak Product.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get route key name untuk route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
