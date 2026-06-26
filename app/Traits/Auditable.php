<?php

namespace App\Traits;

use App\Services\AuditLogService;

trait Auditable
{
    protected function audit(
        string $action,
        string $description,
        string $module,
        ?int $recordId = null
    ): void {

        app(AuditLogService::class)
            ->log(
                $action,
                $description,
                $module,
                $recordId
            );
    }
}