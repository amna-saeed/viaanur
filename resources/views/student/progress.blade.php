@extends('student.layout')
@section('title', 'Progress overview')
@section('page_heading', 'Progress overview')

@section('content')

@if($enrollmentProgress->isEmpty())
    <div class="student-dash-panel student-dash-panel--empty">
        <i class="bi bi-graph-up student-dash-panel__empty-icon" aria-hidden="true"></i>
        <p class="student-dash-panel__empty-title">No progress yet</p>
        <p class="student-dash-panel__empty-text mb-3">Enroll in a course from your dashboard to start tracking progress.</p>
        <a href="{{ route('student.dashboard') }}#catalog-heading" class="btn btn-lms-primary btn-sm">Browse courses</a>
    </div>
@else
    <section class="mb-4 mb-lg-5" aria-labelledby="progress-cards-heading">
        <header class="student-dash-section-head">
            <div>
                <h2 id="progress-cards-heading" class="student-dash-section-head__title">Course progress</h2>
                <p class="student-dash-section-head__sub">Quiz completion for each enrolled course</p>
            </div>
        </header>
        <div class="row g-3 g-lg-4">
            @foreach($enrollmentProgress as $row)
                @php
                    $progress = (int) $row['progress'];
                    $course = $row['course'];
                @endphp
                <div class="col-md-6 col-xl-4">
                    <article class="student-progress-card h-100">
                        <div class="student-progress-card__head">
                            <h3 class="student-progress-card__title">{{ $course->title }}</h3>
                            <span class="student-progress-card__pct">{{ $progress }}%</span>
                        </div>
                        <div class="student-dash-progress mb-3" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progress for {{ $course->title }}">
                            <div class="student-dash-progress__bar {{ $progress >= 75 ? 'student-dash-progress__bar--high' : ($progress >= 40 ? 'student-dash-progress__bar--mid' : '') }}" style="width: {{ $progress > 0 ? $progress : 5 }}%"></div>
                        </div>
                        <ul class="student-dash-meta list-unstyled mb-3">
                            <li><i class="bi bi-collection-play" aria-hidden="true"></i> {{ $row['lessons_count'] }} lessons</li>
                            <li><i class="bi bi-patch-question" aria-hidden="true"></i> {{ $row['attempted_quizzes'] }}/{{ $row['total_quizzes'] }} quizzes</li>
                            <li><i class="bi bi-calendar3" aria-hidden="true"></i> Enrolled {{ $row['enrollment']->created_at->format('M j, Y') }}</li>
                        </ul>
                        <a href="{{ student_course_route('student.courses.show', $course) }}" class="btn btn-sm btn-lms-primary w-100">
                            Continue learning
                        </a>
                    </article>
                </div>
            @endforeach
        </div>
    </section>

    <section aria-labelledby="progress-table-heading">
        <header class="student-dash-section-head">
            <div>
                <h2 id="progress-table-heading" class="student-dash-section-head__title">Detailed overview</h2>
                <p class="student-dash-section-head__sub">Full breakdown by course</p>
            </div>
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
                                    $progress = (int) $row['progress'];
                                    $course = $row['course'];
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $course->title }}</td>
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
                                        <a href="{{ student_course_route('student.courses.show', $course) }}" class="btn btn-sm btn-outline-primary">Open</a>
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
