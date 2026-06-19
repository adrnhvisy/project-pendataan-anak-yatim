<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['anak_id', 'nama', 'nik', 'hubungan_dengan_anak', 'pekerjaan', 'alamat_id'])]
class Wali extends Model {
    protected $table = 'wali';
    public function anak() { return $this->belongsTo(Anak::class); }
    public function alamat() { return $this->belongsTo(Alamat::class); }
}