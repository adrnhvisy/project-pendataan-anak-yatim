<?php

namespace App\Http\Requests\Anak;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnakRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|digits:16|unique:anak,nik',
            'no_kk'        => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir'=> 'required|date',
            'jenis_kelamin'=> 'required|in:Laki-laki,Perempuan',
            'status_anak'  => 'required|in:Yatim,Piatu,Yatim Piatu',
            'no_rekening'  => 'nullable|string|max:30',
            'foto_anak' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            
            // Alamat
            'alamat_lengkap'=> 'required|string',
            'rt'            => 'required|digits:3',
            'rw'            => 'required|digits:3',
            'kelurahan_id'  => 'required|exists:kelurahan,id',

            // Orang Tua
            'nama_ayah'         => 'required|string',
            'nik_ayah'          => 'required|digits:16',
            'status_hidup_ayah' => 'required|in:Hidup,Meninggal',
            'nama_ibu'          => 'required|string',
            'nik_ibu'           => 'required|digits:16',
            'status_hidup_ibu'  => 'required|in:Hidup,Meninggal',

            // Wali (Opsional)
            'nama_wali'      => 'nullable|string',
            'nik_wali'       => 'nullable|required_with:nama_wali|digits:16',
            'hubungan_wali'  => 'nullable|required_with:nama_wali|string',
        ];
    }
}