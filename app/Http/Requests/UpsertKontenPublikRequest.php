<?php

namespace App\Http\Requests;

use App\Models\KontenPublik;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertKontenPublikRequest extends FormRequest
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
            'type' => ['required', Rule::in(array_keys(KontenPublik::TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['nullable', 'string', 'max:30000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:10240'],
            'external_url' => ['nullable', 'string', 'max:255'],
            'event_at' => ['nullable', 'date'],
            'event_end_at' => ['nullable', 'date', 'after_or_equal:event_at'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'remove_image' => ['nullable', 'boolean'],
            'remove_attachment' => ['nullable', 'boolean'],
        ];
    }
}
