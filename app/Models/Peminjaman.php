<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $primaryKey = 'id_peminjaman';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'no_anggota',
        'tanggal_pinjam',
        'tanggal_kembali',
        'reminder_sent_at',
    ];

    protected $appends = ['status', 'is_terlambat'];

    /**
     * Relasi ke Anggota
     * Foreign Key: no_anggota | Local Key: no_anggota
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'no_anggota', 'no_anggota');
    }

    /**
     * Relasi ke Detail Peminjaman
     * Menggunakan nama 'detailPeminjaman' agar sinkron dengan DashboardController
     */
    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
            'reminder_sent_at' => 'datetime',
        ];
    }

    /**
     * Accessor Status Virtual
     * Logika: Jika ada salah satu item berstatus 'Dipinjam', maka transaksi dianggap 'Dipinjam'.
     * Jika semua sudah 'Dikembalikan', maka status transaksi menjadi 'Dikembalikan'.
     */
    public function getStatusAttribute()
    {
        $details = $this->relationLoaded('detailPeminjaman')
            ? $this->detailPeminjaman
            : $this->detailPeminjaman()->get();

        return $details->contains('status_item', 'Dipinjam') ? 'Dipinjam' : 'Dikembalikan';
    }

    public function getIsTerlambatAttribute(): bool
    {
        return $this->status === 'Dipinjam'
            && $this->tanggal_kembali !== null
            && today()->greaterThan($this->tanggal_kembali);
    }
}
