@extends('student.layout')
@section('title', 'My Profile')
@section('page_heading', 'My Profile')

@section('content')
@php
    $profile       = $student->studentProfile;
    $attendancePct = $student->attendance_percentage !== null ? (float) $student->attendance_percentage : null;
    $pctColor      = $attendancePct === null ? '#94a3b8'
                   : ($attendancePct >= 80  ? '#0d9488'
                   : ($attendancePct >= 60  ? '#d97706' : '#e11d48'));
@endphp

{{-- ── Profile hero ── --}}
<div class="sp-hero mb-4">
    <div class="sp-hero__avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
    <div class="sp-hero__body">
        <p class="sp-hero__eyebrow">Student Profile</p>
        <h2 class="sp-hero__name">{{ $student->name }}</h2>
        <div class="sp-hero__meta">
            <span><i class="bi bi-envelope me-1"></i>{{ $student->email }}</span>
            @if($profile)
                <span class="sp-hero__sep">·</span>
                <span><i class="bi bi-person-vcard me-1"></i>{{ $profile->student_id_number }}</span>
            @endif
            <span class="sp-hero__sep">·</span>
            <span><i class="bi bi-calendar3 me-1"></i>Since {{ $student->created_at->format('M Y') }}</span>
        </div>
    </div>
    <div class="sp-hero__links">
        <a href="{{ route('student.dashboard') }}" class="sp-hero__btn">
            <i class="bi bi-grid-1x2 me-1"></i>Dashboard
        </a>
    </div>
</div>

@unless($profile)
    <div class="sp-notice sp-notice--warning mb-4">
        <i class="bi bi-info-circle-fill me-2"></i>
        Your full student information has not been completed yet. Please contact the administrator to update your profile.
    </div>
@endunless

