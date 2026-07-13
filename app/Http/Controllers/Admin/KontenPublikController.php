<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertKontenPublikRequest;
use App\Models\KontenPublik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KontenPublikController extends Controller
{
    public function index(Request $request): View
    {
        $type = trim((string) $request->query('type', ''));
        $status = trim((string) $request->query('status', ''));

        $contents = KontenPublik::query()
            ->when(isset(KontenPublik::TYPES[$type]), fn ($query) => $query->where('type', $type))
            ->when($status === 'published', fn ($query) => $query->where('is_published', true))
            ->when($status === 'draft', fn ($query) => $query->where('is_published', false))
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.konten.index', compact('contents', 'type', 'status'));
    }

    public function create(): View
    {
        return view('admin.konten.create');
    }

    public function store(UpsertKontenPublikRequest $request): RedirectResponse
    {
        $data = $this->prepareData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['created_by'] = $request->user()->getKey();

        KontenPublik::create($data);

        return to_route('admin.konten.index')->with('success', 'Konten publik berhasil dibuat.');
    }

    public function edit(KontenPublik $konten): View
    {
        return view('admin.konten.edit', compact('konten'));
    }

    public function update(UpsertKontenPublikRequest $request, KontenPublik $konten): RedirectResponse
    {
        $konten->update($this->prepareData($request, $konten));

        return to_route('admin.konten.index')->with('success', 'Konten publik berhasil diperbarui.');
    }

    public function destroy(KontenPublik $konten): RedirectResponse
    {
        $this->deleteStoredFile($konten->image_path);
        $this->deleteStoredFile($konten->attachment_path);
        $konten->delete();

        return to_route('admin.konten.index')->with('success', 'Konten publik berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function prepareData(UpsertKontenPublikRequest $request, ?KontenPublik $content = null): array
    {
        $data = $request->validated();
        unset($data['image'], $data['attachment'], $data['remove_image'], $data['remove_attachment']);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['published_at'] = $data['is_published']
            ? ($content?->published_at ?? now())
            : null;

        if ($request->hasFile('image')) {
            $this->deleteStoredFile($content?->image_path);
            $data['image_path'] = $request->file('image')->store('content/images', 'public');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteStoredFile($content?->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('attachment')) {
            $this->deleteStoredFile($content?->attachment_path);
            $data['attachment_path'] = $request->file('attachment')->store('content/attachments', 'public');
        } elseif ($request->boolean('remove_attachment')) {
            $this->deleteStoredFile($content?->attachment_path);
            $data['attachment_path'] = null;
        }

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'konten';
        $slug = $base;
        $suffix = 2;

        while (KontenPublik::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function deleteStoredFile(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
