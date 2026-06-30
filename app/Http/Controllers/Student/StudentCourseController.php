<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesRouteModels;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LmsEnrollment;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use App\Services\LectureAttendanceService;
use App\Support\StudentRoute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentCourseController extends Controller
{
    use ResolvesRouteModels;

    public function show($studentContext, $courseId): View
    {
        $course = $this->resolveCourse($courseId);
        $user = auth()->user();
        $this->ensureEnrolled($user->id, $course);

        $course->load([
            'lessons' => fn ($q) => $q->orderBy('order'),
            'quizzes' => fn ($q) => $q->withCount('questions'),
        ]);

        $attemptsByQuiz = QuizAttempt::query()
            ->where('user_id', $user->id)
            ->whereIn('quiz_id', $course->quizzes->pluck('id'))
            ->whereNotNull('submitted_at')
            ->latest('submitted_at')
            ->get()
            ->groupBy('quiz_id');

        $submittedCounts = QuizAttempt::query()
            ->where('user_id', $user->id)
            ->whereIn('quiz_id', $course->quizzes->pluck('id'))
            ->whereNotNull('submitted_at')
            ->selectRaw('quiz_id, COUNT(*) as cnt')
            ->groupBy('quiz_id')
            ->pluck('cnt', 'quiz_id');

        return view('student.courses.show', compact('course', 'attemptsByQuiz', 'submittedCounts'));
    }

    public function showLesson($studentContext, $courseId, $lesson, LectureAttendanceService $lectureAttendance): View
    {
        $course = $this->resolveCourse($courseId);
        $lesson = $this->resolveLesson($lesson);
        $this->ensureEnrolled(auth()->id(), $course);
        $this->ensureLessonBelongsToCourse($lesson, $course);

        $lectureAttendance->markAttended(auth()->id(), $lesson->id);

        $lesson->load('quizzes');

        return view('student.courses.lesson', compact('course', 'lesson'));
    }

    public function showQuiz($studentContext, $courseId, $quiz)
    {
        $course = $this->resolveCourse($courseId);
        $quiz = $this->resolveQuiz($quiz);
        $user = auth()->user();
        $this->ensureEnrolled($user->id, $course);
        $this->ensureQuizBelongsToCourse($quiz, $course);

        $quiz->loadCount('questions');
        $quiz->load(['questions' => fn ($q) => $q->orderBy('order')]);

        $attempts = $quiz->attempts()
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $submittedCount = $attempts->whereNotNull('submitted_at')->count();
        $inProgress = $attempts->first(fn ($a) => $a->submitted_at === null);

        if ($inProgress) {
            return StudentRoute::courseRedirect('student.courses.quizzes.take', $course, [
                'quiz' => $quiz,
                'attempt' => $inProgress,
            ]);
        }

        $canAttempt = $quiz->questions_count > 0 && $submittedCount < $quiz->attempt_limit;

        return view('student.courses.quiz', compact('course', 'quiz', 'attempts', 'submittedCount', 'canAttempt'));
    }

    public function startQuiz(Request $request, $studentContext, $courseId, $quiz): RedirectResponse
    {
        $course = $this->resolveCourse($courseId);
        $quiz = $this->resolveQuiz($quiz);
        $user = $request->user();
        $this->ensureEnrolled($user->id, $course);
        $this->ensureQuizBelongsToCourse($quiz, $course);

        $quiz->loadCount('questions');

        if ($quiz->questions_count === 0) {
            return StudentRoute::courseRedirect('student.courses.quizzes.show', $course, ['quiz' => $quiz])
                ->with('error', 'This quiz has no questions yet.');
        }

        $existingInProgress = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNull('submitted_at')
            ->first();

        if ($existingInProgress) {
            return StudentRoute::courseRedirect('student.courses.quizzes.take', $course, [
                'quiz' => $quiz,
                'attempt' => $existingInProgress,
            ]);
        }

        $submittedCount = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('submitted_at')
            ->count();

        if ($submittedCount >= $quiz->attempt_limit) {
            return StudentRoute::courseRedirect('student.courses.quizzes.show', $course, ['quiz' => $quiz])
                ->with('error', 'You have used all allowed attempts for this quiz.');
        }

        $attempt = $quiz->attempts()->create([
            'user_id' => $user->id,
            'started_at' => now(),
        ]);

        return StudentRoute::courseRedirect('student.courses.quizzes.take', $course, [
            'quiz' => $quiz,
            'attempt' => $attempt,
        ]);
    }

    public function takeQuiz($studentContext, $courseId, $quiz, $attempt)
    {
        $course = $this->resolveCourse($courseId);
        $quiz = $this->resolveQuiz($quiz);
        $attempt = $this->resolveAttempt($attempt);
        $user = auth()->user();
        $this->ensureEnrolled($user->id, $course);
        $this->ensureQuizBelongsToCourse($quiz, $course);
        $this->ensureAttemptBelongsToQuiz($attempt, $quiz, $user->id);

        if ($attempt->submitted_at) {
            return StudentRoute::courseRedirect('student.courses.quizzes.result', $course, [
                'quiz' => $quiz,
                'attempt' => $attempt,
            ]);
        }

        if ($quiz->duration_minutes && $attempt->started_at) {
            $expiresAt = $attempt->started_at->copy()->addMinutes($quiz->duration_minutes);
            if (now()->greaterThan($expiresAt)) {
                return $this->autoSubmitExpired($attempt, $quiz, $course);
            }
        }

        $quiz->load('questions');

        return view('student.courses.quiz-take', compact('course', 'quiz', 'attempt'));
    }

    public function submitQuiz(Request $request, $studentContext, $courseId, $quiz, $attempt): RedirectResponse
    {
        $course = $this->resolveCourse($courseId);
        $quiz = $this->resolveQuiz($quiz);
        $attempt = $this->resolveAttempt($attempt);
        $user = $request->user();
        $this->ensureEnrolled($user->id, $course);
        $this->ensureQuizBelongsToCourse($quiz, $course);
        $this->ensureAttemptBelongsToQuiz($attempt, $quiz, $user->id);

        if ($attempt->submitted_at) {
            return StudentRoute::courseRedirect('student.courses.quizzes.result', $course, [
                'quiz' => $quiz,
                'attempt' => $attempt,
            ]);
        }

        $quiz->load('questions');

        if ($quiz->questions->isEmpty()) {
            return StudentRoute::courseRedirect('student.courses.quizzes.show', $course, ['quiz' => $quiz])
                ->with('error', 'This quiz has no questions.');
        }

        $isAutoSubmit = $request->boolean('auto_submit');

        $rules = ['answers' => [$isAutoSubmit ? 'nullable' : 'required', 'array']];
        foreach ($quiz->questions as $question) {
            $rules['answers.'.$question->id] = [$isAutoSubmit ? 'nullable' : 'required', 'in:a,b,c,d'];
        }

        $validated = $request->validate($rules);
        $answers = $validated['answers'] ?? [];
        $obtained = 0;
        $maxMarks = (int) $quiz->questions->sum('marks') ?: $quiz->total_marks;

        foreach ($quiz->questions as $question) {
            $selected = $answers[$question->id] ?? null;
            if ($selected && strtolower($selected) === strtolower($question->correct_option)) {
                $obtained += (int) $question->marks;
            }
        }

        $percentage = $maxMarks > 0 ? round(($obtained / $maxMarks) * 100, 2) : 0;

        $attempt->update([
            'answers' => $answers,
            'obtained_marks' => $obtained,
            'percentage' => $percentage,
            'is_passed' => $obtained >= $quiz->passing_marks,
            'submitted_at' => now(),
        ]);

        return StudentRoute::courseRedirect('student.courses.quizzes.result', $course, [
            'quiz' => $quiz,
            'attempt' => $attempt,
        ])->with($isAutoSubmit ? 'error' : 'success', $isAutoSubmit
            ? 'Time is up. Your quiz was submitted automatically.'
            : 'Quiz submitted successfully.');
    }

    public function quizResult($studentContext, $courseId, $quiz, $attempt)
    {
        $course = $this->resolveCourse($courseId);
        $quiz = $this->resolveQuiz($quiz);
        $attempt = $this->resolveAttempt($attempt);
        $user = auth()->user();
        $this->ensureEnrolled($user->id, $course);
        $this->ensureQuizBelongsToCourse($quiz, $course);
        $this->ensureAttemptBelongsToQuiz($attempt, $quiz, $user->id);

        if (! $attempt->submitted_at) {
            return StudentRoute::courseRedirect('student.courses.quizzes.take', $course, [
                'quiz' => $quiz,
                'attempt' => $attempt,
            ]);
        }

        $quiz->load('questions');
        $maxMarks = (int) $quiz->questions->sum('marks') ?: $quiz->total_marks;

        return view('student.courses.quiz-result', compact('course', 'quiz', 'attempt', 'maxMarks'));
    }

    private function ensureEnrolled(int $userId, Course $course): void
    {
        $enrolled = LmsEnrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->where('status', LmsEnrollment::STATUS_APPROVED)
            ->exists();

        if ($enrolled) {
            return;
        }

        $student = User::query()->find($userId);
        $hasAssignedSubject = $student
            && $student->assignedSubjects()->where('subjects.course_id', $course->id)->exists();

        if ($hasAssignedSubject) {
            LmsEnrollment::updateOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $course->id,
                ],
                [
                    'status' => LmsEnrollment::STATUS_APPROVED,
                    'approved_at' => now(),
                ]
            );

            return;
        }

        abort(403, 'You must be enrolled and approved for this course.');
    }

    private function ensureLessonBelongsToCourse(Lesson $lesson, Course $course): void
    {
        if ((int) $lesson->course_id !== (int) $course->id) {
            abort(404);
        }
    }

    private function ensureQuizBelongsToCourse(Quiz $quiz, Course $course): void
    {
        if ((int) $quiz->course_id !== (int) $course->id) {
            abort(404);
        }
    }

    private function ensureAttemptBelongsToQuiz(QuizAttempt $attempt, Quiz $quiz, int $userId): void
    {
        if ((int) $attempt->quiz_id !== (int) $quiz->id || (int) $attempt->user_id !== $userId) {
            abort(404);
        }
    }

    private function autoSubmitExpired(QuizAttempt $attempt, Quiz $quiz, Course $course): RedirectResponse
    {
        $quiz->load('questions');
        $answers = $attempt->answers ?? [];
        $obtained = 0;
        $maxMarks = (int) $quiz->questions->sum('marks') ?: $quiz->total_marks;

        foreach ($quiz->questions as $question) {
            $selected = $answers[$question->id] ?? null;
            if ($selected && strtolower($selected) === strtolower($question->correct_option)) {
                $obtained += (int) $question->marks;
            }
        }

        $percentage = $maxMarks > 0 ? round(($obtained / $maxMarks) * 100, 2) : 0;

        $attempt->update([
            'obtained_marks' => $obtained,
            'percentage' => $percentage,
            'is_passed' => $obtained >= $quiz->passing_marks,
            'submitted_at' => now(),
        ]);

        return StudentRoute::courseRedirect('student.courses.quizzes.result', $course, [
            'quiz' => $quiz,
            'attempt' => $attempt,
        ])->with('error', 'Time is up. Your quiz was submitted automatically.');
    }
}
