<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    // Nama tabel sesuai database
    protected $table = 'detail_peminjaman';

    /**
     * Karena tabel ini adalah tabel pivot/detail yang biasanya tidak memiliki
     * AI (Auto Increment) tunggal 'id' di skema Anda, kita set incrementing ke false
     * jika memang tidak ada kolom 'id'. Namun jika ada, biarkan default.
     */
    protected $primaryKey = 'id_peminjaman'; // Mengacu pada salah satu key utama

    public $incrementing = false;

    protected $fillable = [
        'id_peminjaman',
        'no_document',
        'jumlah_pinjam',
        'status_item',
        'tanggal_dikembalikan',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jumlah_pinjam' => 'integer',
            'tanggal_dikembalikan' => 'date',
        ];
    }

    /**
     * Relasi ke Peminjaman (Header)
     * Foreign Key: id_peminjaman
     * Owner Key: id_peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Relasi ke Buku
     * Foreign Key: no_document
     * Owner Key: no_document (Sesuai skema ERD)
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'no_document', 'no_document');
    }
}
