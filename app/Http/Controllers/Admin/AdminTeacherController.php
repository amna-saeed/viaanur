<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::orderBy('name');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($qry) use ($q) {
                $qry->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('department', 'like', "%{$q}%");
            });
        }
        $teachers = $query->paginate(15)->withQueryString();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        Teacher::create($request->all());
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $teacher->update($request->all());
        return redirect()->route('admin.teachers.show', $teacher)->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->back()->with('success', 'Teacher deleted successfully.');
    }

    public function assignSubjectForm(Teacher $teacher)
    {
        $courses = Course::all();
        $assignedSubjects = $teacher->subjects()->with('course')->get();
        return view('admin.teachers.assign-subject', compact('teacher', 'courses', 'assignedSubjects'));
    }

    public function assignSubject(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'code' => 'nullable|string|max:50',
            'credit_hours' => 'nullable|numeric|min:0.5|max:10',
        ]);

        Subject::create([
            'teacher_id' => $teacher->id,
            'name' => $request->name,
            'course_id' => $request->course_id,
            'code' => $request->code,
            'credit_hours' => $request->credit_hours,
        ]);

        return redirect()->back()->with('success', 'Subject assigned successfully.');
    }

    public function removeSubject(Request $request, Teacher $teacher, Subject $subject)
    {
        if ($subject->teacher_id === $teacher->id) {
            $subject->delete();
            return redirect()->back()->with('success', 'Subject removed successfully.');
        }
        return redirect()->back()->with('error', 'Subject not found.');
    }
}
