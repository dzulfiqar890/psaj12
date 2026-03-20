<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
        'created_by',
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
     * Relationship: Testimoni dibuat oleh User tertentu.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk filter testimoni aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
