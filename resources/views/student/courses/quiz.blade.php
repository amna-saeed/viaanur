@extends('student.layout')
@section('title', $quiz->title)
@section('page_heading', 'Quiz details')

@section('content')
@php
    $completedAttempts = $attempts->whereNotNull('submitted_at');
    $latestAttempt = $completedAttempts->first();
@endphp

<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ student_course_route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">{{ $quiz->title }}</span>
</nav>

<a href="{{ student_course_route('student.courses.show', $course) }}" class="student-course-back d-lg-none mb-3">
    <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to course
</a>

<section class="student-course-hero-card" aria-labelledby="quiz-heading">
    <div class="student-course-hero-card__content">
        <p class="student-course-hero-card__eyebrow">Quiz</p>
        <h2 id="quiz-heading" class="student-course-hero-card__title">{{ $quiz->title }}</h2>
        @if($quiz->description)
            <p class="student-course-hero-card__desc">{{ strip_tags($quiz->description) }}</p>
        @else
            <p class="student-course-hero-card__desc mb-0">Part of <strong>{{ $course->title }}</strong></p>
        @endif

        <ul class="student-course-hero-card__stats list-unstyled mb-0">
            <li>
                <i class="bi bi-list-check" aria-hidden="true"></i>
                <span><strong>{{ $quiz->questions_count }}</strong> questions</span>
            </li>
            <li>
                <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                <span><strong>{{ $submittedCount }}/{{ $quiz->attempt_limit }}</strong> attempts</span>
            </li>
            @if($latestAttempt)
                <li>
                    <i class="bi bi-{{ $latestAttempt->is_passed ? 'check-circle' : 'x-circle' }}" aria-hidden="true"></i>
                    <span>Last: <strong>{{ round((float) $latestAttempt->percentage) }}%</strong></span>
                </li>
            @endif
        </ul>

        <a href="{{ student_course_route('student.courses.show', $course) }}" class="btn btn-light btn-sm student-course-hero-card__back d-none d-lg-inline-flex">
            <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to course
        </a>
    </div>
</section>

