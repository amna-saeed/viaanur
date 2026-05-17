@extends('student.layout')
@section('title', 'Student dashboard')
@section('page_heading', 'Student dashboard')

@section('content')
@if(isset($canClaimAdmin) && $canClaimAdmin && !auth()->user()->isAdmin())
    <div class="alert alert-success border-0 student-lms-alert student-lms-alert--claim d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4" role="status">
        <div>
            <strong class="d-block">No admin yet. You can claim admin access to manage the LMS.</strong>
            <span class="small opacity-90">You will be able to open the admin dashboard and manage courses, students, and enrollments.</span>
        </div>
        <a href="{{ route('claim-admin') }}" class="btn btn-success btn-sm px-3">Become admin</a>
    </div>
@endif

<section class="student-dash-welcome mb-4" aria-labelledby="student-welcome-heading">
    <div class="student-dash-welcome__inner">
        <div class="student-dash-welcome__copy">
            <p class="student-dash-welcome__eyebrow mb-2">Welcome back</p>
            <h2 id="student-welcome-heading" class="student-dash-welcome__title">{{ auth()->user()->name }}</h2>
            <p class="student-dash-welcome__text mb-0">Track enrollments, explore new courses, and stay updated with announcements.</p>
        </div>
        <div class="student-dash-welcome__actions d-none d-md-flex">
            <a href="#catalog-heading" class="btn btn-light btn-sm student-dash-btn-ghost">
                <i class="bi bi-compass" aria-hidden="true"></i> Browse catalog
            </a>
            <a href="{{ route('contact-us') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-chat-dots" aria-hidden="true"></i> Get help
            </a>
        </div>
    </div>
</section>

