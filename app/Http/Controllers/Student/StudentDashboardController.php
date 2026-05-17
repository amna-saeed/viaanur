<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LmsEnrollment;
use App\Models\User;
use App\Services\LmsDashboardStatsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(LmsDashboardStatsService $lmsStats): View
    {
        $user = auth()->user();

        $enrollments = $user->lmsEnrollments()
            ->with(['course' => fn ($q) => $q->withCount(['lessons', 'quizzes'])])
            ->orderByDesc('created_at')
            ->get();

        $enrolledCourseIds = $enrollments->pluck('course_id');

        $catalog = Course::query()
            ->where('is_published', true)
            ->whereNotIn('id', $enrolledCourseIds)
            ->withCount(['lessons', 'quizzes'])
            ->orderByDesc('created_at')
            ->get();

        $announcements = $lmsStats->publishedAnnouncements(5);
        $canClaimAdmin = ! User::adminExists();

        $courses = $enrollments->pluck('course')->filter();

        $quizzesTriedByCourseId = DB::table('quiz_attempts')
            ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
            ->where('quiz_attempts.user_id', $user->id)
            ->whereNotNull('quiz_attempts.submitted_at')
            ->groupBy('quizzes.course_id')
            ->selectRaw('quizzes.course_id, COUNT(DISTINCT quiz_attempts.quiz_id) as cnt')
            ->pluck('cnt', 'course_id')
            ->mapWithKeys(fn ($count, $courseId) => [(int) $courseId => (int) $count]);

        $submittedAttempts = $user->quizAttempts()->whereNotNull('submitted_at');
        $summary = [
            'enrolled_count' => $enrollments->count(),
            'catalog_count' => $catalog->count(),
            'announcements_count' => $announcements->count(),
            'lessons_in_enrolled' => (int) $courses->sum('lessons_count'),
            'quizzes_in_enrolled' => (int) $courses->sum('quizzes_count'),
            'quiz_attempts' => (clone $submittedAttempts)->count(),
            'quiz_avg_percent' => (clone $submittedAttempts)->avg('percentage'),
        ];

        return view('student.dashboard', compact(
            'enrollments',
            'catalog',
            'announcements',
            'canClaimAdmin',
            'summary',
            'quizzesTriedByCourseId'
        ));
    }

    public function enroll(Request $request, Course $course): RedirectResponse
    {
        if (! $course->is_published) {
            return redirect()->route('student.dashboard')->with('error', 'This course is not available.');
        }

        LmsEnrollment::firstOrCreate([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
        ]);

        return redirect()->route('student.dashboard')->with('success', 'You are now enrolled in '.$course->title.'.');
    }
}
