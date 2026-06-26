<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(): View
    {
        $statistics = $this->dashboardService->statistics();

        return view(
            'pages.dashboard.index',
            compact('statistics')
        );
    }
}