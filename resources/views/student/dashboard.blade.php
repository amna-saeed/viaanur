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
            <p class="student-dash-welcome__text mb-0">Track your approved courses, pending requests, and stay updated with announcements.</p>
        </div>
        <div class="student-dash-welcome__actions d-none d-md-flex">
            <a href="{{ route('student.my-courses') }}" class="btn btn-light btn-sm student-dash-btn-ghost">
                <i class="bi bi-journal-bookmark" aria-hidden="true"></i> My courses
            </a>
            <a href="{{ route('contact-us') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-chat-dots" aria-hidden="true"></i> Get help
            </a>
        </div>
    </div>
</section>

<section class="mb-4 mb-lg-5" aria-labelledby="student-stats-heading">
    <header class="student-dash-section-head student-dash-section-head--compact">
        <div>
            <h2 id="student-stats-heading" class="student-dash-section-head__title">Overview</h2>
            <p class="student-dash-section-head__sub">Your learning activity at a glance</p>
        </div>
        @if($enrollmentProgress->isNotEmpty())
            <a href="{{ route('student.progress') }}" class="btn btn-sm btn-outline-primary">View all progress</a>
        @endif
    </header>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-5 g-3 g-lg-4">
        <div class="col">
            <a href="{{ route('student.my-courses') }}" class="text-decoration-none d-block h-100">
                <article class="student-dash-stat student-dash-stat--primary h-100" data-hs-widget="student-stat">
                    <div class="student-dash-stat__icon" aria-hidden="true"><i class="bi bi-bookmark-check-fill"></i></div>
                    <div class="student-dash-stat__body">
                        <span class="student-dash-stat__label">My courses</span>
                        <span class="student-dash-stat__value">{{ $summary['enrolled_count'] }}</span>
                    </div>
                </article>
            </a>
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

<section class="mb-4 mb-lg-5" aria-labelledby="student-quick-links-heading">
    <header class="student-dash-section-head student-dash-section-head--compact">
        <h2 id="student-quick-links-heading" class="student-dash-section-head__title">Quick access</h2>
        <p class="student-dash-section-head__sub">Open your courses, attendance, and progress</p>
    </header>
    <div class="row g-3 g-lg-4">
        <div class="col-md-4">
            <a href="{{ route('student.my-courses') }}" class="student-dash-quick-link">
                <span class="student-dash-quick-link__icon student-dash-quick-link__icon--primary" aria-hidden="true"><i class="bi bi-journal-bookmark-fill"></i></span>
                <span class="student-dash-quick-link__body">
                    <span class="student-dash-quick-link__title">My courses</span>
                    <span class="student-dash-quick-link__text">{{ $summary['enrolled_count'] }} enrolled · View all courses</span>
                </span>
                <i class="bi bi-chevron-right student-dash-quick-link__arrow" aria-hidden="true"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('student.attendance') }}" class="student-dash-quick-link">
                <span class="student-dash-quick-link__icon student-dash-quick-link__icon--teal" aria-hidden="true"><i class="bi bi-calendar-check-fill"></i></span>
                <span class="student-dash-quick-link__body">
                    <span class="student-dash-quick-link__title">Attendance</span>
                    <span class="student-dash-quick-link__text">
                        @if($summary['attendance_percentage'] !== null)
                            {{ number_format((float) $summary['attendance_percentage'], 1) }}% rate · Leave requests
                        @else
                            View records · Request leave
                        @endif
                    </span>
                </span>
                <i class="bi bi-chevron-right student-dash-quick-link__arrow" aria-hidden="true"></i>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('student.progress') }}" class="student-dash-quick-link">
                <span class="student-dash-quick-link__icon student-dash-quick-link__icon--violet" aria-hidden="true"><i class="bi bi-graph-up-arrow"></i></span>
                <span class="student-dash-quick-link__body">
                    <span class="student-dash-quick-link__title">Progress</span>
                    <span class="student-dash-quick-link__text">Quiz completion by course</span>
                </span>
                <i class="bi bi-chevron-right student-dash-quick-link__arrow" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</section>

<div class="row g-4 g-xl-5 align-items-start">
    <div class="col-12 col-xl-7">
        @include('student.partials.dashboard-highlights')
    </div>

    <div class="col-12 col-xl-5 student-dash-sidebar-col">
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

