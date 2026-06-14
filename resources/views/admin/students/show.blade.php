@extends('admin.layout')
@section('title', $student->name)
@section('page_heading', 'Student Profile')

@section('content')
@php $profile = $student->studentProfile; @endphp

{{-- Hero header --}}
<div class="sp-hero mb-4">
    <div class="sp-hero__avatar" aria-hidden="true">
        {{ strtoupper(substr($student->name, 0, 1)) }}
    </div>
    <div class="sp-hero__body">
        <h2 class="sp-hero__name">{{ $student->name }}</h2>
        <div class="sp-hero__meta">
            <span><i class="bi bi-envelope me-1"></i>{{ $student->email }}</span>
            @if($profile)
                <span class="sp-hero__sep" aria-hidden="true">·</span>
                <span><i class="bi bi-person-vcard me-1"></i>{{ $profile->student_id_number }}</span>
            @endif
            <span class="sp-hero__sep" aria-hidden="true">·</span>
            <span><i class="bi bi-calendar3 me-1"></i>Joined {{ $student->created_at->format('M d, Y') }}</span>
        </div>
    </div>
    <div class="sp-hero__actions">
        <a href="{{ route('admin.students.edit', $student) }}" class="btn sp-hero__edit-btn">
            <i class="bi bi-pencil me-1"></i> Edit Profile
        </a>
    </div>
</div>

