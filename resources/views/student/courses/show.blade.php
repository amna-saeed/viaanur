@extends('student.layout')
@section('title', $course->title)
@section('page_heading', 'Course details')

@section('content')
@php
    $lessonCount = $course->lessons->count();
    $quizCount = $course->quizzes->count();
@endphp

<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ route('student.dashboard', student_route_params()) }}">Dashboard</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">{{ $course->title }}</span>
</nav>

<a href="{{ route('student.dashboard', student_route_params()) }}" class="student-course-back d-lg-none mb-3">
    <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to dashboard
</a>

<section class="student-course-hero-card {{ $course->image ? 'student-course-hero-card--with-media' : '' }}" aria-labelledby="course-heading">
    <div class="student-course-hero-card__content">
        <p class="student-course-hero-card__eyebrow">Enrolled course</p>
        <h2 id="course-heading" class="student-course-hero-card__title">{{ $course->title }}</h2>
        @if($course->description)
            <p class="student-course-hero-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 260) }}</p>
        @endif

        <ul class="student-course-hero-card__stats list-unstyled mb-0">
            <li>
                <i class="bi bi-collection-play" aria-hidden="true"></i>
                <span><strong>{{ $lessonCount }}</strong> {{ \Illuminate\Support\Str::plural('lesson', $lessonCount) }}</span>
            </li>
            <li>
                <i class="bi bi-patch-question" aria-hidden="true"></i>
                <span><strong>{{ $quizCount }}</strong> {{ \Illuminate\Support\Str::plural('quiz', $quizCount) }}</span>
            </li>
        </ul>

        <a href="{{ route('student.dashboard', student_route_params()) }}" class="btn btn-light btn-sm student-course-hero-card__back d-none d-lg-inline-flex">
            <i class="bi bi-arrow-left" aria-hidden="true"></i> Dashboard
        </a>
    </div>

    @if($course->image)
        <figure class="student-course-hero-card__media">
            <img
                src="{{ asset('storage/' . $course->image) }}"
                alt="Cover image for {{ $course->title }}"
                class="student-course-hero-card__img"
                width="640"
                height="360"
                loading="lazy"
                decoding="async"
            >
        </figure>
    @endif
</section>