<section class="student-dash-recent mt-4 mt-xl-5" aria-labelledby="recent-activity-heading">
    <header class="student-dash-section-head">
        <div>
            <h2 id="recent-activity-heading" class="student-dash-section-head__title">Recent activity</h2>
            <p class="student-dash-section-head__sub">Your latest enrollments and quiz results</p>
        </div>
    </header>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="student-dash-panel student-dash-panel--table h-100">
                <div class="student-dash-panel__head d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <h3 class="student-dash-panel__title mb-0">Recent enrollments</h3>
                    <a href="{{ route('student.my-courses') }}" class="btn btn-sm btn-outline-primary">My courses</a>
                </div>
                <div class="student-dash-panel__body student-dash-panel__body--flush">
                    @if($recentEnrollmentActivity->isEmpty())
                        <div class="student-dash-panel student-dash-panel--empty student-dash-panel--empty-inline">
                            <i class="bi bi-journal-bookmark student-dash-panel__empty-icon" aria-hidden="true"></i>
                            <p class="student-dash-panel__empty-text mb-0">No enrollments yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover student-dash-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Enrolled</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEnrollmentActivity as $enrollment)
                                        <tr>
                                            <td class="fw-semibold">{{ optional($enrollment->course)->title ?? 'Course removed' }}</td>
                                            <td class="text-muted">{{ $enrollment->created_at->format('M j, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="student-dash-panel student-dash-panel--table h-100">
                <div class="student-dash-panel__head">
                    <h3 class="student-dash-panel__title mb-0">Recent quiz attempts</h3>
                </div>
                <div class="student-dash-panel__body student-dash-panel__body--flush">
                    @if($recentQuizAttempts->isEmpty())
                        <div class="student-dash-panel student-dash-panel--empty student-dash-panel--empty-inline">
                            <i class="bi bi-clipboard-x student-dash-panel__empty-icon" aria-hidden="true"></i>
                            <p class="student-dash-panel__empty-text mb-0">No quiz attempts yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover student-dash-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Quiz</th>
                                        <th>Course</th>
                                        <th>Score</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentQuizAttempts as $attempt)
                                        <tr>
                                            <td class="fw-semibold">{{ optional($attempt->quiz)->title ?? 'Quiz removed' }}</td>
                                            <td class="text-muted">{{ optional(optional($attempt->quiz)->course)->title ?? '—' }}</td>
                                            <td>
                                                @if($attempt->percentage !== null)
                                                    <span class="badge rounded-pill {{ $attempt->is_passed ? 'student-dash-badge student-dash-badge--success' : 'student-dash-badge student-dash-badge--muted' }}">
                                                        {{ round((float) $attempt->percentage) }}%
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ optional($attempt->submitted_at)->format('M j, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if(!empty($pendingEnrollments) && $pendingEnrollments->isNotEmpty())
<section class="student-dash-catalog mt-4 mt-xl-5 pt-2" aria-labelledby="pending-enrollments-heading">
    <header class="student-dash-section-head">
        <div>
            <h2 id="pending-enrollments-heading" class="student-dash-section-head__title">Pending approval</h2>
            <p class="student-dash-section-head__sub">These courses will appear in My Courses after admin approval</p>
        </div>
        <span class="badge rounded-pill student-dash-badge bg-warning text-dark">{{ $pendingEnrollments->count() }} waiting</span>
    </header>
    <div class="row g-3 g-lg-4">
        @foreach($pendingEnrollments as $pending)
            <div class="col-sm-6 col-lg-4">
                <article class="student-dash-course-card student-dash-course-card--catalog h-100 border border-warning">
                    <div class="student-dash-course-card__body">
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                            <h3 class="student-dash-course-card__title">{{ $pending->course->title }}</h3>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </div>
                        @if($pending->course->description)
                            <p class="student-dash-course-card__desc">{{ \Illuminate\Support\Str::limit(strip_tags($pending->course->description), 95) }}</p>
                        @endif
                        <p class="small text-muted mb-0">
                            <i class="bi bi-clock-history me-1"></i> Requested {{ $pending->created_at->format('M j, Y') }}
                        </p>
                    </div>
                </article>
            </div>
        @endforeach
    </div>
</section>
@endif

<section class="student-dash-catalog mt-4 mt-xl-5 pt-2" aria-labelledby="catalog-heading">
    <header class="student-dash-section-head">
        <div>
            <h2 id="catalog-heading" class="student-dash-section-head__title">Course catalog</h2>
            <p class="student-dash-section-head__sub">Only courses approved by your administrator</p>
        </div>
        @if($summary['catalog_count'] > 0)
            <span class="badge rounded-pill student-dash-badge student-dash-badge--muted">{{ $summary['catalog_count'] }} available</span>
        @endif
    </header>

    @if($catalog->isEmpty())
        <div class="student-dash-panel student-dash-panel--empty">
            <i class="bi bi-inboxes student-dash-panel__empty-icon" aria-hidden="true"></i>
            <p class="student-dash-panel__empty-title">No approved courses yet</p>
            <p class="student-dash-panel__empty-text mb-0">Courses will appear here after your administrator approves your enrollment request.</p>
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
                            <a href="{{ route('student.courses.show', $course) }}" class="btn btn-lms-primary w-100 mt-auto">
                                <i class="bi bi-journal-bookmark" aria-hidden="true"></i> Open course
                            </a>
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