{{-- Quick stats row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="sp-quick-stat sp-quick-stat--purple">
            <div class="sp-quick-stat__icon"><i class="bi bi-book-fill"></i></div>
            <div class="sp-quick-stat__value">{{ $student->enrolledCourses->count() }}</div>
            <div class="sp-quick-stat__label">Courses</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="sp-quick-stat sp-quick-stat--teal">
            <div class="sp-quick-stat__icon"><i class="bi bi-pencil-square"></i></div>
            <div class="sp-quick-stat__value">{{ $student->quizAttempts ? $student->quizAttempts->count() : 0 }}</div>
            <div class="sp-quick-stat__label">Quiz Attempts</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="sp-quick-stat sp-quick-stat--lime">
            <div class="sp-quick-stat__icon"><i class="bi bi-person-check"></i></div>
            <div class="sp-quick-stat__value">{{ $profile ? 'Complete' : 'Pending' }}</div>
            <div class="sp-quick-stat__label">Profile</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="sp-quick-stat sp-quick-stat--amber">
            <div class="sp-quick-stat__icon"><i class="bi bi-clock-history"></i></div>
            <div class="sp-quick-stat__value">
                @if($student->last_active_at)
                    {{ $student->last_active_at->diffForHumans(null, true) }}
                @else
                    Never
                @endif
            </div>
            <div class="sp-quick-stat__label">Last Active</div>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- Left column --}}
    <div class="col-lg-8">

        {{-- Personal Information --}}
        <div class="ad-panel mb-4">
            <div class="ad-panel__head sp-panel-head">
                <div class="sp-panel-icon sp-panel-icon--purple"><i class="bi bi-person-badge-fill"></i></div>
                <h3 class="ad-panel__title">Personal Information</h3>
            </div>
            <div class="ad-panel__body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Student ID Number</span>
                            <span class="sp-field__value">
                                @if($profile)
                                    <span class="sp-id-code">{{ $profile->student_id_number }}</span>
                                @else
                                    <span class="sp-not-set">Not completed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Full Name</span>
                            <span class="sp-field__value">{{ $student->name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Email Address</span>
                            <span class="sp-field__value">{{ $student->email }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Date of Birth</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->date_of_birth)
                                    {{ $profile->date_of_birth->format('M d, Y') }}
                                @else
                                    <span class="sp-not-set">Not provided</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Gender</span>
                            <span class="sp-field__value">
                                @if($profile)
                                    {{ $genderOptions[$profile->gender] ?? ucfirst(str_replace('_', ' ', $profile->gender)) }}
                                @else
                                    <span class="sp-not-set">Not completed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">School Name</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->school_name)
                                    {{ $profile->school_name }}
                                @else
                                    <span class="sp-not-set">Not applicable</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Phone</span>
                            <span class="sp-field__value">
                                @if($student->phone)
                                    {{ $student->phone }}
                                @else
                                    <span class="sp-not-set">Not provided</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Member Since</span>
                            <span class="sp-field__value">{{ $student->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sp-field">
                            <span class="sp-field__label">Home Address</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->home_address)
                                    {{ $profile->home_address }}
                                @else
                                    <span class="sp-not-set">Not completed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Guardian & Emergency Contacts --}}
        <div class="ad-panel mb-4">
            <div class="ad-panel__head sp-panel-head">
                <div class="sp-panel-icon sp-panel-icon--rose"><i class="bi bi-shield-check"></i></div>
                <h3 class="ad-panel__title">Guardian &amp; Emergency Contacts</h3>
            </div>
            <div class="ad-panel__body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Parent / Guardian Name</span>
                            <span class="sp-field__value">
                                @if($profile)
                                    {{ $profile->guardian_name }}
                                @else
                                    <span class="sp-not-set">Not completed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Guardian Contact Number</span>
                            <span class="sp-field__value">
                                @if($profile)
                                    {{ $profile->guardian_contact_number }}
                                @else
                                    <span class="sp-not-set">Not completed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Emergency Contact Number</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->emergency_contact_number)
                                    {{ $profile->emergency_contact_number }}
                                @elseif($profile)
                                    <span class="sp-not-set">Same as guardian</span>
                                @else
                                    <span class="sp-not-set">Not completed</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dashboard Metrics & Academic Info (editable form) --}}
        <form action="{{ route('admin.students.profile-records.update', $student) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="ad-panel mb-4">
                <div class="ad-panel__head sp-panel-head justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="sp-panel-icon sp-panel-icon--lime"><i class="bi bi-activity"></i></div>
                        <h3 class="ad-panel__title mb-0">Dashboard Metrics</h3>
                    </div>
                    @if($profile)
                        <span class="sp-editable-badge"><i class="bi bi-pencil me-1"></i>Editable</span>
                    @endif
                </div>
                <div class="ad-panel__body">
                    @unless($profile)
                        <div class="sp-notice sp-notice--warning">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Complete the student's basic information before saving dashboard and academic records.
                            <a href="{{ route('admin.students.edit', $student) }}" class="sp-notice__link">Edit student</a>
                        </div>
                    @else
                        @if($student->last_active_at)
                            <div class="sp-field mb-4">
                                <span class="sp-field__label">Last Active</span>
                                <span class="sp-field__value">{{ $student->last_active_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        @include('partials.student-dashboard-metrics-fields', ['profile' => $profile, 'student' => $student])
                    @endunless
                </div>
            </div>

            @if($profile)
                <div class="ad-panel mb-4">
                    <div class="ad-panel__head sp-panel-head">
                        <div class="sp-panel-icon sp-panel-icon--purple"><i class="bi bi-mortarboard-fill"></i></div>
                        <h3 class="ad-panel__title">Academic Information</h3>
                    </div>
                    <div class="ad-panel__body">
                        @include('partials.student-academic-info-fields', ['profile' => $profile])
                        <div class="sp-save-row mt-4 pt-3">
                            <button type="submit" class="btn sp-save-btn">
                                <i class="bi bi-floppy-fill me-2"></i>Save Dashboard &amp; Academic Records
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </form>

        {{-- Enrolled Courses --}}
        <div class="ad-panel">
            <div class="ad-panel__head sp-panel-head">
                <div class="sp-panel-icon sp-panel-icon--teal"><i class="bi bi-book-half"></i></div>
                <h3 class="ad-panel__title">Enrolled Courses</h3>
                @if(!$student->enrolledCourses->isEmpty())
                    <span class="sp-count-badge ms-auto">{{ $student->enrolledCourses->count() }}</span>
                @endif
            </div>
            <div class="ad-panel__body ad-panel__body--flush">
                @if($student->enrolledCourses->isEmpty())
                    <div class="ad-empty">
                        <i class="bi bi-inbox d-block mb-2"></i>
                        No courses enrolled yet.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table admin-lms-table mb-0">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Enrolled On</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->enrolledCourses as $course)
                                    @php
                                        $enrollment     = $student->lmsEnrollments->where('course_id', $course->id)->first();
                                        $totalQuizzes   = $course->quizzes->count();
                                        $attemptedQuizzes = $student->quizAttempts()->whereIn('quiz_id', $course->quizzes->pluck('id'))->count();
                                        $progress       = $totalQuizzes > 0 ? round(($attemptedQuizzes / $totalQuizzes) * 100) : 0;
                                        $progColor      = $progress >= 75 ? '#0d9488' : ($progress >= 50 ? '#322f89' : ($progress > 0 ? '#d97706' : '#cbd5e1'));
                                    @endphp
                                    <tr>
                                        <td class="fw-500">{{ $course->title }}</td>
                                        <td class="text-muted">
                                            {{ $enrollment ? $enrollment->created_at->format('M d, Y') : '—' }}
                                        </td>
                                        <td>
                                            <div class="sp-progress-wrap">
                                                <div class="sp-progress">
                                                    <div class="sp-progress__bar"
                                                        style="width:{{ max($progress, 2) }}%; background:{{ $progColor }};"
                                                        role="progressbar"
                                                        aria-valuenow="{{ $progress }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <span class="sp-progress__pct" style="color:{{ $progColor }};">{{ $progress }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Right column --}}
    <div class="col-lg-4">

        {{-- Actions --}}
        <div class="ad-panel mb-4">
            <div class="ad-panel__head sp-panel-head">
                <div class="sp-panel-icon sp-panel-icon--muted"><i class="bi bi-tools"></i></div>
                <h3 class="ad-panel__title">Actions</h3>
            </div>
            <div class="ad-panel__body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary sp-action-btn">
                        <i class="bi bi-pencil me-2"></i>Edit Student
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="btn admin-lms-btn-outline sp-action-btn">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        {{-- Profile completeness --}}
        <div class="ad-panel">
            <div class="ad-panel__head sp-panel-head">
                <div class="sp-panel-icon sp-panel-icon--amber"><i class="bi bi-bar-chart-fill"></i></div>
                <h3 class="ad-panel__title">Profile Status</h3>
            </div>
            <div class="ad-panel__body">
                @php
                    $checks = [
                        ['label' => 'Basic info',         'done' => true],
                        ['label' => 'Student ID',         'done' => $profile && $profile->student_id_number],
                        ['label' => 'Date of birth',      'done' => $profile && $profile->date_of_birth],
                        ['label' => 'Home address',       'done' => $profile && $profile->home_address],
                        ['label' => 'Guardian contact',   'done' => $profile && $profile->guardian_contact_number],
                        ['label' => 'Enrolled in course', 'done' => $student->enrolledCourses->count() > 0],
                    ];
                    $done = collect($checks)->where('done', true)->count();
                    $pct  = round($done / count($checks) * 100);
                @endphp
                <div class="sp-completeness mb-3">
                    <div class="sp-completeness__top">
                        <span class="sp-completeness__label">Completeness</span>
                        <span class="sp-completeness__pct">{{ $pct }}%</span>
                    </div>
                    <div class="sp-progress mt-1">
                        <div class="sp-progress__bar sp-progress__bar--brand"
                            style="width:{{ $pct }}%;"
                            role="progressbar"
                            aria-valuenow="{{ $pct }}"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>
                </div>
                <ul class="sp-check-list list-unstyled mb-0">
                    @foreach($checks as $check)
                    <li class="sp-check-item {{ $check['done'] ? 'sp-check-item--done' : 'sp-check-item--pending' }}">
                        <i class="bi {{ $check['done'] ? 'bi-check-circle-fill' : 'bi-circle' }} me-2"></i>
                        {{ $check['label'] }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>

<style>
/* ── Hero ── */
.sp-hero {
    background: linear-gradient(115deg, #1a1860 0%, #322f89 60%, #4a47a8 100%);
    border-radius: 14px;
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.sp-hero::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(178,205,52,.1);
    pointer-events: none;
}
.sp-hero__avatar {
    width: 68px; height: 68px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
    border: 2px solid rgba(255,255,255,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.65rem;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    position: relative; z-index: 1;
}
.sp-hero__body {
    flex: 1; min-width: 0;
    position: relative; z-index: 1;
}
.sp-hero__name {
    font-size: 1.35rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: .3rem;
}
.sp-hero__meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .5rem;
    font-size: .82rem;
    color: rgba(255,255,255,.7);
}
.sp-hero__sep { color: rgba(255,255,255,.3); }
.sp-hero__actions { position: relative; z-index: 1; flex-shrink: 0; }
.sp-hero__edit-btn {
    background: rgba(255,255,255,.15);
    color: #fff;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 9px;
    font-size: .82rem;
    font-weight: 600;
    padding: .5rem 1rem;
    transition: background .2s, border-color .2s;
}
.sp-hero__edit-btn:hover {
    background: rgba(255,255,255,.25);
    color: #fff;
}

/* ── Quick stats row ── */
.sp-quick-stat {
    background: #fff;
    border: 1px solid #e4e4f0;
    border-radius: 12px;
    padding: 1.1rem;
    text-align: center;
    box-shadow: 0 1px 3px rgba(15,23,42,.04), 0 4px 12px rgba(15,23,42,.05);
    position: relative;
    overflow: hidden;
}
.sp-quick-stat::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 3px;
    background: var(--sp-qs-color, #322f89);
}
.sp-quick-stat__icon {
    font-size: 1.3rem;
    color: var(--sp-qs-color, #322f89);
    margin-bottom: .4rem;
}
.sp-quick-stat__value {
    font-size: 1.3rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.1;
    margin-bottom: .2rem;
    word-break: break-word;
}
.sp-quick-stat__label {
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: #94a3b8;
}
.sp-quick-stat--purple { --sp-qs-color: #322f89; }
.sp-quick-stat--teal   { --sp-qs-color: #0d9488; }
.sp-quick-stat--lime   { --sp-qs-color: #6b8c00; }
.sp-quick-stat--amber  { --sp-qs-color: #d97706; }

/* ── Panel head ── */
.sp-panel-head {
    display: flex;
    align-items: center;
    gap: .75rem;
}
.sp-panel-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem;
    flex-shrink: 0;
}
.sp-panel-icon--purple { background: #eeedf8; color: #322f89; }
.sp-panel-icon--teal   { background: #f0fdfb; color: #0d9488; }
.sp-panel-icon--lime   { background: #f4f8e3; color: #6b8c00; }
.sp-panel-icon--amber  { background: #fffbeb; color: #d97706; }
.sp-panel-icon--rose   { background: #fff1f4; color: #e11d48; }
.sp-panel-icon--muted  { background: #f1f5f9; color: #64748b; }

/* ── Field display ── */
.sp-field { display: flex; flex-direction: column; }
.sp-field__label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: .3rem;
}
.sp-field__value {
    font-size: .9rem;
    font-weight: 500;
    color: #0f172a;
    line-height: 1.5;
}
.sp-not-set {
    font-size: .82rem;
    font-weight: 400;
    color: #94a3b8;
    font-style: italic;
}
.sp-id-code {
    display: inline-block;
    background: #eeedf8;
    color: #322f89;
    border: 1px solid #d1d0f0;
    padding: .15rem .55rem;
    border-radius: 6px;
    font-family: ui-monospace, monospace;
    font-size: .82rem;
    font-weight: 600;
}
.fw-500 { font-weight: 500 !important; }

/* ── Notice / alert ── */
.sp-notice {
    border-radius: 10px;
    padding: .85rem 1rem;
    font-size: .875rem;
    display: flex;
    align-items: flex-start;
    gap: .5rem;
}
.sp-notice--warning {
    background: #fffbeb;
    color: #92400e;
    border: 1px solid #fde68a;
}
.sp-notice__link {
    color: #92400e;
    font-weight: 600;
    text-decoration: underline;
}
.sp-notice__link:hover { color: #78350f; }

/* ── Editable badge ── */
.sp-editable-badge {
    display: inline-flex;
    align-items: center;
    background: #f4f8e3;
    color: #6b8c00;
    border: 1px solid #d4e69a;
    padding: .2rem .6rem;
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 700;
}

/* ── Count badge ── */
.sp-count-badge {
    background: #eeedf8;
    color: #322f89;
    border: 1px solid #d1d0f0;
    padding: .15rem .55rem;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
}

/* ── Save row ── */
.sp-save-row { border-top: 1px solid #f0f0f8; }
.sp-save-btn {
    background: #322f89 !important;
    color: #fff !important;
    border-color: #322f89 !important;
    border-radius: 9px !important;
    font-size: .85rem !important;
    font-weight: 600 !important;
    padding: .6rem 1.4rem !important;
}
.sp-save-btn:hover {
    background: #1a1860 !important;
    border-color: #1a1860 !important;
}

/* ── Action buttons ── */
.sp-action-btn {
    font-size: .82rem !important;
    border-radius: 9px !important;
    padding: .55rem 1rem !important;
    font-weight: 600 !important;
}

/* ── Progress bar ── */
.sp-progress-wrap {
    display: flex;
    align-items: center;
    gap: .65rem;
}
.sp-progress {
    flex: 1;
    height: 7px;
    background: #f1f5f9;
    border-radius: 999px;
    overflow: hidden;
    min-width: 80px;
}
.sp-progress__bar {
    height: 100%;
    border-radius: 999px;
    transition: width .5s ease;
}
.sp-progress__bar--brand { background: linear-gradient(90deg, #322f89, #b2cd34); }
.sp-progress__pct {
    font-size: .75rem;
    font-weight: 700;
    white-space: nowrap;
    min-width: 34px;
    text-align: right;
}

/* ── Profile completeness ── */
.sp-completeness__top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.sp-completeness__label {
    font-size: .78rem;
    font-weight: 600;
    color: #64748b;
}
.sp-completeness__pct {
    font-size: .9rem;
    font-weight: 700;
    color: #322f89;
}
.sp-check-list { display: flex; flex-direction: column; gap: .35rem; }
.sp-check-item {
    font-size: .82rem;
    display: flex;
    align-items: center;
    padding: .3rem 0;
    border-bottom: 1px solid #f8f9ff;
}
.sp-check-item:last-child { border-bottom: none; }
.sp-check-item--done  { color: #0f172a; font-weight: 500; }
.sp-check-item--done  i { color: #0d9488; }
.sp-check-item--pending { color: #94a3b8; }
.sp-check-item--pending i { color: #cbd5e1; }

/* ── Responsive ── */
@media (max-width: 575.98px) {
    .sp-hero { padding: 1.25rem; }
    .sp-hero__name { font-size: 1.15rem; }
    .sp-hero__avatar { width: 52px; height: 52px; font-size: 1.3rem; }
    .sp-quick-stat__value { font-size: 1.1rem; }
}
</style>
@endsection
