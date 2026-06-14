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
        $quizzes = $course->quizzes()->withCount('questions')->get();

        return view('admin.courses.quizzes.index', compact('course', 'quizzes'));
    }

    public function create(Course $course)
    {
        $lessons = $course->lessons()->get();
        return view('admin.courses.quizzes.create', compact('course', 'lessons'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lesson_id' => 'nullable|exists:lessons,id',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:0',
            'attempt_limit' => 'required|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string|max:500',
            'questions.*.option_b' => 'required|string|max:500',
            'questions.*.option_c' => 'nullable|string|max:500',
            'questions.*.option_d' => 'nullable|string|max:500',
            'questions.*.correct_option' => 'required|in:a,b,c,d',
            'questions.*.marks' => 'required|integer|min:1',
        ]);

        $questions = $validated['questions'];
        unset($validated['questions']);

        $quiz = $course->quizzes()->create($validated);

        foreach (array_values($questions) as $order => $question) {
            $quiz->questions()->create($question + ['order' => $order]);
        }

        return redirect()
            ->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Quiz created with '.count($questions).' question(s). Students can now attempt it.');
    }

    public function edit(Course $course, Quiz $quiz)
    {
        $lessons = $course->lessons()->get();
        $quiz->load('questions');

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

    public function storeQuestion(Request $request, Course $course, Quiz $quiz)
    {
        if ((int) $quiz->course_id !== (int) $course->id) {
            abort(404);
        }

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:500',
            'option_b' => 'required|string|max:500',
            'option_c' => 'nullable|string|max:500',
            'option_d' => 'nullable|string|max:500',
            'correct_option' => 'required|in:a,b,c,d',
            'marks' => 'required|integer|min:1',
            'order' => 'nullable|integer|min:0',
        ]);

        $quiz->questions()->create($validated);

        return redirect()
            ->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Question added successfully.');
    }

    public function destroyQuestion(Course $course, Quiz $quiz, \App\Models\QuizQuestion $question)
    {
        if ((int) $quiz->course_id !== (int) $course->id || (int) $question->quiz_id !== (int) $quiz->id) {
            abort(404);
        }

        $question->delete();

        return redirect()
            ->route('admin.quizzes.edit', [$course, $quiz])
            ->with('success', 'Question removed.');
    }
}
