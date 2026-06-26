<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LeaveRequest;
use App\Models\LmsEnrollment;
use App\Models\User;
use App\Services\LmsDashboardStatsService;
use App\Services\LeaveRequestService;
use App\Support\StudentInformation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(LmsDashboardStatsService $lmsStats): View
    {
        $user = auth()->user();

        $approvedCourseIds = $user->lmsEnrollments()->approved()->pluck('course_id');
        $enrolledCount = $approvedCourseIds->count();
        $pendingEnrollments = $user->lmsEnrollments()
            ->pending()
            ->with(['course:id,title,slug,image,description'])
            ->latest()
            ->get();

        $catalog = Course::query()
            ->whereIn('id', $approvedCourseIds)
            ->withCount(['lessons', 'quizzes'])
            ->orderByDesc('created_at')
            ->get();

        $announcements = $lmsStats->publishedAnnouncements(5);
        $canClaimAdmin = ! User::adminExists();

        $courses = Course::query()
            ->whereIn('id', $approvedCourseIds)
            ->withCount(['lessons', 'quizzes'])
            ->get();

        $submittedAttempts = $user->quizAttempts()->whereNotNull('submitted_at');
        $summary = [
            'enrolled_count' => $enrolledCount,
            'catalog_count' => $catalog->count(),
            'announcements_count' => $announcements->count(),
            'lessons_in_enrolled' => (int) $courses->sum('lessons_count'),
            'quizzes_in_enrolled' => (int) $courses->sum('quizzes_count'),
            'quiz_attempts' => (clone $submittedAttempts)->count(),
            'quiz_avg_percent' => (clone $submittedAttempts)->avg('percentage'),
            'attendance_percentage' => $user->attendance_percentage,
        ];

        $recentQuizAttempts = $lmsStats->recentQuizAttempts($user, 8);
        $recentEnrollmentActivity = $lmsStats->recentEnrollments($user, 5);
        $enrollmentProgress = $lmsStats->enrollmentProgressFor($user);
        $highlights = $lmsStats->studentHighlights($user, $lmsStats->highlightSinceFromSession());

        app()->terminating(function () use ($lmsStats) {
            $lmsStats->markDashboardSeen();
        });

        return view('student.dashboard', compact(
            'catalog',
            'announcements',
            'canClaimAdmin',
            'summary',
            'recentQuizAttempts',
            'recentEnrollmentActivity',
            'enrollmentProgress',
            'highlights',
            'pendingEnrollments'
        ));
    }

    public function myCourses(LmsDashboardStatsService $lmsStats): View
    {
        $user = auth()->user();
        $enrollmentProgress = $lmsStats->enrollmentProgressFor($user);
        $progressSummary = $lmsStats->progressSummary($enrollmentProgress);

        return view('student.my-courses', compact('enrollmentProgress', 'progressSummary'));
    }

    public function progress(LmsDashboardStatsService $lmsStats): View
    {
        $user = auth()->user();
        $enrollmentProgress = $lmsStats->enrollmentProgressFor($user);
        $progressSummary = $lmsStats->progressSummary($enrollmentProgress);

        return view('student.progress', compact('enrollmentProgress', 'progressSummary'));
    }

    public function attendance(LmsDashboardStatsService $lmsStats): View
    {
        $user = auth()->user();
        $attendance = $lmsStats->attendanceSummaryFor($user);

        return view('student.attendance', compact('attendance', 'user'));
    }

    public function storeLeaveRequest(Request $request, LeaveRequestService $leaveService): RedirectResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'start_date.after_or_equal' => 'Leave start date cannot be in the past.',
            'end_date.after_or_equal' => 'End date must be on or after the start date.',
            'reason.min' => 'Please provide a brief reason (at least 10 characters).',
        ]);

        if ($leaveService->hasOverlappingPending(
            $request->user()->id,
            $validated['start_date'],
            $validated['end_date']
        )) {
            return student_redirect('student.attendance')
                ->withInput()
                ->with('error', 'You already have a pending leave request for overlapping dates.');
        }

        LeaveRequest::create([
            'user_id' => $request->user()->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'],
            'status' => LeaveRequest::STATUS_PENDING,
        ]);

        return student_redirect('student.attendance')
            ->with('success', 'Your leave request has been submitted and is pending admin review.');
    }

    public function profile(LmsDashboardStatsService $lmsStats): View
    {
        $student = auth()->user()->loadMissing('studentProfile');
        $genderOptions = StudentInformation::GENDER_OPTIONS;
        $enrollmentProgress = $lmsStats->enrollmentProgressFor($student);
        $quizAttemptsCount = $student->quizAttempts()->whereNotNull('submitted_at')->count();
        $enrolledCount = $student->lmsEnrollments()->approved()->count();

        return view('student.profile', compact(
            'student',
            'genderOptions',
            'enrollmentProgress',
            'quizAttemptsCount',
            'enrolledCount'
        ));
    }

    public function enroll(Request $request, Course $course): RedirectResponse
    {
        if (! $course->is_published) {
            return student_redirect('student.dashboard')->with('error', 'This course is not available.');
        }

        $enrollment = LmsEnrollment::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'course_id' => $course->id,
            ],
            [
                'status' => LmsEnrollment::STATUS_PENDING,
            ]
        );

        if ($enrollment->status === LmsEnrollment::STATUS_REJECTED) {
            $enrollment->update([
                'status' => LmsEnrollment::STATUS_PENDING,
                'approved_at' => null,
            ]);
        }

        if ($enrollment->isApproved()) {
            return student_redirect('student.dashboard')->with('success', 'You are already enrolled in '.$course->title.'.');
        }

        if ($enrollment->isPending()) {
            return student_redirect('student.dashboard')->with('success', 'Your enrollment request for '.$course->title.' has been submitted. You will get access after admin approval.');
        }

        return student_redirect('student.dashboard')->with('success', 'You are now enrolled in '.$course->title.'.');
    }
}
