<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'anggota_id' => ['required', 'integer', Rule::exists('anggota', 'no_anggota')],
            'buku_dipinjam' => ['required', 'array', 'min:1', 'max:'.config('library.loan_max_items')],
            'buku_dipinjam.*' => ['required', 'integer', 'distinct', Rule::exists('buku', 'no_document')],
        ];
    }
}
