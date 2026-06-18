@extends('student.layout')
@section('title', $course->title)
@section('page_heading', $course->title)

@section('content')
<section class="student-dash-welcome mb-4" aria-labelledby="course-heading">
    <div class="student-dash-welcome__inner">
        <div class="student-dash-welcome__copy">
            <p class="student-dash-welcome__eyebrow mb-2">Enrolled course</p>
            <h2 id="course-heading" class="student-dash-welcome__title">{{ $course->title }}</h2>
            @if($course->description)
                <p class="student-dash-welcome__text mb-0">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 220) }}</p>
            @endif
        </div>
        <div class="student-dash-welcome__actions d-none d-md-flex">
            <a href="{{ route('student.dashboard') }}" class="btn btn-light btn-sm student-dash-btn-ghost">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Dashboard
            </a>
        </div>
    </div>
</section>

@if($course->image)
    <div class="student-course-hero mb-4">
        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="student-course-hero__img" loading="lazy">
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <section aria-labelledby="lessons-heading">
            <header class="student-dash-section-head">
                <div>
                    <h2 id="lessons-heading" class="student-dash-section-head__title">Lessons</h2>
                    <p class="student-dash-section-head__sub">Read and watch course content</p>
                </div>
                <span class="badge rounded-pill student-dash-badge">{{ $course->lessons->count() }}</span>
            </header>

            @if($course->lessons->isEmpty())
                <div class="student-dash-panel student-dash-panel--empty">
                    <i class="bi bi-collection-play student-dash-panel__empty-icon" aria-hidden="true"></i>
                    <p class="student-dash-panel__empty-text mb-0">No lessons available yet.</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($course->lessons as $lesson)
                        <div class="col-md-6">
                            <a href="{{ route('student.courses.lessons.show', [$course, $lesson]) }}" class="text-decoration-none d-block h-100">
                                <article class="student-dash-course-card h-100">
                                    <div class="student-dash-course-card__body">
                                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                            <span class="badge student-dash-badge student-dash-badge--muted">Lesson {{ $lesson->order }}</span>
                                            <i class="bi bi-play-circle text-primary fs-4" aria-hidden="true"></i>
                                        </div>
                                        <h3 class="student-dash-course-card__title">{{ $lesson->title }}</h3>
                                        <ul class="student-dash-meta list-unstyled mb-0">
                                            @if($lesson->video)
                                                <li><i class="bi bi-camera-video" aria-hidden="true"></i> Video included</li>
                                            @endif
                                            @if($lesson->pdf_notes)
                                                <li><i class="bi bi-file-earmark-pdf" aria-hidden="true"></i> PDF notes</li>
                                            @endif
                                        </ul>
                                    </div>
                                </article>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <div class="col-lg-5">
        <section aria-labelledby="quizzes-heading">
            <header class="student-dash-section-head">
                <div>
                    <h2 id="quizzes-heading" class="student-dash-section-head__title">Quizzes</h2>
                    <p class="student-dash-section-head__sub">Test your knowledge</p>
                </div>
                <span class="badge rounded-pill student-dash-badge">{{ $course->quizzes->count() }}</span>
            </header>

            @if($course->quizzes->isEmpty())
                <div class="student-dash-panel student-dash-panel--empty">
                    <i class="bi bi-patch-question student-dash-panel__empty-icon" aria-hidden="true"></i>
                    <p class="student-dash-panel__empty-text mb-0">No quizzes available yet.</p>
                </div>
            @else
                <div class="d-flex flex-column gap-3">
                    @foreach($course->quizzes as $quiz)
                        @php
                            $attemptCount = (int) ($submittedCounts[$quiz->id] ?? 0);
                            $latest = ($attemptsByQuiz[$quiz->id] ?? collect())->first();
                        @endphp
                        <article class="student-dash-panel">
                            <div class="student-dash-panel__body">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <h3 class="h6 mb-0">{{ $quiz->title }}</h3>
                                    @if($latest)
                                        <span class="badge rounded-pill {{ $latest->is_passed ? 'student-dash-badge student-dash-badge--success' : 'student-dash-badge student-dash-badge--muted' }}">
                                            {{ $latest->is_passed ? 'Passed' : 'Failed' }}
                                        </span>
                                    @endif
                                </div>
                                @if($quiz->description)
                                    <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit(strip_tags($quiz->description), 100) }}</p>
                                @endif
                                <ul class="student-dash-meta list-unstyled mb-3">
                                    <li><i class="bi bi-list-check" aria-hidden="true"></i> {{ $quiz->questions_count }} questions</li>
                                    <li><i class="bi bi-arrow-repeat" aria-hidden="true"></i> {{ $attemptCount }}/{{ $quiz->attempt_limit }} attempts</li>
                                    @if($quiz->duration_minutes)
                                        <li><i class="bi bi-clock" aria-hidden="true"></i> {{ $quiz->duration_minutes }} min</li>
                                    @endif
                                </ul>
                                @if($latest && $latest->submitted_at)
                                    <p class="small mb-2">Last score: <strong>{{ round((float) $latest->percentage) }}%</strong> ({{ $latest->obtained_marks }}/{{ $quiz->total_marks }})</p>
                                @endif
                                <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}" class="btn btn-sm btn-lms-primary">
                                    @if($attemptCount >= $quiz->attempt_limit)
                                        View results
                                    @elseif($attemptCount > 0)
                                        Try again
                                    @else
                                        Start quiz
                                    @endif
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
