<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // PENTING: Untuk fungsi otentikasi
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // Memastikan model ini dapat digunakan untuk login
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable (kolom yang boleh diisi melalui mass assignment).
     * Kolom 'name', 'email', dan 'password' harus ada di sini.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization (kolom yang disembunyikan saat diubah menjadi array/JSON).
     * 'password' dan 'remember_token' wajib disembunyikan.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->is_active && $this->role === 'admin';
    }
}
