<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditLogService
{
    public function log(
        string $action,
        string $description,
        string $module,
        ?int $recordId = null
    ) {

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'module' => $module,
            'record_id' => $recordId,
            'ip_address' => request()->ip(),
        ]);
    }
}