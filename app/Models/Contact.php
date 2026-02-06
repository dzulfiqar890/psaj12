<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Contact
 * 
 * Mengelola data pesan/kontak dari customer ke admin.
 * 
 * @property int $id
 * @property int $user_id
 * @property string $subject
 * @property string $message
 * @property string $status
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
    ];

    /**
     * Relationship: Contact belongs to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter pesan berdasarkan status.
     */
    public function scopeByStatus($query, ?string $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope untuk filter pesan pending.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk filter pesan yang sudah dibaca.
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope untuk filter pesan yang sudah dibalas.
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Cek apakah pesan pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Tandai pesan sebagai sudah dibaca.
     */
    public function markAsRead(): bool
    {
        return $this->update(['status' => 'read']);
    }

    /**
     * Tandai pesan sebagai sudah dibalas.
     */
    public function markAsReplied(): bool
    {
        return $this->update(['status' => 'replied']);
    }
}
