<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(): View {
        $logs = AuditLog::with('user')->latest()->paginate(20);
        return view('pages.audit.index', compact('logs'));
    }
}