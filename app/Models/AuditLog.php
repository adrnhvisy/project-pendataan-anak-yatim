<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id','module','action','record_id','description','ip_address'])]
class AuditLog extends Model {
    protected $table = 'audit_logs';
    public function user() { return $this->belongsTo(User::class); }
}