<div class="student-quiz-layout row g-4 g-xl-5">
    <div class="col-lg-5">
        <aside class="student-quiz-sidebar">
            <section class="student-lesson-panel student-quiz-details" aria-labelledby="quiz-details-heading">
                <header class="student-lesson-panel__head">
                    <span class="student-lesson-panel__icon student-course-list__icon--quiz" aria-hidden="true">
                        <i class="bi bi-info-circle"></i>
                    </span>
                    <div>
                        <h3 id="quiz-details-heading" class="student-lesson-panel__title">Quiz details</h3>
                        <p class="student-lesson-panel__sub mb-0">Rules and scoring for this quiz</p>
                    </div>
                </header>
                <div class="student-quiz-details__body">
                    <ul class="student-quiz-stats list-unstyled mb-0">
                        <li>
                            <i class="bi bi-list-check" aria-hidden="true"></i>
                            <span class="student-quiz-stats__label">Questions</span>
                            <strong class="student-quiz-stats__value">{{ $quiz->questions_count }}</strong>
                        </li>
                        <li>
                            <i class="bi bi-award" aria-hidden="true"></i>
                            <span class="student-quiz-stats__label">Total marks</span>
                            <strong class="student-quiz-stats__value">{{ $quiz->total_marks }}</strong>
                        </li>
                        <li>
                            <i class="bi bi-check2-circle" aria-hidden="true"></i>
                            <span class="student-quiz-stats__label">Passing marks</span>
                            <strong class="student-quiz-stats__value">{{ $quiz->passing_marks }}</strong>
                        </li>
                        <li>
                            <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
                            <span class="student-quiz-stats__label">Attempts used</span>
                            <strong class="student-quiz-stats__value">{{ $submittedCount }}/{{ $quiz->attempt_limit }}</strong>
                        </li>
                        <li>
                            <i class="bi bi-clock" aria-hidden="true"></i>
                            <span class="student-quiz-stats__label">Duration</span>
                            <strong class="student-quiz-stats__value">{{ $quiz->duration_minutes ? $quiz->duration_minutes . ' min' : 'No limit' }}</strong>
                        </li>
                    </ul>

                    <div class="student-quiz-action mt-4">
                        @if($quiz->questions_count === 0)
                            <div class="student-quiz-alert student-quiz-alert--warn">
                                <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
                                <p class="mb-0">This quiz has no questions yet. Please ask your instructor to add questions.</p>
                            </div>
                        @elseif($canAttempt)
                            <form action="{{ student_course_route('student.courses.quizzes.start', $course, ['quiz' => $quiz]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-lms-primary w-100 student-quiz-action__btn">
                                    <i class="bi bi-play-fill" aria-hidden="true"></i>
                                    {{ $submittedCount > 0 ? 'Start new attempt' : 'Start quiz' }}
                                </button>
                            </form>
                            <p class="student-quiz-action__hint mb-0">
                                You will answer {{ $quiz->questions_count }} question{{ $quiz->questions_count > 1 ? 's' : '' }} on the next screen.
                            </p>
                        @else
                            <div class="student-quiz-alert student-quiz-alert--muted">
                                <i class="bi bi-info-circle" aria-hidden="true"></i>
                                <p class="mb-0">You have used all {{ $quiz->attempt_limit }} attempt{{ $quiz->attempt_limit > 1 ? 's' : '' }}.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </aside>
    </div>

    <div class="col-lg-7">
        @if($quiz->questions_count > 0)
            <section class="student-lesson-panel mb-4" aria-labelledby="questions-heading">
                <header class="student-lesson-panel__head">
                    <span class="student-lesson-panel__icon student-lesson-panel__icon--video" aria-hidden="true">
                        <i class="bi bi-list-ul"></i>
                    </span>
                    <div>
                        <h3 id="questions-heading" class="student-lesson-panel__title">Questions preview</h3>
                        <p class="student-lesson-panel__sub mb-0">Topics covered in this quiz</p>
                    </div>
                </header>
                <div class="student-quiz-details__body">
                    <ol class="student-quiz-question-list list-unstyled mb-0">
                        @foreach($quiz->questions as $index => $question)
                            <li class="student-quiz-question-list__item">
                                <span class="student-quiz-question-list__num" aria-hidden="true">{{ $index + 1 }}</span>
                                <span class="student-quiz-question-list__text">{{ $question->question_text }}</span>
                                <span class="badge student-dash-badge student-dash-badge--muted student-quiz-question-list__marks">
                                    {{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }}
                                </span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </section>
        @endif

        <section class="student-lesson-panel" aria-labelledby="attempts-heading">
            <header class="student-lesson-panel__head">
                <span class="student-lesson-panel__icon student-lesson-panel__icon--pdf" aria-hidden="true">
                    <i class="bi bi-clock-history"></i>
                </span>
                <div class="flex-grow-1">
                    <h3 id="attempts-heading" class="student-lesson-panel__title">Your attempts</h3>
                    <p class="student-lesson-panel__sub mb-0">Review past scores and answers</p>
                </div>
                @if($completedAttempts->isNotEmpty())
                    <span class="badge rounded-pill student-dash-badge student-dash-badge--muted">{{ $completedAttempts->count() }}</span>
                @endif
            </header>

            @if($completedAttempts->isEmpty())
                <div class="student-quiz-details__body">
                    <div class="student-lesson-sidebar__empty mb-0">
                        <i class="bi bi-inbox" aria-hidden="true"></i>
                        <p class="mb-0">No completed attempts yet. Start the quiz when you are ready.</p>
                    </div>
                </div>
            @else
                <div class="student-quiz-attempt-list">
                    @foreach($completedAttempts as $pastAttempt)
                        <article class="student-quiz-attempt-card">
                            <div class="student-quiz-attempt-card__score">
                                <span class="student-quiz-attempt-card__percent">{{ round((float) $pastAttempt->percentage) }}%</span>
                                <span class="student-quiz-attempt-card__marks">{{ $pastAttempt->obtained_marks }}/{{ $quiz->total_marks }} marks</span>
                            </div>
                            <div class="student-quiz-attempt-card__meta">
                                <span class="badge rounded-pill {{ $pastAttempt->is_passed ? 'student-dash-badge student-dash-badge--success' : 'student-dash-badge student-dash-badge--fail' }}">
                                    {{ $pastAttempt->is_passed ? 'Passed' : 'Failed' }}
                                </span>
                                <time class="student-quiz-attempt-card__date" datetime="{{ $pastAttempt->submitted_at->toIso8601String() }}">
                                    {{ $pastAttempt->submitted_at->format('M j, Y g:i A') }}
                                </time>
                            </div>
                            <a href="{{ student_course_route('student.courses.quizzes.result', $course, ['quiz' => $quiz, 'attempt' => $pastAttempt]) }}" class="btn btn-sm btn-outline-primary student-quiz-attempt-card__btn">
                                <i class="bi bi-eye" aria-hidden="true"></i> Review
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
