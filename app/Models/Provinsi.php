<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_provinsi'])]
class Provinsi extends Model {
    protected $table = 'provinsi';
    public function kabupaten() { return $this->hasMany(Kabupaten::class); }
}