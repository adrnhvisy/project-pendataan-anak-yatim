<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['key', 'value', 'tipe', 'keterangan'])]
class PengaturanSistem extends Model
{
    protected $table = 'pengaturan_sistem';
}