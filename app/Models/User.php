<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * Model User
 * 
 * Mengelola data pengguna admin.
 * Mendukung soft deletes dan autentikasi API via Sanctum.
 * 
 * @property int $id
 * @property string|null $no_telephone
 * @property string $username
 * @property string $password
 * @property string|null $image
 * @property string $email
 * @property bool $is_admin
 * @property string|null $google_id
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'no_telephone',
        'username',
        'password',
        'image',
        'email',
        'is_admin',
        'google_id',
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
     * Atribut yang disembunyikan dari serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casting atribut ke tipe tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
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
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
