<?php

namespace App\Services;

use App\Models\AttendanceRecord;
use App\Models\Course;
use App\Models\LeaveRequest;
use App\Models\LmsAnnouncement;
use App\Models\LmsClass;
use App\Models\LmsEnrollment;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
class LmsDashboardStatsService
{
    public function adminSummary(): array
    {
        return [
            'total_students' => User::where('role', User::ROLE_STUDENT)->count(),
            'total_teachers' => Teacher::count(),
            'total_courses' => Course::count(),
            'active_classes' => LmsClass::where('is_active', true)->count(),
            'total_enrollments' => LmsEnrollment::approved()->count(),
        ];
    }

    public function recentRegistrations(int $limit = 8): Collection
    {
        return User::query()
            ->whereIn('role', [User::ROLE_STUDENT, User::ROLE_TEACHER])
            ->latest()
            ->take($limit)
            ->get(['id', 'name', 'email', 'role', 'created_at']);
    }

    /** Students enrolled per course (for charts + cards). */
    public function studentsPerCourse(): array
    {
        return Course::query()
            ->withCount(['enrollments' => fn ($q) => $q->approved()])
            ->orderByDesc('enrollments_count')
            ->get(['id', 'title'])
            ->map(fn ($c) => [
                'label' => $c->title,
                'count' => (int) $c->enrollments_count,
            ])
            ->values()
            ->all();
    }

