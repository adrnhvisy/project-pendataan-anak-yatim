<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'no_registrasi', 'nama_lengkap', 'no_kk', 'nik', 'tempat_lahir', 
    'tanggal_lahir', 'jenis_kelamin', 'status_anak', 'no_rekening', 'catatan',
    'status_data', 'alamat_domisili_id', 'created_by'
])]
class Anak extends Model {
    protected $table = 'anak';
    public function alamatDomisili() { return $this->belongsTo(Alamat::class, 'alamat_domisili_id'); }
    public function pembuatData() { return $this->belongsTo(User::class, 'created_by'); }
    public function orangTua() { return $this->hasMany(OrangTua::class); }
    public function wali() { return $this->hasOne(Wali::class); }
    public function dokumen() { return $this->hasMany(DokumenAnak::class); }
    public function historiStatus() { return $this->hasMany(StatusHistori::class); }
}