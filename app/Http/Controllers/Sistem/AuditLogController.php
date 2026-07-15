<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{

    public function index()
    {
        $logs = AuditLog::with('user')->latest()->paginate(10);
        return view('pages.audit.index', compact('logs'));
    }
}