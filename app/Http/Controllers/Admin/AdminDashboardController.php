<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Services\LeaveRequestService;
use App\Services\LmsDashboardStatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(LmsDashboardStatsService $stats, LeaveRequestService $leaveService): View
    {
        $summary = $stats->adminSummary();
        $recentStudents = User::where('role', User::ROLE_STUDENT)->latest()->take(5)->get();
        $recentRegs = $stats->recentRegistrations(4);
        $charts = $stats->chartPayload();
        $pendingLeaveRequests = $leaveService->pendingRequests();
        $leaveAlerts = $leaveService->recentAlerts();

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
            'leaveAlertsApiUrl' => route('admin.dashboard.api.leave-alerts'),
            'pendingLeaveRequests' => $pendingLeaveRequests,
            'leaveAlerts' => $leaveAlerts,
            'leaveAlertsInitial' => $leaveService->alertsPayload(),
            'leaveAlertMinutes' => LeaveRequestService::ALERT_WINDOW_MINUTES,
        ]);
    }

    public function apiStats(LmsDashboardStatsService $stats): JsonResponse
    {
        return response()->json($stats->chartPayload());
    }
}
