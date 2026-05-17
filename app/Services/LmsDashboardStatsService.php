<?php

namespace App\Services;

use App\Models\Course;
use App\Models\LmsAnnouncement;
use App\Models\LmsClass;
use App\Models\LmsEnrollment;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Collection;
class LmsDashboardStatsService
{
    public function adminSummary(): array
    {
        return [
            'total_students' => User::where('role', User::ROLE_STUDENT)->count(),
            'total_teachers' => Teacher::count(),
            'total_courses' => Course::count(),
            'active_classes' => LmsClass::where('is_active', true)->count(),
            'total_enrollments' => LmsEnrollment::count(),
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
            ->withCount('enrollments')
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
}
