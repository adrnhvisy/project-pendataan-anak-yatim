<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['anak_id', 'kategori_dok_id', 'file_path', 'status_verifikasi'])]
class DokumenAnak extends Model {
    protected $table = 'dokumen_anak';
    public function anak() { return $this->belongsTo(Anak::class); }
    public function kategori_dokumen() { return $this->belongsTo(KategoriDokumen::class, 'kategori_dok_id'); }
}
