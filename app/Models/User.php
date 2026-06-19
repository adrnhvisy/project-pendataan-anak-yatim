<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'email', 'password', 'role', 'kelurahan_id'])]
class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'users';
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }
    public function kelurahan() { return $this->belongsTo(Kelurahan::class); }
    public function anak_didaftarkan() { return $this->hasMany(Anak::class, 'created_by'); }
    public function histori_dibuat() { return $this->hasMany(StatusHistori::class, 'created_by'); }
    public function audit_logs() { return $this->hasMany(AuditLog::class); }
}