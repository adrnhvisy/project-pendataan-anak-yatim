<?php

namespace App\Http\Requests\Anak;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnakRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => ['required', 'digits:16', Rule::unique('anak', 'nik')->ignore($this->anak)],
            'no_kk'         => 'required|digits:16',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_anak'   => 'required|in:Yatim,Piatu,Yatim Piatu',
            'no_rekening'   => 'nullable|string|max:30',
            'foto_anak'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat_lengkap'=> 'required|string',
            'rt'            => 'required|digits:3',
            'rw'            => 'required|digits:3',
            'kelurahan_id'  => 'required|exists:kelurahan,id',
        ];
    }
}