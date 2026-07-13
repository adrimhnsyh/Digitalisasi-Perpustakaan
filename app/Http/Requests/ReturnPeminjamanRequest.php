<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'details_kembali' => ['required', 'array', 'min:1', 'max:20'],
            'details_kembali.*' => ['required', 'integer', 'distinct'],
        ];
    }
}
