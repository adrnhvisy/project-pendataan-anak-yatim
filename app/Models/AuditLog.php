<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'action', 'description', 'ip_address'])]
class AuditLog extends Model {
    protected $table = 'audit_logs';
    public function user() { return $this->belongsTo(User::class); }
}