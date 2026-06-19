<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['provinsi_id', 'nama_kabupaten'])]
class Kabupaten extends Model {
    protected $table = 'kabupaten';
    public function provinsi() { return $this->belongsTo(Provinsi::class); }
    public function kecamatan() { return $this->hasMany(Kecamatan::class); }
}