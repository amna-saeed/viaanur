<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Course $course)
    {
        $quizzes = $course->quizzes()->get();
        return view('admin.courses.quizzes.index', compact('course', 'quizzes'));
    }

    public function create(Course $course)
    {
        $lessons = $course->lessons()->get();
        return view('admin.courses.quizzes.create', compact('course', 'lessons'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'nullable|exists:lessons,id',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'attempt_limit' => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        $course->quizzes()->create($request->all());

        return redirect()->route('admin.quizzes.index', $course)->with('success', 'Quiz created successfully.');
    }

    public function edit(Course $course, Quiz $quiz)
    {
        $lessons = $course->lessons()->get();
        return view('admin.courses.quizzes.edit', compact('course', 'quiz', 'lessons'));
    }

    public function update(Request $request, Course $course, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'nullable|exists:lessons,id',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'attempt_limit' => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
        ]);

        $quiz->update($request->all());

        return redirect()->route('admin.quizzes.index', $course)->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Course $course, Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->back()->with('success', 'Quiz deleted successfully.');
    }

    public function attempts(Course $course, Quiz $quiz)
    {
        $attempts = $quiz->attempts()->with('user')->get();
        return view('admin.courses.quizzes.attempts', compact('course', 'quiz', 'attempts'));
    }
}
