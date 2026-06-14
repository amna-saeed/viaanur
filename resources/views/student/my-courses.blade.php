@extends('student.layout')
@section('title', 'My courses')
@section('page_heading', 'My courses')

@section('content')

@if($enrollmentProgress->isEmpty())
    <div class="student-dash-panel student-dash-panel--empty">
        <i class="bi bi-journal-bookmark student-dash-panel__empty-icon" aria-hidden="true"></i>
        <p class="student-dash-panel__empty-title">No enrollments yet</p>
        <p class="student-dash-panel__empty-text mb-3">Browse the course catalog on your dashboard and enroll to start learning.</p>
        <a href="{{ route('student.dashboard') }}#catalog-heading" class="btn btn-lms-primary btn-sm">Browse catalog</a>
    </div>
@else
    <section class="mb-4 mb-lg-5" aria-labelledby="my-courses-summary-heading">
        <header class="student-dash-section-head">
            <div>
                <h2 id="my-courses-summary-heading" class="student-dash-section-head__title">Enrolled courses</h2>
                <p class="student-dash-section-head__sub">All courses you are currently enrolled in</p>
            </div>
            <span class="badge rounded-pill student-dash-badge">{{ $progressSummary['course_count'] }} active</span>
        </header>
        <div class="row g-3 g-lg-4">
            <div class="col-6 col-md-3">
                <article class="student-dash-stat student-dash-stat--primary">
                    <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-bookmark-check-fill"></i></div>
                    <div class="student-dash-stat__body">
                        <span class="student-dash-stat__label">Courses</span>
                        <span class="student-dash-stat__value">{{ $progressSummary['course_count'] }}</span>
                    </div>
                </article>
            </div>
            <div class="col-6 col-md-3">
                <article class="student-dash-stat student-dash-stat--violet">
                    <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-collection-play-fill"></i></div>
                    <div class="student-dash-stat__body">
                        <span class="student-dash-stat__label">Lessons</span>
                        <span class="student-dash-stat__value">{{ $progressSummary['total_lessons'] }}</span>
                    </div>
                </article>
            </div>
            <div class="col-6 col-md-3">
                <article class="student-dash-stat student-dash-stat--amber">
                    <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-patch-question-fill"></i></div>
                    <div class="student-dash-stat__body">
                        <span class="student-dash-stat__label">Quizzes tried</span>
                        <span class="student-dash-stat__value">{{ $progressSummary['attempted_quizzes'] }}/{{ $progressSummary['total_quizzes'] }}</span>
                    </div>
                </article>
            </div>
            <div class="col-6 col-md-3">
                <article class="student-dash-stat student-dash-stat--teal">
                    <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-trophy-fill"></i></div>
                    <div class="student-dash-stat__body">
                        <span class="student-dash-stat__label">Completed</span>
                        <span class="student-dash-stat__value">{{ $progressSummary['completed_courses'] }}</span>
                        <span class="student-dash-stat__hint">100% quiz progress</span>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="mb-4 mb-lg-5" aria-labelledby="my-courses-cards-heading">
        <header class="student-dash-section-head student-dash-section-head--compact">
            <h2 id="my-courses-cards-heading" class="student-dash-section-head__title">Course cards</h2>
        </header>
        <div class="row g-3 g-lg-4">
            @foreach($enrollmentProgress as $row)
                @php
                    $course = $row['course'];
                    $enrollment = $row['enrollment'];
                    $progress = (int) $row['progress'];
                @endphp
                <div class="col-md-6 col-xl-4">
                    <article class="student-dash-course-card h-100">
                        @if($course->image)
                            <img class="student-dash-course-card__media" src="{{ asset('storage/' . $course->image) }}" alt="Course image: {{ $course->title }}" width="640" height="360" loading="lazy" decoding="async">
                        @else
                            <div class="student-dash-course-card__media student-dash-course-card__media--placeholder" aria-hidden="true">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                        @endif
                        <div class="student-dash-course-card__body">
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                <h3 class="student-dash-course-card__title">{{ $course->title }}</h3>
                                <span class="badge student-dash-badge student-dash-badge--success">Enrolled</span>
                            </div>
                            @if($course->description)
                                <p class="student-dash-course-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 140) }}</p>
                            @endif
                            <ul class="student-dash-meta list-unstyled mb-3">
                                <li><i class="bi bi-collection-play" aria-hidden="true"></i> {{ $row['lessons_count'] }} lessons</li>
                                <li><i class="bi bi-patch-question" aria-hidden="true"></i> {{ $row['attempted_quizzes'] }}/{{ $row['total_quizzes'] }} quizzes</li>
                                <li><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $enrollment->created_at->format('M j, Y') }}</li>
                            </ul>
                            <div class="student-dash-progress-wrap">
                                <div class="student-dash-progress-label">
                                    <span>Progress</span>
                                    <span class="student-dash-progress-value">{{ $progress }}%</span>
                                </div>
                                <div class="student-dash-progress" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progress for {{ $course->title }}">
                                    <div class="student-dash-progress__bar {{ $progress >= 75 ? 'student-dash-progress__bar--high' : ($progress >= 40 ? 'student-dash-progress__bar--mid' : '') }}" style="width: {{ $progress > 0 ? $progress : 5 }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('student.courses.show', $course) }}" class="btn btn-sm btn-lms-primary mt-3 w-100">
                                <i class="bi bi-journal-bookmark" aria-hidden="true"></i> Open course
                            </a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </section>

    <section aria-labelledby="my-courses-table-heading">
        <header class="student-dash-section-head">
            <div>
                <h2 id="my-courses-table-heading" class="student-dash-section-head__title">Complete list</h2>
                <p class="student-dash-section-head__sub">Full details for every enrolled course</p>
            </div>
            <a href="{{ route('student.progress') }}" class="btn btn-sm btn-outline-primary">Progress overview</a>
        </header>
        <div class="student-dash-panel student-dash-panel--table">
            <div class="student-dash-panel__body student-dash-panel__body--flush">
                <div class="table-responsive">
                    <table class="table table-hover student-dash-table mb-0">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Lessons</th>
                                <th>Quizzes</th>
                                <th>Enrolled</th>
                                <th>Progress</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollmentProgress as $row)
                                @php
                                    $course = $row['course'];
                                    $progress = (int) $row['progress'];
                                @endphp
                                <tr>
                                    <td>
                                        <span class="fw-semibold d-block">{{ $course->title }}</span>
                                        @if($course->description)
                                            <span class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 80) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $row['lessons_count'] }}</td>
                                    <td>{{ $row['attempted_quizzes'] }}/{{ $row['total_quizzes'] }}</td>
                                    <td class="text-muted">{{ $row['enrollment']->created_at->format('M j, Y') }}</td>
                                    <td style="min-width: 9rem;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="student-dash-progress flex-grow-1" style="height: 0.5rem;" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                <div class="student-dash-progress__bar" style="width: {{ $progress > 0 ? $progress : 5 }}%"></div>
                                            </div>
                                            <span class="small fw-semibold text-muted">{{ $progress }}%</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-sm btn-outline-primary">Open</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection
