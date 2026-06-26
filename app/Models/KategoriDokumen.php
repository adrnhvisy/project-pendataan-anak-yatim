<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_dokumen', 'is_wajib'])]
class KategoriDokumen extends Model {
    protected $table = 'kategori_dokumen';
    public function dokumenAnak() { return $this->hasMany(DokumenAnak::class, 'kategori_dok_id'); }
}
