<?php

namespace App\Http\Requests;

use App\Models\Buku;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertBukuRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'classification_mode' => $this->input('classification_mode', 'auto'),
            'is_recommended' => $this->boolean('is_recommended'),
            'is_featured' => $this->boolean('is_featured'),
            'remove_cover' => $this->boolean('remove_cover'),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $buku = $this->route('buku');
        $noDocument = $buku instanceof Buku ? $buku->getKey() : $buku;

        return [
            'kode_panggil' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('buku', 'kode_panggil')->ignore($noDocument, 'no_document'),
            ],
            'judul' => ['required', 'string', 'max:255'],
            'judul_pararel' => ['nullable', 'string', 'max:255'],
            'judul_lain' => ['nullable', 'string', 'max:255'],
            'penulis' => ['nullable', 'string', 'max:255'],
            'penulis_badan' => ['nullable', 'string', 'max:255'],
            'pertanggungjawaban' => ['nullable', 'string', 'max:255'],
            'pertanggungjawaban_pararel' => ['nullable', 'string', 'max:255'],
            'badan_lain' => ['nullable', 'string', 'max:255'],
            'konferensi' => ['nullable', 'string', 'max:255'],
            'nama_penerbit' => ['nullable', 'string', 'max:255'],
            'lokasi_penerbit' => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'integer', 'digits:4', 'min:1000', 'max:'.now()->year],
            'edisi' => ['nullable', 'string', 'max:100'],
            'seri' => ['nullable', 'string', 'max:100'],
            'kategori' => ['required', Rule::in(['Buku', 'Jurnal', 'Tugas Akhir'])],
            'subyek' => ['nullable', 'string', 'max:255'],
            'bahasa_teks' => ['nullable', 'string', 'max:255'],
            'media_dokumen' => ['nullable', 'string', 'max:100'],
            'jenis_dokumen' => ['nullable', 'string', 'max:100'],
            'lokasi_dokumen' => ['nullable', 'string', 'max:255'],
            'buku_sumbangan' => ['required', Rule::in(['Ya', 'Tidak'])],
            'deskripsi_fisik' => ['nullable', 'string', 'max:255'],
            'resensi' => ['nullable', 'string', 'max:255'],
            'catatan_umum' => ['nullable', 'string'],
            'catatan_isi' => ['nullable', 'string'],
            'abstrak' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'string',
                'min:80',
                'max:20000',
            ],
            'classification_mode' => ['required', Rule::in(['auto', 'manual'])],
            'klasifikasi_id' => ['nullable', 'required_if:classification_mode,manual', 'integer', 'exists:klasifikasi_buku,id'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'is_recommended' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_cover' => ['nullable', 'boolean'],
            'tanggal_ketik' => ['nullable', 'date'],
            'dokumentalis' => ['nullable', 'string', 'max:255'],
            'jumlah_dokumen' => ['required', 'integer', 'min:0'],
        ];
    }
}
