<?php

namespace App\Http\Requests;

use App\Models\Anggota;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertAnggotaRequest extends FormRequest
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
        $anggota = $this->route('anggota');
        $noAnggota = $anggota instanceof Anggota ? $anggota->getKey() : $anggota;

        return [
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'no_telp' => [
                'required',
                'string',
                'max:20',
                Rule::unique('anggota', 'no_telp')->ignore($noAnggota, 'no_anggota'),
            ],
            'status' => ['required', Rule::in(['Mahasiswa', 'Dosen', 'Dosen Luar', 'Non Aktif'])],
            'no_identitas' => ['nullable', 'string', 'max:50'],
            'email' => [
                'nullable',
                'email:rfc',
                'max:255',
                Rule::unique('anggota', 'email')->ignore($noAnggota, 'no_anggota'),
            ],
            'reminder_opt_in' => ['nullable', 'boolean'],
        ];
    }
}
