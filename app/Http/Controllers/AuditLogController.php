<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        // Eager loading relasi 'user' agar tidak membebani database
        $logs = AuditLog::with('user')->latest()->paginate(20);
        
        return view('pages.superadmin.audit.index', compact('logs'));
    }
}