<div class="row g-4">
    {{-- ── Left column ── --}}
    <div class="col-lg-8">

        {{-- Personal Information --}}
        <div class="sp-panel mb-4">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--primary"><i class="bi bi-person-vcard-fill"></i></div>
                <h3 class="sp-panel__title">Personal Information</h3>
            </div>
            <div class="sp-panel__body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Student ID Number</span>
                            <span class="sp-field__value">
                                @if($profile)
                                    <span class="sp-id-code">{{ $profile->student_id_number }}</span>
                                @else <span class="sp-nil">Not completed</span>@endif
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
                            <span class="sp-field__label">Phone</span>
                            <span class="sp-field__value">
                                @if($student->phone) {{ $student->phone }}
                                @else <span class="sp-nil">Not provided</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Date of Birth</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->date_of_birth) {{ $profile->date_of_birth->format('M d, Y') }}
                                @else <span class="sp-nil">Not completed</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Gender</span>
                            <span class="sp-field__value">
                                @if($profile) {{ $genderOptions[$profile->gender] ?? ucfirst(str_replace('_', ' ', $profile->gender)) }}
                                @else <span class="sp-nil">Not completed</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">School Name</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->school_name) {{ $profile->school_name }}
                                @else <span class="sp-nil">Not applicable</span>@endif
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
                                @if($profile && $profile->home_address) {{ $profile->home_address }}
                                @else <span class="sp-nil">Not completed</span>@endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Guardian & Emergency --}}
        <div class="sp-panel mb-4">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--rose"><i class="bi bi-shield-check"></i></div>
                <h3 class="sp-panel__title">Guardian &amp; Emergency Contacts</h3>
            </div>
            <div class="sp-panel__body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Parent / Guardian Name</span>
                            <span class="sp-field__value">
                                @if($profile) {{ $profile->guardian_name }}
                                @else <span class="sp-nil">Not completed</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Guardian Contact</span>
                            <span class="sp-field__value">
                                @if($profile) {{ $profile->guardian_contact_number }}
                                @else <span class="sp-nil">Not completed</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Emergency Contact</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->emergency_contact_number) {{ $profile->emergency_contact_number }}
                                @elseif($profile) <span class="sp-nil">Same as guardian</span>
                                @else <span class="sp-nil">Not completed</span>@endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dashboard Metrics --}}
        <div class="sp-panel mb-4">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--teal"><i class="bi bi-activity"></i></div>
                <h3 class="sp-panel__title">Dashboard Metrics</h3>
            </div>
            <div class="sp-panel__body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Last Active</span>
                            <span class="sp-field__value">
                                @if($student->last_active_at) {{ $student->last_active_at->format('M d, Y g:i A') }}
                                @else <span class="sp-nil">No activity recorded yet</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Attendance Rate</span>
                            @if($attendancePct !== null)
                                <div class="sp-prog-wrap mt-1">
                                    <div class="sp-prog">
                                        <div class="sp-prog__bar" style="width:{{ min(100,$attendancePct) }}%; background:{{ $pctColor }};"></div>
                                    </div>
                                    <span class="sp-prog__pct" style="color:{{ $pctColor }};">{{ number_format($attendancePct,1) }}%</span>
                                </div>
                            @else
                                <span class="sp-field__value sp-nil">Not recorded yet</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Sessions Booked</span>
                            <span class="sp-field__value">{{ $profile ? (int)$profile->total_sessions_booked : '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Sessions Attended</span>
                            <span class="sp-field__value">{{ $profile ? (int)$profile->total_sessions_attended : '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Last Session Date</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->last_session_date) {{ $profile->last_session_date->format('M d, Y') }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Next Session Date</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->next_session_date) {{ $profile->next_session_date->format('M d, Y') }}
                                @else <span class="sp-nil">Not scheduled</span>@endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Score pills --}}
                <div class="sp-score-row mt-4">
                    <div class="sp-score-pill">
                        <span class="sp-score-pill__label">Homework</span>
                        <span class="sp-score-pill__val">
                            @if($profile && $profile->homework_completion_rate !== null)
                                {{ number_format((float)$profile->homework_completion_rate, 1) }}%
                            @else —@endif
                        </span>
                    </div>
                    <div class="sp-score-pill">
                        <span class="sp-score-pill__label">Assessment Avg</span>
                        <span class="sp-score-pill__val">
                            @if($profile && $profile->assessment_average !== null)
                                {{ number_format((float)$profile->assessment_average, 1) }}%
                            @else —@endif
                        </span>
                    </div>
                    <div class="sp-score-pill sp-score-pill--accent">
                        <span class="sp-score-pill__label">Progress Score</span>
                        <span class="sp-score-pill__val">
                            @if($profile && $profile->progress_score !== null)
                                {{ number_format((float)$profile->progress_score, 1) }}%
                            @else —@endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Academic Information --}}
        <div class="sp-panel mb-4">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--violet"><i class="bi bi-mortarboard-fill"></i></div>
                <h3 class="sp-panel__title">Academic Information</h3>
            </div>
            <div class="sp-panel__body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="sp-field">
                            <span class="sp-field__label">Subject(s) Enrolled</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->subjects_enrolled) {{ $profile->subjects_enrolled }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Academic Level</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->academic_level) {{ $profile->academic_level }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Current Working Grade</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->current_working_grade) {{ $profile->current_working_grade }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sp-field">
                            <span class="sp-field__label">Target Grade</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->target_grade) {{ $profile->target_grade }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sp-field">
                            <span class="sp-field__label">Learning Goals</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->learning_goals) {{ $profile->learning_goals }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sp-field">
                            <span class="sp-field__label">Areas for Improvement</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->areas_for_improvement) {{ $profile->areas_for_improvement }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sp-field">
                            <span class="sp-field__label">SEND / Learning Needs</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->send_learning_needs) {{ $profile->send_learning_needs }}
                                @else <span class="sp-nil">Not recorded</span>@endif
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="sp-field">
                            <span class="sp-field__label">English as an Additional Language</span>
                            <span class="sp-field__value">
                                @if($profile && $profile->eal_notes) {{ $profile->eal_notes }}
                                @else <span class="sp-nil">Not applicable</span>@endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Enrolled Courses --}}
        <div class="sp-panel">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--teal"><i class="bi bi-book-half"></i></div>
                <h3 class="sp-panel__title">Enrolled Courses</h3>
                @if(!$enrollmentProgress->isEmpty())
                    <span class="sp-count-badge ms-auto">{{ $enrollmentProgress->count() }}</span>
                @endif
            </div>
            <div class="sp-panel__body--flush">
                @if($enrollmentProgress->isEmpty())
                    <div class="sp-empty">
                        <i class="bi bi-inbox d-block mb-2"></i>No courses enrolled yet.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table student-dash-table sp-table mb-0">
                            <thead>
                                <tr><th>Course</th><th>Enrolled On</th><th>Progress</th></tr>
                            </thead>
                            <tbody>
                                @foreach($enrollmentProgress as $row)
                                    @php
                                        $progress   = (int) $row['progress'];
                                        $course     = $row['course'];
                                        $enrollment = $row['enrollment'];
                                        $pc = $progress >= 75 ? '#0d9488' : ($progress >= 50 ? '#4f46e5' : ($progress > 0 ? '#d97706' : '#cbd5e1'));
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $course->title }}</td>
                                        <td class="text-muted">{{ $enrollment->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="sp-prog-wrap">
                                                <div class="sp-prog">
                                                    <div class="sp-prog__bar" style="width:{{ max($progress,2) }}%; background:{{ $pc }};"></div>
                                                </div>
                                                <span class="sp-prog__pct" style="color:{{ $pc }};">{{ $progress }}%</span>
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

    {{-- ── Right column ── --}}
    <div class="col-lg-4">

        {{-- Quick Stats --}}
        <div class="sp-panel mb-4">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--amber"><i class="bi bi-speedometer2"></i></div>
                <h3 class="sp-panel__title">Quick Stats</h3>
            </div>
            <div class="sp-panel__body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="sp-qs sp-qs--primary">
                            <div class="sp-qs__icon"><i class="bi bi-book-fill"></i></div>
                            <div class="sp-qs__val">{{ $enrolledCount }}</div>
                            <div class="sp-qs__lbl">Courses</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="sp-qs sp-qs--teal">
                            <div class="sp-qs__icon"><i class="bi bi-pencil-square"></i></div>
                            <div class="sp-qs__val">{{ $quizAttemptsCount }}</div>
                            <div class="sp-qs__lbl">Quiz Attempts</div>
                        </div>
                    </div>
                </div>

                @if($attendancePct !== null)
                <div class="sp-attend-meter mt-3">
                    <div class="sp-attend-meter__top">
                        <span class="sp-attend-meter__label">Attendance</span>
                        <span class="sp-attend-meter__pct" style="color:{{ $pctColor }};">{{ number_format($attendancePct,0) }}%</span>
                    </div>
                    <div class="sp-prog mt-1">
                        <div class="sp-prog__bar" style="width:{{ min(100,$attendancePct) }}%; background:{{ $pctColor }};"></div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="sp-panel">
            <div class="sp-panel__head">
                <div class="sp-panel__icon sp-panel__icon--primary"><i class="bi bi-link-45deg"></i></div>
                <h3 class="sp-panel__title">Quick Links</h3>
            </div>
            <div class="sp-panel__body">
                <div class="d-grid gap-2">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-lms-primary sp-link-btn">
                        <i class="bi bi-grid-1x2 me-2"></i>Go to Dashboard
                    </a>
                    <a href="{{ route('contact-us') }}" class="btn sp-link-btn-outline">
                        <i class="bi bi-headset me-2"></i>Contact Support
                    </a>
                    <a href="{{ route('home') }}" class="btn sp-link-btn-outline" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-box-arrow-up-right me-2"></i>View Site
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* ── Hero ── */
.sp-hero {
    background: linear-gradient(115deg, #312e81 0%, #4f46e5 55%, #6366f1 100%);
    border-radius: 16px;
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.sp-hero::before {
    content:'';
    position:absolute; top:-50px; right:-50px;
    width:200px; height:200px;
    border-radius:50%;
    background:rgba(255,255,255,.07);
    pointer-events:none;
}
.sp-hero__avatar {
    width: 68px; height: 68px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
    border: 2px solid rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.65rem; font-weight: 700; color: #fff;
    flex-shrink: 0; position: relative; z-index: 1;
}
.sp-hero__body { flex:1; min-width:0; position:relative; z-index:1; }
.sp-hero__eyebrow {
    font-size:.7rem; font-weight:700; letter-spacing:.08em;
    text-transform:uppercase; color:rgba(255,255,255,.7); margin-bottom:.2rem;
}
.sp-hero__name { font-size:1.35rem; font-weight:700; color:#fff; margin-bottom:.3rem; }
.sp-hero__meta {
    display:flex; flex-wrap:wrap; gap:.5rem;
    font-size:.8rem; color:rgba(255,255,255,.7);
}
.sp-hero__sep { color:rgba(255,255,255,.3); }
.sp-hero__links { position:relative; z-index:1; flex-shrink:0; }
.sp-hero__btn {
    display:inline-flex; align-items:center;
    background:rgba(255,255,255,.15);
    color:#fff;
    border:1px solid rgba(255,255,255,.25);
    border-radius:9px;
    font-size:.82rem; font-weight:600;
    padding:.5rem 1rem;
    text-decoration:none;
    transition:background .2s;
}
.sp-hero__btn:hover { background:rgba(255,255,255,.25); color:#fff; }

/* ── Notice ── */
.sp-notice {
    border-radius:10px; padding:.85rem 1rem;
    font-size:.875rem; display:flex; align-items:flex-start; gap:.5rem;
}
.sp-notice--warning {
    background:#fffbeb; color:#92400e; border:1px solid #fde68a;
}

/* ── Panel ── */
.sp-panel {
    background:#fff;
    border:1px solid #e0e7ff;
    border-radius:14px;
    box-shadow:0 1px 3px rgba(15,23,42,.04), 0 6px 18px rgba(79,70,229,.06);
    overflow:hidden;
}
.sp-panel__head {
    padding:.9rem 1.25rem;
    border-bottom:1px solid #f0f0ff;
    background:#fafbff;
    display:flex; align-items:center; gap:.75rem;
}
.sp-panel__icon {
    width:34px; height:34px;
    border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    font-size:.95rem; flex-shrink:0;
}
.sp-panel__icon--primary { background:#eef2ff; color:#4f46e5; }
.sp-panel__icon--teal    { background:#f0fdfb; color:#0d9488; }
.sp-panel__icon--rose    { background:#fff1f4; color:#e11d48; }
.sp-panel__icon--violet  { background:#f5f3ff; color:#7c3aed; }
.sp-panel__icon--amber   { background:#fffbeb; color:#d97706; }
.sp-panel__title { font-size:.9rem; font-weight:600; color:#0f172a; margin:0; }
.sp-panel__body { padding:1.25rem; }
.sp-panel__body--flush { padding:0; }

/* ── Fields ── */
.sp-field { display:flex; flex-direction:column; }
.sp-field__label {
    font-size:.68rem; font-weight:700;
    letter-spacing:.06em; text-transform:uppercase;
    color:#94a3b8; margin-bottom:.3rem;
}
.sp-field__value { font-size:.88rem; font-weight:500; color:#0f172a; line-height:1.5; }
.sp-nil { font-style:italic; color:#94a3b8; font-weight:400; font-size:.82rem; }
.sp-id-code {
    background:#eef2ff; color:#3730a3;
    border:1px solid #c7d2fe;
    padding:.15rem .55rem; border-radius:6px;
    font-family:ui-monospace,monospace;
    font-size:.82rem; font-weight:600;
}

/* ── Progress bar ── */
.sp-prog-wrap { display:flex; align-items:center; gap:.65rem; }
.sp-prog {
    flex:1; height:7px;
    background:#f1f5f9; border-radius:999px; overflow:hidden;
    min-width:60px;
}
.sp-prog__bar { height:100%; border-radius:999px; transition:width .5s ease; }
.sp-prog__pct { font-size:.75rem; font-weight:700; flex-shrink:0; min-width:36px; text-align:right; }

/* ── Score pills ── */
.sp-score-row {
    display:flex; flex-wrap:wrap; gap:.6rem;
    padding-top:.75rem;
    border-top:1px solid #f0f0ff;
}
.sp-score-pill {
    flex:1; min-width:120px;
    background:#f8f9ff;
    border:1px solid #e0e7ff;
    border-radius:10px;
    padding:.65rem .85rem;
}
.sp-score-pill--accent { background:#eef2ff; border-color:#c7d2fe; }
.sp-score-pill__label {
    font-size:.67rem; font-weight:700;
    letter-spacing:.05em; text-transform:uppercase; color:#94a3b8;
    display:block; margin-bottom:.25rem;
}
.sp-score-pill__val { font-size:1.1rem; font-weight:700; color:#0f172a; }

/* ── Quick stat boxes ── */
.sp-qs {
    border-radius:12px; padding:1rem .85rem;
    text-align:center;
    border:1px solid #e0e7ff;
    position:relative; overflow:hidden;
}
.sp-qs::after {
    content:''; position:absolute;
    top:0; left:0; width:100%; height:3px;
    background:var(--sp-qs-c,#4f46e5);
}
.sp-qs__icon { font-size:1.2rem; color:var(--sp-qs-c,#4f46e5); margin-bottom:.4rem; }
.sp-qs__val  { font-size:1.4rem; font-weight:700; color:#0f172a; line-height:1; margin-bottom:.2rem; }
.sp-qs__lbl  { font-size:.67rem; font-weight:600; letter-spacing:.05em; text-transform:uppercase; color:#94a3b8; }
.sp-qs--primary { --sp-qs-c:#4f46e5; }
.sp-qs--teal    { --sp-qs-c:#0d9488; }

/* Attendance meter in sidebar */
.sp-attend-meter { border-top:1px solid #f0f0ff; padding-top:.85rem; }
.sp-attend-meter__top { display:flex; justify-content:space-between; align-items:center; }
.sp-attend-meter__label { font-size:.75rem; font-weight:600; color:#64748b; }
.sp-attend-meter__pct   { font-size:.9rem; font-weight:700; }

/* ── Count badge ── */
.sp-count-badge {
    background:#eef2ff; color:#3730a3;
    border:1px solid #c7d2fe;
    padding:.15rem .55rem; border-radius:999px;
    font-size:.72rem; font-weight:700;
}

/* ── Buttons ── */
.sp-link-btn {
    border-radius:9px !important;
    font-size:.82rem !important;
    font-weight:600 !important;
    padding:.55rem 1rem !important;
}
.sp-link-btn-outline {
    background:#f8f9ff;
    color:#475569;
    border:1px solid #e0e7ff;
    border-radius:9px;
    font-size:.82rem;
    font-weight:500;
    padding:.55rem 1rem;
    text-decoration:none;
    display:block; text-align:center;
    transition:background .15s, border-color .15s;
}
.sp-link-btn-outline:hover { background:#eef2ff; border-color:#c7d2fe; color:#3730a3; }

/* ── Table / empty ── */
.sp-table thead th { background:#fafbff; }
.sp-empty {
    padding:2.5rem 1.5rem; text-align:center;
    color:#94a3b8; font-size:.875rem;
}
.sp-empty i { font-size:2rem; opacity:.35; }

@media (max-width:575.98px) {
    .sp-hero { padding:1.25rem; }
    .sp-hero__name { font-size:1.15rem; }
    .sp-hero__avatar { width:52px; height:52px; font-size:1.3rem; }
}
</style>
@endsection
