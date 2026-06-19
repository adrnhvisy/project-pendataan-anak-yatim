<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['anak_id', 'jenis_orang_tua', 'nama', 'nik', 'status_hidup', 'pekerjaan', 'alamat_id'])]
class OrangTua extends Model {
    protected $table = 'orang_tua';
    public function anak() { return $this->belongsTo(Anak::class); }
    public function alamat() { return $this->belongsTo(Alamat::class); }
}