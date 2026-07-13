<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KontenPublik extends Model
{
    use HasFactory;

    public const TYPES = [
        'berita' => 'Berita',
        'agenda' => 'Agenda',
        'karya' => 'Karya Mahasiswa',
        'panduan' => 'Panduan',
        'faq' => 'FAQ',
        'tantangan' => 'Tantangan Baca',
        'profil' => 'Profil Pustakawan',
        'unduhan' => 'Unduhan',
    ];

    protected $table = 'konten_publik';

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'body',
        'image_path',
        'attachment_path',
        'external_url',
        'event_at',
        'event_end_at',
        'metadata',
        'is_published',
        'is_featured',
        'sort_order',
        'published_at',
        'created_by',
    ];

    protected $appends = ['image_url', 'attachment_url', 'type_label'];

    protected function casts(): array
    {
        return [
            'event_at' => 'datetime',
            'event_end_at' => 'datetime',
            'published_at' => 'datetime',
            'metadata' => 'array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeType(Builder $query, string $type): void
    {
        $query->where('type', $type);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->publicFileUrl($this->image_path);
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->publicFileUrl($this->attachment_path);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    private function publicFileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->exists($path)
            ? route('media.show', ['path' => $path])
            : null;
    }
}