<div class="student-course-layout row g-4 g-xl-5">
    <div class="col-lg-7">
        <section class="student-course-block" aria-labelledby="lessons-heading">
            <header class="student-dash-section-head">
                <div>
                    <h2 id="lessons-heading" class="student-dash-section-head__title">Lessons</h2>
                    <p class="student-dash-section-head__sub">Read and watch course content</p>
                </div>
                <span class="badge rounded-pill student-dash-badge student-dash-badge--muted">{{ $lessonCount }}</span>
            </header>

            @if($course->lessons->isEmpty())
                <div class="student-dash-panel student-dash-panel--empty">
                    <i class="bi bi-collection-play student-dash-panel__empty-icon" aria-hidden="true"></i>
                    <p class="student-dash-panel__empty-title">No lessons yet</p>
                    <p class="student-dash-panel__empty-text mb-0">Your instructor has not published any lessons for this course.</p>
                </div>
            @else
                <div class="student-course-list">
                    @foreach($course->lessons as $lesson)
                        <a href="{{ student_course_route('student.courses.lessons.show', $course, ['lesson' => $lesson]) }}" class="student-course-list__item">
                            <span class="student-course-list__icon" aria-hidden="true">
                                <i class="bi bi-play-fill"></i>
                            </span>
                            <span class="student-course-list__body">
                                <span class="student-course-list__label">Lesson {{ $lesson->order }}</span>
                                <span class="student-course-list__title">{{ $lesson->title }}</span>
                                <span class="student-course-list__meta">
                                    @if($lesson->video)
                                        <span><i class="bi bi-camera-video" aria-hidden="true"></i> Video</span>
                                    @endif
                                    @if($lesson->pdf_notes)
                                        <span><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i> PDF notes</span>
                                    @endif
                                    @if(! $lesson->video && ! $lesson->pdf_notes)
                                        <span>Content coming soon</span>
                                    @endif
                                </span>
                            </span>
                            <i class="bi bi-chevron-right student-course-list__arrow" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <div class="col-lg-5">
        <section class="student-course-block" aria-labelledby="quizzes-heading">
            <header class="student-dash-section-head">
                <div>
                    <h2 id="quizzes-heading" class="student-dash-section-head__title">Quizzes</h2>
                    <p class="student-dash-section-head__sub">Test your knowledge</p>
                </div>
                <span class="badge rounded-pill student-dash-badge student-dash-badge--muted">{{ $quizCount }}</span>
            </header>

            @if($course->quizzes->isEmpty())
                <div class="student-dash-panel student-dash-panel--empty">
                    <i class="bi bi-patch-question student-dash-panel__empty-icon" aria-hidden="true"></i>
                    <p class="student-dash-panel__empty-title">No quizzes yet</p>
                    <p class="student-dash-panel__empty-text mb-0">Quizzes will appear here when your instructor adds them.</p>
                </div>
            @else
                <div class="student-course-quiz-stack">
                    @foreach($course->quizzes as $quiz)
                        @php
                            $attemptCount = (int) ($submittedCounts[$quiz->id] ?? 0);
                            $latest = ($attemptsByQuiz[$quiz->id] ?? collect())->first();
                            $attemptsExhausted = $attemptCount >= $quiz->attempt_limit;
                        @endphp
                        <article class="student-course-quiz">
                            <div class="student-course-quiz__head">
                                <div class="student-course-quiz__icon" aria-hidden="true">
                                    <i class="bi bi-patch-question"></i>
                                </div>
                                <div class="student-course-quiz__titles">
                                    <h3 class="student-course-quiz__title">{{ $quiz->title }}</h3>
                                    @if($quiz->description)
                                        <p class="student-course-quiz__desc">{{ \Illuminate\Support\Str::limit(strip_tags($quiz->description), 90) }}</p>
                                    @endif
                                </div>
                                @if($latest)
                                    <span class="badge rounded-pill {{ $latest->is_passed ? 'student-dash-badge student-dash-badge--success' : 'student-dash-badge student-dash-badge--muted' }}">
                                        {{ $latest->is_passed ? 'Passed' : 'Failed' }}
                                    </span>
                                @endif
                            </div>

                            <ul class="student-course-quiz__meta list-unstyled mb-0">
                                <li><i class="bi bi-list-check" aria-hidden="true"></i> {{ $quiz->questions_count }} questions</li>
                                <li><i class="bi bi-arrow-repeat" aria-hidden="true"></i> {{ $attemptCount }}/{{ $quiz->attempt_limit }} attempts</li>
                                @if($quiz->duration_minutes)
                                    <li><i class="bi bi-clock" aria-hidden="true"></i> {{ $quiz->duration_minutes }} min</li>
                                @endif
                            </ul>

                            @if($latest && $latest->submitted_at)
                                <p class="student-course-quiz__score mb-0">
                                    Last score: <strong>{{ round((float) $latest->percentage) }}%</strong>
                                    <span class="text-muted">({{ $latest->obtained_marks }}/{{ $quiz->total_marks }})</span>
                                </p>
                            @endif

                            <a href="{{ student_course_route('student.courses.quizzes.show', $course, ['quiz' => $quiz]) }}" class="btn btn-sm btn-lms-primary student-course-quiz__btn w-100">
                                @if($attemptsExhausted)
                                    <i class="bi bi-bar-chart-line" aria-hidden="true"></i> View results
                                @elseif($attemptCount > 0)
                                    <i class="bi bi-arrow-repeat" aria-hidden="true"></i> Try again
                                @else
                                    <i class="bi bi-play-fill" aria-hidden="true"></i> Start quiz
                                @endif
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
