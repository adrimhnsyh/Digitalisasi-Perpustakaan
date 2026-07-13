<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    // PENTING: Menggunakan kolom non-standar 'no_anggota' sebagai Primary Key
    protected $primaryKey = 'no_anggota';

    // Asumsi 'no_anggota' di DB adalah BIGINT AUTO INCREMENT
    public $incrementing = true;

    // Jika 'no_anggota' adalah INT/BIGINT
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'status',
        'no_identitas',
        'email',
        'reminder_opt_in',
    ];

    protected function casts(): array
    {
        return [
            'reminder_opt_in' => 'boolean',
        ];
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'no_anggota', 'no_anggota');
    }
}
