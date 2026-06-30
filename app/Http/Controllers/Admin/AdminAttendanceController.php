<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAttendanceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAttendanceController extends Controller
{
    public function index(Request $request, AdminAttendanceService $attendanceService): View
    {
        return view('admin.attendance.index', [
            'overview' => $attendanceService->overviewStats(),
            'students' => $attendanceService->paginatedStudents($request),
        ]);
    }
}
