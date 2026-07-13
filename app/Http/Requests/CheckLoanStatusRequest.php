<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckLoanStatusRequest extends FormRequest
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
            'no_identitas' => ['required', 'string', 'max:50'],
            'phone_last_four' => ['required', 'digits:4'],
        ];
    }
}
