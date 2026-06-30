<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name', 'email', 'password', 
    'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 
    'is_active'
])]
class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles, SoftDeletes; 

    protected $table = 'users';
    protected $hidden = ['password', 'remember_token'];
    
    protected function casts(): array { 
        return [
            'email_verified_at' => 'datetime', 
            'password' => 'hashed',
            'is_active' => 'boolean'
        ]; 
    }

    // Relasi Wilayah
    public function provinsi() { return $this->belongsTo(Provinsi::class); }
    public function kabupaten() { return $this->belongsTo(Kabupaten::class); }
    public function kecamatan() { return $this->belongsTo(Kecamatan::class); }
    public function kelurahan() { return $this->belongsTo(Kelurahan::class); }
    public function anakDidaftarkan() { return $this->hasMany(Anak::class, 'created_by'); }
    public function historiDibuat() { return $this->hasMany(StatusHistori::class, 'created_by'); }
    public function auditLogs() { return $this->hasMany(AuditLog::class); }
    public function dokumenDiverifikasi() { return $this->hasMany(DokumenAnak::class, 'verified_by'); }
}