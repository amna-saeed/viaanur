<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Services\TeacherAttendanceService;
use App\Services\TeacherScopeService;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function index(
        TeacherScopeService $scope,
        TeacherAttendanceService $attendance
    ): View {
        $teacher = $scope->currentTeacher();
        $overview = $attendance->overviewStats();
        $recentStudents = $scope->studentsQuery()
            ->latest()
            ->take(5)
            ->get();
        $subjects = $scope->subjectsQuery()
            ->orderBy('name')
            ->take(6)
            ->get();
        $subjectCount = $scope->subjectsQuery()->count();

        $pendingLeave = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('leave_requests')) {
            $studentIds = $scope->studentIds();
            if ($studentIds->isNotEmpty()) {
                $pendingLeave = LeaveRequest::query()
                    ->whereIn('user_id', $studentIds)
                    ->where('status', LeaveRequest::STATUS_PENDING)
                    ->count();
            }
        }

        return view('teacher.dashboard', [
            'teacher' => $teacher,
            'overview' => $overview,
            'recentStudents' => $recentStudents,
            'subjects' => $subjects,
            'subjectCount' => $subjectCount,
            'pendingLeave' => $pendingLeave,
        ]);
    }
}
