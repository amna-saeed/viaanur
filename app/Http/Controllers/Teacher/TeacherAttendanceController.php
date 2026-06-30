<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\TeacherAttendanceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherAttendanceController extends Controller
{
    public function index(Request $request, TeacherAttendanceService $attendanceService): View
    {
        return view('teacher.attendance.index', [
            'overview' => $attendanceService->overviewStats(),
            'students' => $attendanceService->paginatedStudents($request),
        ]);
    }
}
