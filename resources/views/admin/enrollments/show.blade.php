@extends('admin.layout')
@section('title', 'Enrollment · ' . $enrollment->user->name)
@section('page_heading', 'Enrollment Details')

@section('content')

{{-- Page header --}}
<div class="enr-hero mb-4">
    <div class="enr-hero__avatar" aria-hidden="true">
        <i class="bi bi-person-check-fill"></i>
    </div>
    <div class="enr-hero__body">
        <h2 class="enr-hero__name">{{ $enrollment->user->name }}</h2>
        <div class="enr-hero__meta">
            <span><i class="bi bi-envelope me-1"></i>{{ $enrollment->user->email }}</span>
            <span class="enr-hero__sep" aria-hidden="true">·</span>
            <span><i class="bi bi-journal-bookmark me-1"></i>{{ $enrollment->course->title }}</span>
        </div>
    </div>
    <div class="enr-hero__status">
        <span class="enr-status-badge"><i class="bi bi-check-circle-fill me-1"></i>Active</span>
    </div>
</div>

<div class="row g-4">

    {{-- Left column --}}
    <div class="col-lg-8">

        {{-- Student Information --}}
        <div class="ad-panel mb-4">
            <div class="ad-panel__head">
                <div class="ad-panel__head-icon ad-panel__head-icon--purple" aria-hidden="true">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <h3 class="ad-panel__title">Student Information</h3>
            </div>
            <div class="ad-panel__body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="enr-field">
                            <span class="enr-field__label">Full Name</span>
                            <span class="enr-field__value">{{ $enrollment->user->name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="enr-field">
                            <span class="enr-field__label">Email Address</span>
                            <span class="enr-field__value">
                                <i class="bi bi-envelope me-1 text-muted"></i>{{ $enrollment->user->email }}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="enr-field">
                            <span class="enr-field__label">Phone</span>
                            <span class="enr-field__value">
                                @if($enrollment->user->phone)
                                    <i class="bi bi-telephone me-1 text-muted"></i>{{ $enrollment->user->phone }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="enr-field">
                            <span class="enr-field__label">Account Created</span>
                            <span class="enr-field__value">{{ $enrollment->user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Course Information --}}
        <div class="ad-panel">
            <div class="ad-panel__head">
                <div class="ad-panel__head-icon ad-panel__head-icon--lime" aria-hidden="true">
                    <i class="bi bi-book-fill"></i>
                </div>
                <h3 class="ad-panel__title">Course Information</h3>
            </div>
            <div class="ad-panel__body">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="enr-field">
                            <span class="enr-field__label">Course Title</span>
                            <span class="enr-field__value fw-600">{{ $enrollment->course->title }}</span>
                        </div>
                    </div>
                    @if($enrollment->course->description)
                    <div class="col-12">
                        <div class="enr-field">
                            <span class="enr-field__label">Description</span>
                            <span class="enr-field__value text-muted" style="font-weight:400;">
                                {{ Str::limit($enrollment->course->description, 200) }}
                            </span>
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-6">
                        <div class="enr-field">
                            <span class="enr-field__label">Enrollment Date</span>
                            <span class="enr-field__value">{{ $enrollment->created_at->format('M d, Y \a\t h:i A') }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="enr-field">
                            <span class="enr-field__label">Duration</span>
                            <span class="enr-field__value">
                                @if($enrollment->course->duration_weeks)
                                    {{ $enrollment->course->duration_weeks }} weeks
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Right column --}}
    <div class="col-lg-4">

        {{-- Enrollment Stats --}}
        <div class="ad-panel mb-4">
            <div class="ad-panel__head">
                <div class="ad-panel__head-icon ad-panel__head-icon--amber" aria-hidden="true">
                    <i class="bi bi-speedometer2"></i>
                </div>
                <h3 class="ad-panel__title">Enrollment Stats</h3>
            </div>
            <div class="ad-panel__body">
                <div class="enr-stat-row">
                    <span class="enr-stat-row__label">Status</span>
                    <span class="enr-stat-row__value">
                        @if($enrollment->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending approval</span>
                        @elseif($enrollment->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-secondary">Rejected</span>
                        @endif
                    </span>
                </div>
                <div class="enr-stat-row">
                    <span class="enr-stat-row__label">Enrollment ID</span>
                    <code class="enr-id-code">#{{ $enrollment->id }}</code>
                </div>
                <div class="enr-stat-row">
                    <span class="enr-stat-row__label">Enrolled</span>
                    <span class="enr-stat-row__value">{{ $enrollment->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="ad-panel">
            <div class="ad-panel__head">
                <div class="ad-panel__head-icon ad-panel__head-icon--muted" aria-hidden="true">
                    <i class="bi bi-tools"></i>
                </div>
                <h3 class="ad-panel__title">Actions</h3>
            </div>
            <div class="ad-panel__body">
                <div class="d-grid gap-2">
                    @if($enrollment->isPending())
                        <form action="{{ route('admin.enrollments.approve', $enrollment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success enr-action-btn w-100">
                                <i class="bi bi-check-circle me-2"></i>Approve Enrollment
                            </button>
                        </form>
                        <form action="{{ route('admin.enrollments.reject', $enrollment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger enr-action-btn w-100">
                                <i class="bi bi-x-circle me-2"></i>Reject Enrollment
                            </button>
                        </form>
                        <div class="enr-divider my-2"></div>
                    @endif
                    <a href="{{ route('admin.students.show', $enrollment->user) }}"
                        class="btn btn-primary enr-action-btn">
                        <i class="bi bi-person me-2"></i>View Student Profile
                    </a>
                    <a href="{{ route('admin.courses.index') }}"
                        class="btn admin-lms-btn-outline enr-action-btn">
                        <i class="bi bi-journal-bookmark me-2"></i>Browse Courses
                    </a>
                </div>
                <div class="enr-divider my-3"></div>
                <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 enr-action-btn">
                        <i class="bi bi-trash me-2"></i>Remove Enrollment
                    </button>
                </form>
                <a href="{{ route('admin.enrollments.index') }}"
                    class="btn btn-link w-100 mt-2 text-muted enr-back-btn">
                    <i class="bi bi-arrow-left me-1"></i>Back to Enrollments
                </a>
            </div>
        </div>

    </div>
</div>

<style>
/* ── Hero header ── */
.enr-hero {
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
.enr-hero::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(178,205,52,.1);
    pointer-events: none;
}
.enr-hero__avatar {
    width: 68px; height: 68px;
    border-radius: 50%;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.85rem;
    color: #fff;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,.2);
}
.enr-hero__body { flex: 1; min-width: 0; }
.enr-hero__name {
    font-size: 1.35rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: .3rem;
}
.enr-hero__meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .5rem;
    font-size: .82rem;
    color: rgba(255,255,255,.7);
}
.enr-hero__sep { color: rgba(255,255,255,.35); }
.enr-hero__status { flex-shrink: 0; position: relative; z-index: 1; }
.enr-status-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(178,205,52,.2);
    color: #b2cd34;
    border: 1px solid rgba(178,205,52,.35);
    padding: .4rem .9rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 700;
}
.enr-status-badge--sm { padding: .3rem .75rem; font-size: .74rem; }

/* ── Panel head icon ── */
.ad-panel__head {
    display: flex;
    align-items: center;
    gap: .75rem;
}
.ad-panel__head-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem;
    flex-shrink: 0;
}
.ad-panel__head-icon--purple { background: #eeedf8; color: #322f89; }
.ad-panel__head-icon--lime   { background: #f4f8e3; color: #6b8c00; }
.ad-panel__head-icon--amber  { background: #fffbeb; color: #d97706; }
.ad-panel__head-icon--muted  { background: #f1f5f9; color: #64748b; }

/* ── Field display ── */
.enr-field__label {
    display: block;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: .3rem;
}
.enr-field__value {
    display: block;
    font-size: .9rem;
    font-weight: 500;
    color: #0f172a;
}
.fw-600 { font-weight: 600 !important; }

/* ── Stat rows ── */
.enr-stat-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .65rem 0;
    border-bottom: 1px solid #f0f0f8;
    gap: .5rem;
}
.enr-stat-row:last-child { border-bottom: none; padding-bottom: 0; }
.enr-stat-row__label {
    font-size: .8rem;
    color: #64748b;
    font-weight: 500;
}
.enr-stat-row__value {
    font-size: .82rem;
    color: #0f172a;
    font-weight: 600;
}
.enr-id-code {
    background: #f1f5f9;
    color: #322f89;
    padding: .15rem .5rem;
    border-radius: 6px;
    font-size: .8rem;
    font-weight: 600;
}

/* ── Action buttons ── */
.enr-action-btn {
    font-size: .82rem !important;
    border-radius: 9px !important;
    padding: .55rem 1rem !important;
    font-weight: 600 !important;
}
.enr-divider {
    border-top: 1px solid #f0f0f8;
}
.enr-back-btn {
    font-size: .8rem !important;
    text-decoration: none !important;
}
.enr-back-btn:hover { color: #322f89 !important; }

@media (max-width: 575.98px) {
    .enr-hero { padding: 1.25rem; }
    .enr-hero__name { font-size: 1.15rem; }
    .enr-hero__avatar { width: 52px; height: 52px; font-size: 1.4rem; }
}
</style>
@endsection
