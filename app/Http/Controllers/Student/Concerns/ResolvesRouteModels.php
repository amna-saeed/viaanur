<?php

namespace App\Http\Controllers\Student\Concerns;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizAttempt;

trait ResolvesRouteModels
{
    /**
     * @param  Course|int|string  $course
     */
    protected function resolveCourse($course): Course
    {
        return $course instanceof Course ? $course : Course::findOrFail($course);
    }

    /**
     * @param  Lesson|int|string  $lesson
     */
    protected function resolveLesson($lesson): Lesson
    {
        return $lesson instanceof Lesson ? $lesson : Lesson::findOrFail($lesson);
    }

    /**
     * @param  Quiz|int|string  $quiz
     */
    protected function resolveQuiz($quiz): Quiz
    {
        return $quiz instanceof Quiz ? $quiz : Quiz::findOrFail($quiz);
    }

    /**
     * @param  QuizAttempt|int|string  $attempt
     */
    protected function resolveAttempt($attempt): QuizAttempt
    {
        return $attempt instanceof QuizAttempt ? $attempt : QuizAttempt::findOrFail($attempt);
    }
}
