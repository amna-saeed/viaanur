<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Services\LmsDashboardStatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(LmsDashboardStatsService $stats): View
    {
        $summary = $stats->adminSummary();
        $recentStudents = User::where('role', User::ROLE_STUDENT)->latest()->take(5)->get();
        $recentRegs = $stats->recentRegistrations(8);
        $charts = $stats->chartPayload();

        return view('admin.dashboard', [
            'summary' => $summary,
            'stats' => [
                'students' => $summary['total_students'],
                'teachers' => Teacher::count(),
                'admins' => User::where('role', User::ROLE_ADMIN)->count(),
                'recent_students' => $recentStudents,
            ],
            'recentRegistrations' => $recentRegs,
            'charts' => $charts,
            'statsApiUrl' => route('admin.dashboard.api.stats'),
        ]);
    }

    public function apiStats(LmsDashboardStatsService $stats): JsonResponse
    {
        return response()->json($stats->chartPayload());
    }
}
