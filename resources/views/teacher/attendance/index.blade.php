@extends('teacher.layout')
@section('title', 'Attendance')
@section('page_heading', 'Attendance')

@section('content')

@php
    $overview = $overview ?? [];
    $rateFilter = request('rate', '');
    $sort = request('sort', 'name');
@endphp

{{-- Page toolbar --}}
<div class="att-toolbar mb-4">
    <div class="att-toolbar__left">
        <h2 class="att-toolbar__title">My Students Attendance</h2>
        <span class="att-toolbar__count">
            {{ $overview['student_count'] ?? 0 }} {{ Str::plural('student', $overview['student_count'] ?? 0) }}
        </span>
    </div>
    @if(($overview['pending_leave_count'] ?? 0) > 0)
        <a href="{{ route('teacher.dashboard') }}#pending-leave-heading" class="btn admin-lms-btn-outline att-leave-btn">
            <i class="bi bi-calendar-x me-1"></i>
            {{ $overview['pending_leave_count'] }} pending leave {{ Str::plural('request', $overview['pending_leave_count']) }}
        </a>
    @endif
</div>

{{-- Overview stats --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--purple">
            <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-people-fill"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">Total Students</span>
                <span class="ad-stat__value">{{ number_format($overview['student_count'] ?? 0) }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--lime">
            <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">Avg. Profile Rate</span>
                <span class="ad-stat__value">
                    @if(isset($overview['avg_profile_rate']) && $overview['avg_profile_rate'] !== null)
                        {{ $overview['avg_profile_rate'] }}%
                    @else
                        —
                    @endif
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--teal">
            <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-play-circle-fill"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">Lecture Attendance</span>
                <span class="ad-stat__value">
                    @if(isset($overview['lecture_rate']) && $overview['lecture_rate'] !== null)
                        {{ $overview['lecture_rate'] }}%
                    @else
                        —
                    @endif
                </span>
                <span class="att-stat-sub">
                    {{ number_format($overview['lecture_attended_total'] ?? 0) }}
                    / {{ number_format($overview['lecture_assigned_total'] ?? 0) }} lectures
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="ad-stat ad-stat--amber">
            <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="ad-stat__body">
                <span class="ad-stat__label">Daily Records</span>
                <span class="ad-stat__value">{{ number_format(($overview['present_count'] ?? 0) + ($overview['late_count'] ?? 0) + ($overview['excused_count'] ?? 0) + ($overview['absent_count'] ?? 0)) }}</span>
                <span class="att-stat-sub">
                    <span class="att-dot att-dot--present"></span>{{ $overview['present_count'] ?? 0 }} present
                    <span class="att-dot att-dot--absent ms-2"></span>{{ $overview['absent_count'] ?? 0 }} absent
                </span>
            </div>
        </div>
    </div>
</div>

{{-- Main table panel --}}
<div class="ad-panel">
    <div class="att-search-bar">
        <form method="GET" action="{{ route('teacher.attendance.index') }}" class="att-search-form">
            <div class="att-search-input-wrap">
                <i class="bi bi-search att-search-icon" aria-hidden="true"></i>
                <input type="text" name="q" class="form-control att-search-input"
                    placeholder="Search by name, email, or student ID…"
                    value="{{ request('q') }}"
                    autocomplete="off">
            </div>
            <select name="rate" class="form-select att-filter-select" aria-label="Filter by attendance rate">
                <option value="" @selected($rateFilter === '')>All rates</option>
                <option value="good" @selected($rateFilter === 'good')>Good (80%+)</option>
                <option value="fair" @selected($rateFilter === 'fair')>Fair (60–79%)</option>
                <option value="risk" @selected($rateFilter === 'risk')>At risk (&lt;60%)</option>
            </select>
            <select name="sort" class="form-select att-filter-select" aria-label="Sort students">
                <option value="name" @selected($sort === 'name')>Sort: Name</option>
                <option value="rate" @selected($sort === 'rate')>Sort: Profile rate</option>
            </select>
            <button type="submit" class="btn btn-primary att-search-btn">Apply</button>
            @if(request()->hasAny(['q', 'rate', 'sort']))
                <a href="{{ route('teacher.attendance.index') }}" class="btn admin-lms-btn-outline att-search-btn">
                    <i class="bi bi-x-lg me-1"></i>Clear
                </a>
            @endif
        </form>
    </div>

    <div class="ad-panel__body ad-panel__body--flush">
        <div class="table-responsive">
            <table class="table admin-lms-table mb-0 att-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Overall</th>
                        <th>Daily Records</th>
                        <th>Lecture Attendance</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $summary = $student->attendance_summary ?? [];
                            $band = $summary['status_band'] ?? 'no-data';
                            $initials = collect(explode(' ', $student->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->join('');
                        @endphp
                        <tr>
                            <td>
                                <div class="att-name-cell">
                                    <span class="att-avatar" aria-hidden="true">{{ strtoupper($initials) }}</span>
                                    <div>
                                        <span class="att-name">{{ $student->name }}</span>
                                        <span class="att-email d-block">{{ $student->email }}</span>
                                        @if(optional($student->studentProfile)->student_id_number)
                                            <code class="att-id-badge">{{ $student->studentProfile->student_id_number }}</code>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(isset($summary['display_rate']) && $summary['display_rate'] !== null)
                                    <div class="att-rate-wrap">
                                        <span class="att-rate-value">{{ $summary['display_rate'] }}%</span>
                                        <div class="att-rate-bar" role="progressbar"
                                            aria-valuenow="{{ $summary['display_rate'] }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                            <span class="att-rate-bar__fill att-rate-bar__fill--{{ $band }}"
                                                style="width: {{ min(100, $summary['display_rate']) }}%"></span>
                                        </div>
                                    </div>
                                @else
                                    <span class="att-no-data">No data</span>
                                @endif
                            </td>
                            <td>
                                @if(($summary['total_days'] ?? 0) > 0)
                                    <div class="att-daily-grid">
                                        <span class="att-chip att-chip--present" title="Present">
                                            <i class="bi bi-check-circle-fill"></i> {{ $summary['present_count'] }}
                                        </span>
                                        <span class="att-chip att-chip--absent" title="Absent">
                                            <i class="bi bi-x-circle-fill"></i> {{ $summary['absent_count'] }}
                                        </span>
                                        <span class="att-chip att-chip--late" title="Late">
                                            <i class="bi bi-clock-fill"></i> {{ $summary['late_count'] }}
                                        </span>
                                        <span class="att-chip att-chip--excused" title="Excused">
                                            <i class="bi bi-shield-check"></i> {{ $summary['excused_count'] }}
                                        </span>
                                    </div>
                                    @if(!empty($summary['last_record_date']))
                                        <span class="att-meta">Last: {{ $summary['last_record_date']->format('M j, Y') }}</span>
                                    @endif
                                @else
                                    <span class="att-meta">
                                        @if($student->attendance_percentage !== null)
                                            Profile: {{ $student->attendance_percentage }}%
                                        @else
                                            No daily records
                                        @endif
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if(($summary['lectures_assigned'] ?? 0) > 0)
                                    <span class="att-lecture-count">
                                        <strong>{{ $summary['lectures_attended'] }}</strong>
                                        <span class="text-muted">/ {{ $summary['lectures_assigned'] }}</span>
                                    </span>
                                    @if(isset($summary['lecture_rate']))
                                        <span class="att-lecture-pct">{{ $summary['lecture_rate'] }}%</span>
                                    @endif
                                @else
                                    <span class="att-no-data">No lectures assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($band === 'good')
                                    <span class="att-status att-status--good"><i class="bi bi-check-lg"></i> Good</span>
                                @elseif($band === 'fair')
                                    <span class="att-status att-status--fair"><i class="bi bi-dash-lg"></i> Fair</span>
                                @elseif($band === 'at-risk')
                                    <span class="att-status att-status--risk"><i class="bi bi-exclamation-lg"></i> At risk</span>
                                @else
                                    <span class="att-status att-status--none">—</span>
                                @endif
                                @if(($summary['pending_leave_count'] ?? 0) > 0)
                                    <span class="att-leave-pill" title="Pending leave request">
                                        <i class="bi bi-calendar-x"></i> Leave pending
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('teacher.students.show', $student) }}" class="btn btn-sm btn-outline-primary att-row-btn">
                                    <i class="bi bi-person-lines-fill me-1"></i> Profile
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="ad-empty">
                                    <i class="bi bi-calendar2-x"></i>
                                    @if(request()->hasAny(['q', 'rate']))
                                        No students match your filters.
                                    @else
                                        No students found yet.
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="att-pagination">
                <p class="att-pagination__summary">
                    Showing <strong>{{ $students->firstItem() }}</strong> to <strong>{{ $students->lastItem() }}</strong>
                    of <strong>{{ $students->total() }}</strong> students
                </p>
                {{ $students->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
/* ── Stat cards (shared with dashboard) ── */
.ad-stat {
    background: #fff;
    border: 1px solid #e4e4f0;
    border-radius: 14px;
    padding: 1.25rem 1.35rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(15,23,42,.04), 0 6px 18px rgba(15,23,42,.05);
    transition: box-shadow .25s ease, transform .2s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
}
.ad-stat:hover {
    box-shadow: 0 4px 8px rgba(15,23,42,.06), 0 16px 36px rgba(15,23,42,.09);
    transform: translateY(-2px);
}
.ad-stat::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 4px; height: 100%;
    border-radius: 4px 0 0 4px;
    background: var(--ad-stat-color, #322f89);
}
.ad-stat__icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    background: var(--ad-stat-bg, #eeedf8);
    color: var(--ad-stat-color, #322f89);
}
.ad-stat__body { flex: 1; min-width: 0; }
.ad-stat__label {
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: #64748b;
    display: block;
    margin-bottom: .25rem;
}
.ad-stat__value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
    display: block;
}
.ad-stat--purple { --ad-stat-color: #322f89; --ad-stat-bg: #eeedf8; }
.ad-stat--teal   { --ad-stat-color: #0d9488; --ad-stat-bg: #f0fdfb; }
.ad-stat--lime   { --ad-stat-color: #6b8c00; --ad-stat-bg: #f7fae8; }
.ad-stat--amber  { --ad-stat-color: #d97706; --ad-stat-bg: #fffbeb; }
.att-stat-sub {
    display: block;
    font-size: .72rem;
    color: #64748b;
    margin-top: .35rem;
    line-height: 1.4;
}
.att-dot {
    display: inline-block;
    width: 7px; height: 7px;
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 3px;
}
.att-dot--present { background: #16a34a; }
.att-dot--absent  { background: #dc2626; }

/* ── Toolbar ── */
.att-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.att-toolbar__left {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}
.att-toolbar__title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.att-toolbar__count {
    background: #eeedf8;
    color: #322f89;
    font-size: .75rem;
    font-weight: 700;
    padding: .25rem .65rem;
    border-radius: 999px;
    border: 1px solid #d1d0f0;
}
.att-leave-btn {
    font-size: .82rem !important;
    border-radius: 9px !important;
    font-weight: 600 !important;
}

/* ── Search / filters ── */
.att-search-bar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f0f0f8;
    background: #fafbff;
}
.att-search-form {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}
.att-search-input-wrap {
    position: relative;
    flex: 1;
    min-width: 200px;
}
.att-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: .9rem;
    pointer-events: none;
}
.att-search-input {
    padding-left: 34px !important;
    height: 40px;
    border-color: #e4e4f0;
    border-radius: 9px !important;
    font-size: .85rem;
}
.att-filter-select {
    height: 40px;
    border-color: #e4e4f0;
    border-radius: 9px !important;
    font-size: .82rem;
    min-width: 140px;
    max-width: 180px;
}
.att-search-btn {
    height: 40px;
    font-size: .82rem !important;
    border-radius: 9px !important;
    font-weight: 600 !important;
    padding: 0 1rem !important;
    white-space: nowrap;
}

/* ── Table cells ── */
.att-name-cell {
    display: flex;
    align-items: flex-start;
    gap: .65rem;
}
.att-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #322f89, #b2cd34);
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.att-name {
    font-weight: 600;
    color: #0f172a;
    font-size: .88rem;
}
.att-email {
    font-size: .76rem;
    color: #64748b;
}
.att-id-badge {
    display: inline-block;
    margin-top: .2rem;
    background: #eeedf8;
    color: #322f89;
    border: 1px solid #d1d0f0;
    padding: .1rem .45rem;
    border-radius: 5px;
    font-size: .7rem;
    font-weight: 600;
}

.att-rate-wrap { min-width: 100px; }
.att-rate-value {
    font-size: .9rem;
    font-weight: 700;
    color: #0f172a;
    display: block;
    margin-bottom: .3rem;
}
.att-rate-bar {
    height: 6px;
    background: #f1f5f9;
    border-radius: 999px;
    overflow: hidden;
}
.att-rate-bar__fill {
    display: block;
    height: 100%;
    border-radius: 999px;
    transition: width .3s ease;
}
.att-rate-bar__fill--good    { background: linear-gradient(90deg, #16a34a, #4ade80); }
.att-rate-bar__fill--fair    { background: linear-gradient(90deg, #d97706, #fbbf24); }
.att-rate-bar__fill--at-risk { background: linear-gradient(90deg, #dc2626, #f87171); }
.att-rate-bar__fill--no-data { background: #cbd5e1; }

.att-daily-grid {
    display: flex;
    flex-wrap: wrap;
    gap: .35rem;
    margin-bottom: .25rem;
}
.att-chip {
    display: inline-flex;
    align-items: center;
    gap: .2rem;
    font-size: .7rem;
    font-weight: 600;
    padding: .15rem .45rem;
    border-radius: 6px;
    border: 1px solid transparent;
}
.att-chip--present { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.att-chip--absent  { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
.att-chip--late    { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.att-chip--excused { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }

.att-meta {
    font-size: .72rem;
    color: #94a3b8;
    display: block;
}
.att-no-data {
    font-size: .78rem;
    color: #94a3b8;
    font-style: italic;
}

.att-lecture-count {
    display: block;
    font-size: .88rem;
    color: #0f172a;
}
.att-lecture-pct {
    display: inline-block;
    margin-top: .15rem;
    font-size: .75rem;
    font-weight: 600;
    color: #322f89;
    background: #eeedf8;
    padding: .1rem .45rem;
    border-radius: 5px;
}

.att-status {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    font-size: .75rem;
    font-weight: 600;
    padding: .25rem .55rem;
    border-radius: 999px;
    white-space: nowrap;
}
.att-status--good { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.att-status--fair { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
.att-status--risk { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.att-status--none { color: #94a3b8; }

.att-leave-pill {
    display: block;
    margin-top: .35rem;
    font-size: .68rem;
    font-weight: 600;
    color: #d97706;
}
.att-leave-pill i { margin-right: .15rem; }

.att-row-btn {
    font-size: .75rem !important;
    padding: .28rem .65rem !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
}

.att-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    padding: 1rem 1.25rem;
    border-top: 1px solid #f0f0f8;
    background: #fafbff;
}
.att-pagination__summary {
    font-size: .8rem;
    color: #64748b;
    margin: 0;
}

@media (max-width: 767.98px) {
    .att-table th:nth-child(3),
    .att-table td:nth-child(3) {
        min-width: 140px;
    }
}
</style>
@endpush
