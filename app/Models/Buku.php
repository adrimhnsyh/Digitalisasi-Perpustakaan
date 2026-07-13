<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Buku extends Model
{
    use HasFactory;

    // Menetapkan nama tabel secara eksplisit
    protected $table = 'buku';

    // Menetapkan Primary Key yang bukan default 'id'
    protected $primaryKey = 'no_document';

    // Primary Key adalah auto-incrementing integer (bigIncrements)
    public $incrementing = true;

    protected $keyType = 'int';

    // Kolom-kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        // Metadata
        'kode_panggil',
        'judul',
        'judul_pararel',
        'judul_lain',
        'penulis',
        'penulis_badan',
        'pertanggungjawaban',
        'pertanggungjawaban_pararel',
        'badan_lain',
        'konferensi',
        'nama_penerbit',
        'lokasi_penerbit',
        'tahun_terbit',
        'edisi',
        'seri',

        // Klasifikasi & Deskripsi
        'kategori',
        'subyek',
        'bahasa_teks',
        'media_dokumen',
        'jenis_dokumen',
        'lokasi_dokumen',
        'buku_sumbangan', // ENUM
        'deskripsi_fisik',
        'resensi',
        'catatan_umum',
        'catatan_isi',
        'abstrak',

        // Klasifikasi berbasis isi
        'klasifikasi_id',
        'classification_score',
        'classification_keywords',
        'classification_source',
        'cover_image',
        'external_url',
        'is_recommended',
        'is_featured',

        // Administrasi
        'tanggal_ketik',
        'dokumentalis',

        // Stok
        'jumlah_dokumen',
        'jumlah_tersedia',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_ketik' => 'date',
            'tahun_terbit' => 'integer',
            'jumlah_dokumen' => 'integer',
            'jumlah_tersedia' => 'integer',
            'classification_score' => 'float',
            'classification_keywords' => 'array',
            'is_recommended' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    // ===============================================
    // RELASI
    // ===============================================

    /**
     * Buku memiliki banyak detail peminjaman.
     * Ini adalah bagian dari relasi One-to-Many.
     */
    public function detailPeminjaman()
    {
        // Ganti Model DetailPeminjaman jika Anda menamainya berbeda
        return $this->hasMany(DetailPeminjaman::class, 'no_document', 'no_document');
    }

    public function klasifikasi()
    {
        return $this->belongsTo(KlasifikasiBuku::class, 'klasifikasi_id');
    }

    public function scopeAvailable(Builder $query): void
    {
        $query->where('jumlah_tersedia', '>', 0);
    }

    public function scopeRecommended(Builder $query): void
    {
        $query->where('is_recommended', true);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        if (str_starts_with($this->cover_image, 'images/')) {
            return asset($this->cover_image);
        }

        return Storage::disk('public')->exists($this->cover_image)
            ? route('media.show', ['path' => $this->cover_image])
            : null;
    }
}
