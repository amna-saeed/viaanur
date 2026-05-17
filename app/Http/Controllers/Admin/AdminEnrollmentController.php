<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LmsEnrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = LmsEnrollment::with(['user', 'course'])->orderByDesc('created_at');
        
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

        $enrollments = $query->paginate(15)->withQueryString();
        $courses = Course::all();
        $students = User::where('role', User::ROLE_STUDENT)->get();

        return view('admin.enrollments.index', compact('enrollments', 'courses', 'students'));
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

        LmsEnrollment::create($request->all());
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
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.enrollments.index')->with('success', "Enrolled $count student(s) successfully.");
    }
}
