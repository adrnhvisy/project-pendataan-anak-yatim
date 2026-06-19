<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['kabupaten_id', 'nama_kecamatan'])]
class Kecamatan extends Model {
    protected $table = 'kecamatan';
    public function kabupaten() { return $this->belongsTo(Kabupaten::class); }
    public function kelurahan() { return $this->hasMany(Kelurahan::class); }
}