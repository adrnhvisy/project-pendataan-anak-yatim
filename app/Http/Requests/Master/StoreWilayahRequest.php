<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreWilayahRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama_provinsi'  => 'required|string|unique:provinsi,nama_provinsi',
            'nama_kabupaten' => 'required|string',
            'nama_kecamatan' => 'required|string',
            'nama_kelurahan' => 'required|string',
            'kode_pos'       => 'required|digits:5',
        ];
    }
}