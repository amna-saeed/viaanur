<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LmsEnrollment;
use App\Models\User;
use App\Models\Course;
use App\Services\EnrollmentRequestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminEnrollmentController extends Controller
{
    public function index(Request $request, EnrollmentRequestService $enrollmentService)
    {
        $reconciled = $enrollmentService->reconcileApprovedApplications();
        if ($reconciled > 0) {
            session()->flash('success', 'Synced '.$reconciled.' approved enrollment(s) with student course access.');
        }

        $query = LmsEnrollment::with(['user', 'course'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at');
        
        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('user', function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })->orWhereHas('course', function ($qry) use ($q) {
                $qry->where('title', 'like', "%{$q}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('student_id')) {
            $query->where('user_id', $request->student_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->paginate(15)->withQueryString();
        $courses = Course::all();
        $students = User::where('role', User::ROLE_STUDENT)->get();
        $pendingApplications = $enrollmentService->pendingApplications();
        $pendingCount = $enrollmentService->pendingCount();

        return view('admin.enrollments.index', compact(
            'enrollments',
            'courses',
            'students',
            'pendingCount',
            'pendingApplications',
            'enrollmentService'
        ));
    }

    public function create()
    {
        $courses = Course::orderBy('title')->get();
        $students = User::where('role', User::ROLE_STUDENT)->orderBy('name')->get();
        return view('admin.enrollments.create', compact('courses', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Check if enrollment already exists
        $exists = LmsEnrollment::where('user_id', $request->user_id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This student is already enrolled in this course.');
        }

        LmsEnrollment::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'status' => LmsEnrollment::STATUS_APPROVED,
            'approved_at' => now(),
        ]);
        return redirect()->route('admin.enrollments.index')->with('success', 'Student enrolled successfully.');
    }

    public function show(LmsEnrollment $enrollment)
    {
        $enrollment->load(['user', 'course']);
        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function destroy(LmsEnrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->back()->with('success', 'Enrollment deleted successfully.');
    }

    public function bulkEnroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $course_id = $request->course_id;
        $count = 0;

        foreach ($request->student_ids as $student_id) {
            $exists = LmsEnrollment::where('user_id', $student_id)
                ->where('course_id', $course_id)
                ->exists();

            if (!$exists) {
                LmsEnrollment::create([
                    'user_id' => $student_id,
                    'course_id' => $course_id,
                    'status' => LmsEnrollment::STATUS_APPROVED,
                    'approved_at' => now(),
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.enrollments.index')->with('success', "Enrolled $count student(s) successfully.");
    }

    public function approve(LmsEnrollment $enrollment, EnrollmentRequestService $enrollmentService): RedirectResponse
    {
        try {
            $enrollment = $enrollmentService->approve($enrollment);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first('enrollment'));
        }

        return redirect()->back()->with('success', $enrollment->user->name.' has been approved for '.$enrollment->course->title.'.');
    }

    public function reject(LmsEnrollment $enrollment, EnrollmentRequestService $enrollmentService): RedirectResponse
    {
        try {
            $enrollment = $enrollmentService->reject($enrollment);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first('enrollment'));
        }

        return redirect()->back()->with('success', 'Enrollment request for '.$enrollment->user->name.' has been rejected.');
    }

    public function alerts(EnrollmentRequestService $enrollmentService)
    {
        $pendingCount = $enrollmentService->pendingCount();
        $items = $enrollmentService->pendingItemsPayload();

        return response()->json([
            'alerts' => $enrollmentService->alertsPayload(),
            'items' => $items,
            'pending_count' => $pendingCount,
            'has_more' => $pendingCount > count($items),
            'generated_at' => now()->toIso8601String(),
        ]);
    }
}