    /** Last N days: new student registrations per day. */
    public function registrationTrend(int $days = 7): array
    {
        $out = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $day = now()->subDays($i)->startOfDay();
            $out[] = [
                'label' => $day->format('M j'),
                'count' => User::where('role', User::ROLE_STUDENT)
                    ->whereDate('created_at', $day->toDateString())
                    ->count(),
            ];
        }
        return $out;
    }

    public function teacherStudentRatio(): array
    {
        $t = Teacher::count();
        $s = User::where('role', User::ROLE_STUDENT)->count();
        return [
            'labels' => ['Teachers', 'Students'],
            'counts' => [$t, $s],
        ];
    }

    /**
     * New enrollments in the last N days, grouped by course (shown as "subjects" on donut).
     */
    public function newAdmissionsByCourse(int $days = 30): array
    {
        $since = now()->subDays($days)->startOfDay();

        $rows = LmsEnrollment::query()
            ->approved()
            ->where('created_at', '>=', $since)
            ->selectRaw('course_id, count(*) as cnt')
            ->groupBy('course_id')
            ->orderByDesc('cnt')
            ->get();

        $courseIds = $rows->pluck('course_id')->all();
        $titles = $courseIds === []
            ? collect()
            : Course::whereIn('id', $courseIds)->pluck('title', 'id');

        $colors = ['#22c55e', '#3b82f6', '#f97316', '#14b8a6', '#8b5cf6', '#ec4899'];

        $segments = [];
        $total = 0;
        foreach ($rows as $i => $r) {
            $count = (int) $r->cnt;
            $total += $count;
            $segments[] = [
                'label' => $titles[$r->course_id] ?? ('Course #'.$r->course_id),
                'count' => $count,
                'color' => $colors[$i % count($colors)],
            ];
        }

        return [
            'total' => $total,
            'days' => $days,
            'segments' => $segments,
        ];
    }

    public function chartPayload(): array
    {
        return [
            'studentsPerCourse' => $this->studentsPerCourse(),
            'registrationTrend' => $this->registrationTrend(7),
            'teacherStudentRatio' => $this->teacherStudentRatio(),
            'newAdmissions' => $this->newAdmissionsByCourse(30),
            'summary' => $this->adminSummary(),
            'generated_at' => now()->toIso8601String(),
        ];
    }

    public function publishedAnnouncements(int $limit = 5): Collection
    {
        return LmsAnnouncement::published()
            ->latest('published_at')
            ->latest()
            ->take($limit)
            ->get();
    }

    /** Latest submitted quiz attempts for a student dashboard activity feed. */
    public function recentQuizAttempts(User $user, int $limit = 8): Collection
    {
        return $user->quizAttempts()
            ->with(['quiz.course:id,title,slug'])
            ->whereNotNull('submitted_at')
            ->latest('submitted_at')
            ->take($limit)
            ->get();
    }

    /** Latest course enrollments for a student dashboard activity feed. */
    public function recentEnrollments(User $user, int $limit = 5): Collection
    {
        return $user->lmsEnrollments()
            ->approved()
            ->with(['course:id,title,slug'])
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Per-course quiz progress for enrolled courses (mirrors admin student profile logic).
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function enrollmentProgressFor(User $user): Collection
    {
        $enrollments = $user->lmsEnrollments()
            ->approved()
            ->with(['course' => fn ($q) => $q->withCount(['lessons', 'quizzes'])])
            ->orderByDesc('created_at')
            ->get();

        if ($enrollments->isEmpty()) {
            return collect();
        }

        $courseIds = $enrollments->pluck('course_id')->filter()->unique()->values();

        $attemptedByCourse = DB::table('quiz_attempts')
            ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
            ->where('quiz_attempts.user_id', $user->id)
            ->whereNotNull('quiz_attempts.submitted_at')
            ->whereIn('quizzes.course_id', $courseIds)
            ->groupBy('quizzes.course_id')
            ->selectRaw('quizzes.course_id, COUNT(DISTINCT quiz_attempts.quiz_id) as cnt')
            ->pluck('cnt', 'course_id');

        return $enrollments->map(function ($enrollment) use ($attemptedByCourse) {
            $course = $enrollment->course;
            if (! $course) {
                return null;
            }

            $totalQuizzes = (int) $course->quizzes_count;
            $attempted = (int) ($attemptedByCourse[$course->id] ?? 0);
            $progress = $totalQuizzes > 0 ? min(100, (int) round($attempted / $totalQuizzes * 100)) : 0;

            return [
                'enrollment' => $enrollment,
                'course' => $course,
                'lessons_count' => (int) $course->lessons_count,
                'total_quizzes' => $totalQuizzes,
                'attempted_quizzes' => $attempted,
                'progress' => $progress,
            ];
        })->filter()->values();
    }

    /**
     * New catalog courses and quizzes added since the student's last dashboard visit.
     *
     * @return array{new_courses: Collection, new_quizzes: Collection, count: int}
     */
    public function studentHighlights(User $user, Carbon $since): array
    {
        $enrolledIds = $user->lmsEnrollments()->approved()->pluck('course_id');

        $newCourses = $user->lmsEnrollments()
            ->approved()
            ->where(function ($query) use ($since) {
                $query->where('approved_at', '>=', $since)
                    ->orWhere(function ($inner) use ($since) {
                        $inner->whereNull('approved_at')
                            ->where('created_at', '>=', $since);
                    });
            })
            ->with(['course' => fn ($q) => $q->withCount(['lessons', 'quizzes'])])
            ->latest('approved_at')
            ->latest()
            ->take(6)
            ->get()
            ->pluck('course')
            ->filter()
            ->values();

        $attemptedQuizIds = $user->quizAttempts()
            ->whereNotNull('submitted_at')
            ->pluck('quiz_id');

        $newQuizzes = collect();
        if ($enrolledIds->isNotEmpty()) {
            $newQuizzes = Quiz::query()
                ->whereIn('course_id', $enrolledIds)
                ->where('created_at', '>=', $since)
                ->when($attemptedQuizIds->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $attemptedQuizIds))
                ->with(['course:id,title'])
                ->latest()
                ->take(6)
                ->get();
        }

        return [
            'new_courses' => $newCourses,
            'new_quizzes' => $newQuizzes,
            'count' => $newCourses->count() + $newQuizzes->count(),
        ];
    }

    public function highlightSinceFromSession(): Carbon
    {
        $stored = session('student_dashboard_last_seen_at');

        return $stored ? Carbon::parse($stored) : now()->subDays(7);
    }

    public function markDashboardSeen(): void
    {
        session(['student_dashboard_last_seen_at' => now()->toIso8601String()]);
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $enrollmentProgress
     * @return array<string, int|float|null>
     */
    /**
     * Attendance summary and recent records for a student.
     *
     * @return array<string, mixed>
     */
    public function attendanceSummaryFor(User $user, int $recordLimit = 90): array
    {
        $records = AttendanceRecord::query()
            ->where('user_id', $user->id)
            ->orderByDesc('record_date')
            ->take($recordLimit)
            ->get();

        $present = $records->where('status', AttendanceRecord::STATUS_PRESENT)->count();
        $absent = $records->where('status', AttendanceRecord::STATUS_ABSENT)->count();
        $late = $records->where('status', AttendanceRecord::STATUS_LATE)->count();
        $excused = $records->where('status', AttendanceRecord::STATUS_EXCUSED)->count();
        $total = $records->count();

        $percentage = $total > 0
            ? round(($present + $late + $excused) / $total * 100, 1)
            : ($user->attendance_percentage !== null ? (float) $user->attendance_percentage : null);

        $leaveRequests = LeaveRequest::query()
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return [
            'records' => $records,
            'present_count' => $present,
            'absent_count' => $absent,
            'late_count' => $late,
            'excused_count' => $excused,
            'total_days' => $total,
            'percentage' => $percentage,
            'leave_requests' => $leaveRequests,
            'pending_leave_count' => $leaveRequests->where('status', LeaveRequest::STATUS_PENDING)->count(),
        ];
    }

    public function progressSummary(Collection $enrollmentProgress): array
    {
        if ($enrollmentProgress->isEmpty()) {
            return [
                'course_count' => 0,
                'avg_progress' => 0,
                'total_lessons' => 0,
                'attempted_quizzes' => 0,
                'total_quizzes' => 0,
                'completed_courses' => 0,
            ];
        }

        return [
            'course_count' => $enrollmentProgress->count(),
            'avg_progress' => round((float) $enrollmentProgress->avg('progress'), 1),
            'total_lessons' => (int) $enrollmentProgress->sum('lessons_count'),
            'attempted_quizzes' => (int) $enrollmentProgress->sum('attempted_quizzes'),
            'total_quizzes' => (int) $enrollmentProgress->sum('total_quizzes'),
            'completed_courses' => $enrollmentProgress->where('progress', 100)->count(),
        ];
    }
}
