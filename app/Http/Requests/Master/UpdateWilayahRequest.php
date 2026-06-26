<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWilayahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Sesuaikan validasi tergantung model mana yang sedang diupdate
        // Contoh ini untuk update nama (Kelurahan/Kecamatan/Kabupaten/Provinsi)
        return [
            'nama_wilayah' => [
                'required', 
                'string', 
                'max:255',
                // Contoh: mengabaikan nama wilayah milik record ini sendiri
                Rule::unique('kelurahan', 'nama_kelurahan')->ignore($this->route('wilayah')) 
            ],
            'kode_pos' => 'nullable|digits:5',
        ];
    }
}