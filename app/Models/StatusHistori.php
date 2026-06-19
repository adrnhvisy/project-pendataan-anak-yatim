<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['anak_id', 'status_anak', 'tanggal', 'keterangan', 'created_by'])]
class StatusHistori extends Model {
    protected $table = 'status_histori';
    public function anak() { return $this->belongsTo(Anak::class); }
    public function pembuat_histori() { return $this->belongsTo(User::class, 'created_by'); }
}
