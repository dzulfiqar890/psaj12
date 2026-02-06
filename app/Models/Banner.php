<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Model Banner
 * 
 * Mengelola data banner untuk tampilan homepage.
 * 
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string|null $link
 * @property bool $is_active
 */
class Banner extends Model
{
    use HasFactory;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'image',
        'link',
        'is_active',
    ];

    /**
     * Casting atribut ke tipe tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
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
     * Scope untuk filter banner aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
