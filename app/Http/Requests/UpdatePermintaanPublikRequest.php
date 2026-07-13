<?php

namespace App\Http\Requests;

use App\Models\PermintaanPublik;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermintaanPublikRequest extends FormRequest
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
            'status' => ['required', Rule::in(array_keys(PermintaanPublik::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
