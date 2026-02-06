<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Testimonial
 * 
 * Mengelola data testimoni pelanggan.
 * 
 * @property int $id
 * @property string $name
 * @property string $testimony
 * @property bool $is_active
 */
class Testimonial extends Model
{
    use HasFactory;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'testimony',
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
     * Scope untuk filter testimoni aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
