@extends('teacher.layout')
@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@section('content')
@php $overview = $overview ?? []; @endphp

<div class="ad-banner mb-4" style="background:linear-gradient(115deg,#042f2e 0%,#0f766e 55%,#14b8a6 100%);border-radius:16px;padding:2rem 2.25rem;color:#fff;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <p class="mb-1 text-uppercase small fw-semibold" style="color:#99f6e4;letter-spacing:.08em;">Welcome back</p>
            <h2 class="h3 mb-2 fw-bold">{{ $teacher->name }}</h2>
            <p class="mb-0 opacity-75">{{ $teacher->department ?: 'Teacher' }} · Manage your students, subjects, and attendance.</p>
        </div>
        <a href="{{ route('teacher.students.create') }}" class="btn btn-light fw-semibold">
            <i class="bi bi-person-plus me-1"></i> Add Student
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--purple">
            <div class="ad-stat__icon"><i class="bi bi-people-fill"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">My Students</span>
                <span class="ad-stat__value">{{ $overview['student_count'] ?? 0 }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--teal">
            <div class="ad-stat__icon"><i class="bi bi-book-half"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">My Subjects</span>
                <span class="ad-stat__value">{{ $subjectCount ?? $subjects->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--lime">
            <div class="ad-stat__icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">Avg. Attendance</span>
                <span class="ad-stat__value">{{ isset($overview['avg_profile_rate']) && $overview['avg_profile_rate'] !== null ? $overview['avg_profile_rate'].'%' : '—' }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--amber">
            <div class="ad-stat__icon"><i class="bi bi-calendar-x"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">Pending Leave</span>
                <span class="ad-stat__value">{{ $pendingLeave }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="ad-panel">
            <div class="ad-panel__head">
                <h3 class="ad-panel__title mb-0">Recent Students</h3>
                <a href="{{ route('teacher.students.index') }}" class="small fw-semibold text-decoration-none">View all</a>
            </div>
            <div class="ad-panel__body ad-panel__body--flush">
                <div class="table-responsive">
                    <table class="table admin-lms-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStudents as $student)
                                <tr>
                                    <td class="fw-500">{{ $student->name }}</td>
                                    <td class="text-muted">{{ $student->email }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('teacher.students.show', $student) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="ad-empty py-4">
                                            <i class="bi bi-people"></i>
                                            No students assigned yet. <a href="{{ route('teacher.students.create') }}">Add a student</a> and assign your subjects.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="ad-panel h-100">
            <div class="ad-panel__head">
                <h3 class="ad-panel__title mb-0">My Subjects</h3>
                <a href="{{ route('teacher.subjects.index') }}" class="small fw-semibold text-decoration-none">View all</a>
            </div>
            <div class="ad-panel__body">
                @forelse($subjects as $subject)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div>
                            <div class="fw-600">{{ $subject->name }}</div>
                            <div class="small text-muted">{{ $subject->course->title ?? 'No course linked' }}</div>
                        </div>
                        <span class="badge bg-light text-dark border">{{ $subject->students_count ?? 0 }} students</span>
                    </div>
                @empty
                    <div class="ad-empty py-3">
                        <i class="bi bi-book"></i>
                        No subjects assigned yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.ad-stat{background:#fff;border:1px solid #e4e4f0;border-radius:14px;padding:1.25rem;display:flex;align-items:center;gap:1rem;box-shadow:0 1px 3px rgba(15,23,42,.04);height:100%}
.ad-stat__icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;background:var(--ad-stat-bg,#eeedf8);color:var(--ad-stat-color,#322f89)}
.ad-stat__label{font-size:.72rem;font-weight:600;text-transform:uppercase;color:#64748b;display:block}
.ad-stat__value{font-size:1.75rem;font-weight:700;color:#0f172a;line-height:1}
.ad-stat--purple{--ad-stat-color:#0f766e;--ad-stat-bg:#f0fdfb}
.ad-stat--teal{--ad-stat-color:#0d9488;--ad-stat-bg:#ecfeff}
.ad-stat--lime{--ad-stat-color:#6b8c00;--ad-stat-bg:#f7fae8}
.ad-stat--amber{--ad-stat-color:#d97706;--ad-stat-bg:#fffbeb}
.ad-panel{background:#fff;border:1px solid #e4e4f0;border-radius:14px;box-shadow:0 1px 3px rgba(15,23,42,.04);overflow:hidden}
.ad-panel__head{padding:.9rem 1.25rem;border-bottom:1px solid #f0f0f8;background:#fafbff;display:flex;align-items:center;justify-content:space-between}
.ad-panel__title{font-size:.95rem;font-weight:700;margin:0}
.ad-panel__body{padding:1rem 1.25rem}
.ad-panel__body--flush{padding:0}
.ad-empty{text-align:center;color:#64748b;padding:2rem 1rem}
</style>
@endpush