<section class="mb-4 mb-lg-5" aria-labelledby="student-stats-heading">
    <header class="student-dash-section-head student-dash-section-head--compact">
        <h2 id="student-stats-heading" class="student-dash-section-head__title">Overview</h2>
        <p class="student-dash-section-head__sub">Your learning activity at a glance</p>
    </header>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-5 g-3 g-lg-4">
        <div class="col">
            <article class="student-dash-stat student-dash-stat--primary" data-hs-widget="student-stat">
                <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-bookmark-check-fill"></i></div>
                <div class="student-dash-stat__body">
                    <span class="student-dash-stat__label">My courses</span>
                    <span class="student-dash-stat__value">{{ $summary['enrolled_count'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="student-dash-stat student-dash-stat--violet" data-hs-widget="student-stat">
                <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-journal-richtext"></i></div>
                <div class="student-dash-stat__body">
                    <span class="student-dash-stat__label">Lessons available</span>
                    <span class="student-dash-stat__value">{{ $summary['lessons_in_enrolled'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="student-dash-stat student-dash-stat--amber" data-hs-widget="student-stat">
                <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-patch-question-fill"></i></div>
                <div class="student-dash-stat__body">
                    <span class="student-dash-stat__label">Quizzes available</span>
                    <span class="student-dash-stat__value">{{ $summary['quizzes_in_enrolled'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="student-dash-stat student-dash-stat--teal" data-hs-widget="student-stat">
                <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-clipboard-data-fill"></i></div>
                <div class="student-dash-stat__body">
                    <span class="student-dash-stat__label">Quiz attempts</span>
                    <span class="student-dash-stat__value">{{ $summary['quiz_attempts'] }}</span>
                    @if($summary['quiz_avg_percent'] !== null)
                        <span class="student-dash-stat__hint">Avg {{ round((float) $summary['quiz_avg_percent']) }}%</span>
                    @endif
                </div>
            </article>
        </div>
        <div class="col">
            <article class="student-dash-stat student-dash-stat--rose" data-hs-widget="student-stat">
                <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-megaphone-fill"></i></div>
                <div class="student-dash-stat__body">
                    <span class="student-dash-stat__label">Announcements</span>
                    <span class="student-dash-stat__value">{{ $summary['announcements_count'] }}</span>
                </div>
            </article>
        </div>
    </div>
</section>

<div class="row g-4 g-xl-5 align-items-start">
    <div class="col-12 col-xl-7">
        <section aria-labelledby="my-courses-heading">
            <header class="student-dash-section-head">
                <div>
                    <h2 id="my-courses-heading" class="student-dash-section-head__title">My courses</h2>
                    <p class="student-dash-section-head__sub">Courses you are currently enrolled in</p>
                </div>
                @if($enrollments->isNotEmpty())
                    <span class="badge rounded-pill student-dash-badge">{{ $enrollments->count() }} active</span>
                @endif
            </header>

            @if($enrollments->isEmpty())
                <div class="student-dash-panel student-dash-panel--empty">
                    <i class="bi bi-journal-bookmark student-dash-panel__empty-icon" aria-hidden="true"></i>
                    <p class="student-dash-panel__empty-title">No enrollments yet</p>
                    <p class="student-dash-panel__empty-text mb-0">Browse the catalog below and enroll in a course to get started.</p>
                </div>
            @else
                <div class="row g-3 g-lg-4">
                    @foreach($enrollments as $enrollment)
                        @if($course = $enrollment->course)
                            @php
                                $tried = (int) ($quizzesTriedByCourseId[$course->id] ?? 0);
                                $totalQuizzes = (int) $course->quizzes_count;
                                $progressPct = $totalQuizzes > 0 ? min(100, (int) round($tried / $totalQuizzes * 100)) : 0;
                            @endphp
                            <div class="col-md-6">
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
                                            <p class="student-dash-course-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 100) }}</p>
                                        @endif
                                        <ul class="student-dash-meta list-unstyled mb-3">
                                            <li><i class="bi bi-collection-play" aria-hidden="true"></i> {{ (int) $course->lessons_count }} lessons</li>
                                            <li><i class="bi bi-patch-question" aria-hidden="true"></i> {{ (int) $course->quizzes_count }} quizzes</li>
                                            <li><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $enrollment->created_at->format('M j, Y') }}</li>
                                        </ul>
                                        @if($totalQuizzes > 0)
                                            <div class="student-dash-progress-wrap">
                                                <div class="student-dash-progress-label">
                                                    <span>Quiz engagement</span>
                                                    <span class="student-dash-progress-value">{{ $tried }}/{{ $totalQuizzes }}</span>
                                                </div>
                                                <div class="student-dash-progress" role="progressbar" aria-valuenow="{{ $progressPct }}" aria-valuemin="0" aria-valuemax="100" aria-label="Quiz engagement for {{ $course->title }}">
                                                    <div class="student-dash-progress__bar" style="width: {{ $progressPct }}%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <div class="col-12 col-xl-5">
        <section aria-labelledby="announcements-heading">
            <header class="student-dash-section-head">
                <div>
                    <h2 id="announcements-heading" class="student-dash-section-head__title">Announcements</h2>
                    <p class="student-dash-section-head__sub">Latest updates from your school</p>
                </div>
            </header>
            <div class="student-dash-panel" data-hs-widget="announcements">
                <div class="student-dash-panel__head">
                    <h3 class="student-dash-panel__title mb-0"><i class="bi bi-bell" aria-hidden="true"></i> Latest updates</h3>
                </div>
                <div class="student-dash-panel__body student-dash-panel__body--flush">
                    @if($announcements->isEmpty())
                        <div class="student-dash-panel student-dash-panel--empty student-dash-panel--empty-inline">
                            <i class="bi bi-inbox student-dash-panel__empty-icon" aria-hidden="true"></i>
                            <p class="student-dash-panel__empty-text mb-0">No announcements yet.</p>
                        </div>
                    @else
                        <ul class="student-dash-feed list-unstyled mb-0">
                            @foreach($announcements as $announcement)
                                <li class="student-dash-feed__item">
                                    <h4 class="student-dash-feed__title">{{ $announcement->title }}</h4>
                                    <time class="student-dash-feed__date" datetime="{{ ($announcement->published_at ?? $announcement->created_at)->toIso8601String() }}">
                                        {{ ($announcement->published_at ?? $announcement->created_at)->format('M j, Y') }}
                                    </time>
                                    <p class="student-dash-feed__body">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->body), 220) }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<section class="student-dash-catalog mt-4 mt-xl-5 pt-2" aria-labelledby="catalog-heading">
    <header class="student-dash-section-head">
        <div>
            <h2 id="catalog-heading" class="student-dash-section-head__title">Course catalog</h2>
            <p class="student-dash-section-head__sub">Discover and enroll in published courses</p>
        </div>
        @if($summary['catalog_count'] > 0)
            <span class="badge rounded-pill student-dash-badge student-dash-badge--muted">{{ $summary['catalog_count'] }} available</span>
        @endif
    </header>

    @if($catalog->isEmpty())
        <div class="student-dash-panel student-dash-panel--empty">
            <i class="bi bi-inboxes student-dash-panel__empty-icon" aria-hidden="true"></i>
            <p class="student-dash-panel__empty-title">All caught up</p>
            <p class="student-dash-panel__empty-text mb-0">There are no additional published courses to join right now.</p>
        </div>
    @else
        <div class="row g-3 g-lg-4">
            @foreach($catalog as $course)
                <div class="col-sm-6 col-lg-4">
                    <article class="student-dash-course-card student-dash-course-card--catalog h-100">
                        @if($course->image)
                            <img class="student-dash-course-card__media" src="{{ asset('storage/' . $course->image) }}" alt="Course image: {{ $course->title }}" width="640" height="360" loading="lazy" decoding="async">
                        @else
                            <div class="student-dash-course-card__media student-dash-course-card__media--placeholder" aria-hidden="true">
                                <i class="bi bi-book"></i>
                            </div>
                        @endif
                        <div class="student-dash-course-card__body">
                            <h3 class="student-dash-course-card__title">{{ $course->title }}</h3>
                            @if($course->description)
                                <p class="student-dash-course-card__desc flex-grow-1">{{ \Illuminate\Support\Str::limit(strip_tags($course->description), 95) }}</p>
                            @endif
                            <ul class="student-dash-meta list-unstyled mb-3">
                                <li><i class="bi bi-collection-play" aria-hidden="true"></i> {{ (int) $course->lessons_count }} lessons</li>
                                <li><i class="bi bi-patch-question" aria-hidden="true"></i> {{ (int) $course->quizzes_count }} quizzes</li>
                            </ul>
                            <form action="{{ route('student.courses.enroll', $course) }}" method="post" class="mt-auto">
                                @csrf
                                <button type="submit" class="btn btn-lms-primary w-100 student-dash-btn-enroll">
                                    <i class="bi bi-plus-circle" aria-hidden="true"></i> Enroll now
                                </button>
                            </form>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</section>

<nav class="student-dash-footer-nav mt-4 pt-4" aria-label="Secondary">
    <a href="{{ route('contact-us') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-headset" aria-hidden="true"></i> Contact support
    </a>
</nav>
@endsection
