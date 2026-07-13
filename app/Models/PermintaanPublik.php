<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanPublik extends Model
{
    use HasFactory;

    public const TYPES = [
        'usulan_buku' => 'Usulan Buku',
        'tanya_pustakawan' => 'Tanya Pustakawan',
        'aspirasi' => 'Aspirasi',
        'tantangan_baca' => 'Tantangan Baca',
    ];

    public const STATUSES = [
        'baru' => 'Baru',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'ditolak' => 'Ditolak',
    ];

    protected $table = 'permintaan_publik';

    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'member_number',
        'subject',
        'message',
        'metadata',
        'status',
        'admin_notes',
        'handled_by',
        'handled_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'handled_at' => 'datetime',
        ];
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
