<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8',
            'roles'         => 'required|array',
            'provinsi_id'   => 'nullable|exists:provinsi,id',
            'kabupaten_id'  => 'nullable|exists:kabupaten,id',
            'kecamatan_id'  => 'nullable|exists:kecamatan,id',
            'kelurahan_id'  => 'nullable|exists:kelurahan,id',
        ];
    }
}