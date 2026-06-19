<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'no_registrasi', 'nama_lengkap', 'no_kk', 'nik', 'tempat_lahir', 
    'tanggal_lahir', 'jenis_kelamin', 'status_anak', 'no_rekening', 
    'status_data', 'alamat_domisili_id', 'kelurahan_id', 'created_by'
])]
class Anak extends Model {
    protected $table = 'anak';
    public function alamat_domisili() { return $this->belongsTo(Alamat::class, 'alamat_domisili_id'); }
    public function kelurahan() { return $this->belongsTo(Kelurahan::class); }
    public function pembuat_data() { return $this->belongsTo(User::class, 'created_by'); }
    public function orang_tua() { return $this->hasMany(OrangTua::class); }
    public function wali() { return $this->hasMany(Wali::class); }
    public function dokumen() { return $this->hasMany(DokumenAnak::class); }
    public function histori_status() { return $this->hasMany(StatusHistori::class); }
}