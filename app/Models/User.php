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
 * Mengelola data pengguna dengan role-based access control.
 * Mendukung soft deletes dan autentikasi API via Sanctum.
 * 
 * @property int $id
 * @property string|null $no_telephone
 * @property string $username
 * @property string $password
 * @property string|null $image
 * @property string $email
 * @property string $role
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
        'role',
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
     * Relationship: User memiliki banyak Contact.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Scope untuk filter user berdasarkan role customer.
     */
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    /**
     * Scope untuk filter user berdasarkan role admin.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}
