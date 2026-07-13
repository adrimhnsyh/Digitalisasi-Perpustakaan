<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlasifikasiBuku extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_buku';

    protected $fillable = [
        'nama',
        'slug',
        'kode',
        'program_studi',
        'deskripsi',
        'keywords',
        'warna',
        'ikon',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function buku()
    {
        return $this->hasMany(Buku::class, 'klasifikasi_id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
