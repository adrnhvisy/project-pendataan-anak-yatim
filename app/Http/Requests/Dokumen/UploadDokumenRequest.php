<?php

namespace App\Http\Requests\Dokumen;

use Illuminate\Foundation\Http\FormRequest;

class UploadDokumenRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'kategori_dok_id' => 'required|exists:kategori_dokumen,id',
            'dokumen'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ];
    }
}