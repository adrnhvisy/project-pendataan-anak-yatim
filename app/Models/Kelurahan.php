<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['kecamatan_id', 'nama_kelurahan', 'kode_pos'])]
class Kelurahan extends Model {
    protected $table = 'kelurahan';
    public function kecamatan() { return $this->belongsTo(Kecamatan::class); }
    public function users() { return $this->hasMany(User::class); }
    public function alamat() { return $this->hasMany(Alamat::class); }
    public function anak() { return $this->hasMany(Anak::class); }
    public function provinsi(){return $this->hasOneThrough(Provinsi::class,Kecamatan::class);}
}