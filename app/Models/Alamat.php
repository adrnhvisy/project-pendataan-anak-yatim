<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['alamat_lengkap', 'rt', 'rw', 'kelurahan_id'])]
class Alamat extends Model {
    protected $table = 'alamat';
    public function kelurahan() { return $this->belongsTo(Kelurahan::class); }
    public function anak() { return $this->hasMany(Anak::class, 'alamat_domisili_id'); }
    public function orangTua() { return $this->hasMany(OrangTua::class); }
    public function wali() { return $this->hasMany(Wali::class); }
}
