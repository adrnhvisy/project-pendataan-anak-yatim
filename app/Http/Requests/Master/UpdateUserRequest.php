<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            
            // Email unik tapi abaikan ID user yang sedang diupdate
            'email' => [
                'required', 
                'email', 
                'max:255', 
                Rule::unique('users', 'email')->ignore($this->route('user'))
            ],
            
            // Password opsional (hanya diisi jika ingin ubah)
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            
            'roles'         => ['required', 'array'],
            'roles.*'       => ['exists:roles,name'],
            
            // Wilayah (opsional untuk user)
            'provinsi_id'   => ['nullable', 'exists:provinsi,id'],
            'kabupaten_id'  => ['nullable', 'exists:kabupaten,id'],
            'kecamatan_id'  => ['nullable', 'exists:kecamatan,id'],
            'kelurahan_id'  => ['nullable', 'exists:kelurahan,id'],
            
            'is_active'     => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.min' => 'Password minimal harus 8 karakter.',
        ];
    }
}