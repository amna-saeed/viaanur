<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\LeaveRequest;
use App\Models\LmsEnrollment;
use App\Models\StudentLessonAttendance;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminAttendanceService
{
    private function lectureAttendanceTableExists(): bool
    {
        return Schema::hasTable('student_lesson_attendances');
    }

    private function attendanceRecordsTableExists(): bool
    {
        return Schema::hasTable('attendance_records');
    }

    private function leaveRequestsTableExists(): bool
    {
        return Schema::hasTable('leave_requests');
    }

    /**
     * @param  Collection<int, int>|array<int, int>  $userIds
     * @return Collection<int|string, int>
     */
    private function attendedLessonCountsByUser($userIds): Collection
    {
        $userIds = collect($userIds);

        if (! $this->lectureAttendanceTableExists() || $userIds->isEmpty()) {
            return collect();
        }

        return StudentLessonAttendance::query()
            ->whereIn('user_id', $userIds)
            ->whereNotNull('attended_at')
            ->selectRaw('user_id, count(*) as cnt')
            ->groupBy('user_id')
            ->pluck('cnt', 'user_id');
    }
    /**
     * @return array<string, int|float|null>
     */
    public function overviewStats(): array
    {
        $studentIds = User::query()
            ->where('role', User::ROLE_STUDENT)
            ->pluck('id');

        $studentCount = $studentIds->count();

        if ($studentCount === 0) {
            return [
                'student_count' => 0,
                'avg_profile_rate' => null,
                'lecture_assigned_total' => 0,
                'lecture_attended_total' => 0,
                'lecture_rate' => null,
                'present_count' => 0,
                'absent_count' => 0,
                'late_count' => 0,
                'excused_count' => 0,
                'pending_leave_count' => 0,
            ];
        }

        $assignedByUser = $this->assignedLessonCounts($studentIds);
        $attendedByUser = $this->attendedLessonCountsByUser($studentIds);

        $totalAssigned = (int) $assignedByUser->sum();
        $totalAttended = (int) $attendedByUser->sum();

        $recordStats = $this->attendanceRecordsTableExists()
            ? AttendanceRecord::query()
                ->whereIn('user_id', $studentIds)
                ->selectRaw('status, count(*) as cnt')
                ->groupBy('status')
                ->pluck('cnt', 'status')
            : collect();

        return [
            'student_count' => $studentCount,
            'avg_profile_rate' => round((float) User::query()
                ->where('role', User::ROLE_STUDENT)
                ->avg('attendance_percentage'), 1),
            'lecture_assigned_total' => $totalAssigned,
            'lecture_attended_total' => $totalAttended,
            'lecture_rate' => $totalAssigned > 0
                ? round($totalAttended / $totalAssigned * 100, 1)
                : null,
            'present_count' => (int) ($recordStats[AttendanceRecord::STATUS_PRESENT] ?? 0),
            'absent_count' => (int) ($recordStats[AttendanceRecord::STATUS_ABSENT] ?? 0),
            'late_count' => (int) ($recordStats[AttendanceRecord::STATUS_LATE] ?? 0),
            'excused_count' => (int) ($recordStats[AttendanceRecord::STATUS_EXCUSED] ?? 0),
            'pending_leave_count' => $this->leaveRequestsTableExists()
                ? LeaveRequest::query()
                    ->where('status', LeaveRequest::STATUS_PENDING)
                    ->count()
                : 0,
        ];
    }

    public function paginatedStudents(Request $request): LengthAwarePaginator
    {
        $query = User::query()
            ->with('studentProfile:id,user_id,student_id_number')
            ->where('role', User::ROLE_STUDENT);

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($qry) use ($term) {
                $qry->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhereHas('studentProfile', function ($profileQuery) use ($term) {
                        $profileQuery->where('student_id_number', 'like', "%{$term}%");
                    });
            });
        }

        $rateFilter = $request->get('rate');
        if ($rateFilter === 'good') {
            $query->where('attendance_percentage', '>=', 80);
        } elseif ($rateFilter === 'fair') {
            $query->whereBetween('attendance_percentage', [60, 79.99]);
        } elseif ($rateFilter === 'risk') {
            $query->where(function ($qry) {
                $qry->where('attendance_percentage', '<', 60)
                    ->orWhereNull('attendance_percentage');
            });
        }

        $sort = $request->get('sort', 'name');
        if ($sort === 'rate') {
            $query->orderByDesc('attendance_percentage')->orderBy('name');
        } else {
            $query->orderBy('name');
        }

        $students = $query->paginate(15)->withQueryString();

        $this->attachAttendanceSummaries($students->getCollection());

        return $students;
    }

    /**
     * @param  Collection<int, User>  $students
     */
    private function attachAttendanceSummaries(Collection $students): void
    {
        if ($students->isEmpty()) {
            return;
        }

        $userIds = $students->pluck('id');

        $assignedByUser = $this->assignedLessonCounts($userIds);
        $attendedByUser = $this->attendedLessonCountsByUser($userIds);

        $recordsByUser = $this->attendanceRecordsTableExists()
            ? AttendanceRecord::query()
                ->whereIn('user_id', $userIds)
                ->orderByDesc('record_date')
                ->get()
                ->groupBy('user_id')
            : collect();

        $pendingLeaveByUser = $this->leaveRequestsTableExists()
            ? LeaveRequest::query()
                ->whereIn('user_id', $userIds)
                ->where('status', LeaveRequest::STATUS_PENDING)
                ->selectRaw('user_id, count(*) as cnt')
                ->groupBy('user_id')
                ->pluck('cnt', 'user_id')
            : collect();

        $students->each(function (User $student) use (
            $assignedByUser,
            $attendedByUser,
            $recordsByUser,
            $pendingLeaveByUser
        ) {
            $student->setAttribute(
                'attendance_summary',
                $this->buildStudentSummary(
                    $student,
                    (int) ($assignedByUser[$student->id] ?? 0),
                    (int) ($attendedByUser[$student->id] ?? 0),
                    $recordsByUser->get($student->id, collect()),
                    (int) ($pendingLeaveByUser[$student->id] ?? 0)
                )
            );
        });
    }

    /**
     * @param  Collection<int, AttendanceRecord>  $records
     * @return array<string, mixed>
     */
    private function buildStudentSummary(
        User $student,
        int $lecturesAssigned,
        int $lecturesAttended,
        Collection $records,
        int $pendingLeave
    ): array {
        $present = $records->where('status', AttendanceRecord::STATUS_PRESENT)->count();
        $absent = $records->where('status', AttendanceRecord::STATUS_ABSENT)->count();
        $late = $records->where('status', AttendanceRecord::STATUS_LATE)->count();
        $excused = $records->where('status', AttendanceRecord::STATUS_EXCUSED)->count();
        $totalDays = $records->count();

        $dailyRate = $totalDays > 0
            ? round(($present + $late + $excused) / $totalDays * 100, 1)
            : ($student->attendance_percentage !== null ? (float) $student->attendance_percentage : null);

        $lectureRate = $lecturesAssigned > 0
            ? round($lecturesAttended / $lecturesAssigned * 100, 1)
            : null;

        $displayRate = $dailyRate ?? $lectureRate ?? ($student->attendance_percentage !== null ? (float) $student->attendance_percentage : null);

        return [
            'daily_rate' => $dailyRate,
            'lecture_rate' => $lectureRate,
            'display_rate' => $displayRate,
            'lectures_assigned' => $lecturesAssigned,
            'lectures_attended' => $lecturesAttended,
            'present_count' => $present,
            'absent_count' => $absent,
            'late_count' => $late,
            'excused_count' => $excused,
            'total_days' => $totalDays,
            'pending_leave_count' => $pendingLeave,
            'status_band' => $this->statusBand($displayRate),
            'last_record_date' => optional($records->first())->record_date,
        ];
    }

    private function statusBand(?float $rate): string
    {
        if ($rate === null) {
            return 'no-data';
        }
        if ($rate >= 80) {
            return 'good';
        }
        if ($rate >= 60) {
            return 'fair';
        }

        return 'at-risk';
    }

    /**
     * @param  Collection<int, int>|array<int, int>  $userIds
     * @return Collection<int|string, int>
     */
    private function assignedLessonCounts($userIds): Collection
    {
        $userIds = collect($userIds);

        if ($userIds->isEmpty()) {
            return collect();
        }

        return DB::table('lms_enrollments')
            ->join('lessons', 'lessons.course_id', '=', 'lms_enrollments.course_id')
            ->where('lms_enrollments.status', LmsEnrollment::STATUS_APPROVED)
            ->whereIn('lms_enrollments.user_id', $userIds)
            ->selectRaw('lms_enrollments.user_id as user_id, count(distinct lessons.id) as cnt')
            ->groupBy('lms_enrollments.user_id')
            ->pluck('cnt', 'user_id');
    }
}
