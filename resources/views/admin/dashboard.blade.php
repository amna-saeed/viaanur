@extends('admin.layout')
@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@push('styles')
<style>
/* ── Welcome Banner ── */
.ad-banner {
    background: linear-gradient(115deg, #1a1860 0%, #322f89 55%, #4a47a8 100%);
    border-radius: 16px;
    padding: 2rem 2.25rem;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    position: relative;
    overflow: hidden;
}
.ad-banner::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(178,205,52,.12);
    pointer-events: none;
}
.ad-banner::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 40%;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
    pointer-events: none;
}
.ad-banner__text { position: relative; z-index: 1; }
.ad-banner__eyebrow {
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #b2cd34;
    margin-bottom: .3rem;
}
.ad-banner__title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: .4rem;
    line-height: 1.3;
}
.ad-banner__sub {
    font-size: .875rem;
    color: rgba(255,255,255,.65);
    margin-bottom: 0;
}
.ad-banner__action { position: relative; z-index: 1; flex-shrink: 0; }
.ad-btn-refresh {
    background: rgba(255,255,255,.12);
    color: #fff;
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 10px;
    font-size: .8rem;
    font-weight: 600;
    padding: .55rem 1.1rem;
    transition: background .2s, border-color .2s;
    white-space: nowrap;
}
.ad-btn-refresh:hover {
    background: rgba(255,255,255,.2);
    border-color: rgba(255,255,255,.35);
    color: #fff;
}
.ad-btn-refresh.is-loading i { animation: admin-spin .7s linear infinite; }

/* ── Stat Cards ── */
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
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ad-stat__value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
    display: block;
}

/* stat colour variants */
.ad-stat--purple { --ad-stat-color: #322f89; --ad-stat-bg: #eeedf8; }
.ad-stat--teal   { --ad-stat-color: #0d9488; --ad-stat-bg: #f0fdfb; }
.ad-stat--lime   { --ad-stat-color: #6b8c00; --ad-stat-bg: #f7fae8; }
.ad-stat--amber  { --ad-stat-color: #d97706; --ad-stat-bg: #fffbeb; }
.ad-stat--rose   { --ad-stat-color: #e11d48; --ad-stat-bg: #fff1f4; }

/* ── Section heading ── */
.ad-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.1rem;
    flex-wrap: wrap;
}
.ad-section-head__title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.ad-section-head__title::before {
    content: '';
    display: inline-block;
    width: 4px; height: 18px;
    background: #b2cd34;
    border-radius: 4px;
    flex-shrink: 0;
}
.ad-section-head__sub {
    font-size: .8rem;
    color: #64748b;
    margin: 0;
}

/* ── Chart panels ── */
.ad-panel {
    background: #fff;
    border: 1px solid #e4e4f0;
    border-radius: 14px;
    box-shadow: 0 1px 3px rgba(15,23,42,.04), 0 6px 18px rgba(15,23,42,.05);
    overflow: hidden;
    transition: box-shadow .25s ease;
}
.ad-panel:hover {
    box-shadow: 0 4px 8px rgba(15,23,42,.06), 0 16px 36px rgba(15,23,42,.09);
}
.ad-panel__head {
    padding: .9rem 1.25rem;
    border-bottom: 1px solid #f0f0f8;
    background: #fafbff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    flex-wrap: wrap;
}
.ad-panel__title {
    font-size: .9rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0;
}
.ad-panel__sub {
    font-size: .75rem;
    color: #64748b;
    margin: 0;
}
.ad-panel__body {
    padding: 1.15rem 1.25rem;
}
.ad-panel__body--flush { padding: 0; }
.ad-panel__chart-wrap {
    min-height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* donut centre */
.hs-lms-donut-wrap { position: relative; }
.hs-lms-donut-center {
    position: absolute;
    inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    pointer-events: none;
}
.hs-lms-donut-total {
    font-size: 1.6rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
}
.hs-lms-donut-sub {
    font-size: .68rem;
    color: #64748b;
    font-weight: 500;
    margin-top: 2px;
}

/* legend */
.hs-lms-legend--grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .3rem .75rem;
    margin-top: .85rem;
}
.hs-lms-legend__item {
    display: flex;
    align-items: center;
    gap: .45rem;
    font-size: .75rem;
    color: #334155;
}
.hs-lms-legend__diamond {
    width: 10px; height: 10px;
    border-radius: 3px;
    flex-shrink: 0;
    background: var(--hs-legend-color, #ccc);
}
.hs-lms-legend__label {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-weight: 500;
}
.hs-lms-legend__count {
    font-weight: 700;
    color: #0f172a;
    flex-shrink: 0;
}
.hs-lms-legend__empty { font-size: .8rem; }

/* ── Tables ── */
.ad-table-panel .ad-panel__body--flush .table {
    margin: 0;
}
.admin-lms-table thead th {
    background: #fafbff;
}

/* ── Empty state ── */
.ad-empty {
    padding: 2.5rem 1.5rem;
    text-align: center;
    color: #94a3b8;
    font-size: .875rem;
}
.ad-empty i {
    font-size: 2rem;
    opacity: .4;
    display: block;
    margin-bottom: .5rem;
}

@media (max-width: 575.98px) {
    .ad-banner { padding: 1.5rem; flex-direction: column; align-items: flex-start; }
    .ad-stat__value { font-size: 1.5rem; }
    .ad-banner__title { font-size: 1.25rem; }
}

/* ── Leave alerts & requests ── */
.admin-lms-nav-link__badge {
    margin-left: auto;
    min-width: 1.35rem;
    height: 1.35rem;
    padding: 0 .4rem;
    border-radius: 999px;
    background: #e11d48;
    color: #fff;
    font-size: .68rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.admin-leave-alerts {
    display: flex;
    flex-direction: column;
    gap: .75rem;
    margin-bottom: 1.25rem;
}
.admin-leave-alert {
    border: 1px solid rgba(178,205,52,.45);
    border-left: 4px solid #b2cd34;
    border-radius: 12px;
    background: linear-gradient(135deg, #fafbe8 0%, #fff 100%);
    padding: .9rem 1rem;
    box-shadow: 0 4px 14px rgba(50,47,137,.08);
    animation: adminLeaveAlertIn .35s ease;
}
.admin-leave-alert.is-closing {
    opacity: 0;
    transform: translateY(-6px);
    transition: opacity .35s ease, transform .35s ease;
}
.admin-leave-alert__head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: .75rem;
}
.admin-leave-alert__title {
    font-size: .92rem;
    font-weight: 700;
    color: #1a1860;
    margin: 0 0 .25rem;
}
.admin-leave-alert__text {
    font-size: .82rem;
    color: #475569;
    margin: 0;
}
.admin-leave-alert__timer {
    font-size: .72rem;
    font-weight: 700;
    color: #6b8c00;
    white-space: nowrap;
}
.admin-leave-alert__actions {
    margin-top: .75rem;
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
}
.admin-leave-actions {
    display: flex;
    flex-wrap: wrap;
    gap: .35rem;
    align-items: flex-start;
}
.admin-leave-actions form {
    display: inline-flex;
    flex-direction: column;
    gap: .25rem;
    min-width: 8rem;
}
.admin-leave-actions .form-control {
    font-size: .75rem;
    padding: .25rem .5rem;
}
.admin-leave-actions .btn {
    font-size: .75rem;
    padding: .25rem .65rem;
}
@keyframes adminLeaveAlertIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@section('content')

<div id="admin-leave-alerts" class="admin-leave-alerts" aria-live="polite" aria-atomic="false"></div>

<script type="application/json" id="admin-leave-alerts-initial">@json($leaveAlertsInitial)</script>

{{-- Welcome banner --}}
<div class="ad-banner">
    <div class="ad-banner__text">
        <p class="ad-banner__eyebrow">Overview</p>
        <h2 class="ad-banner__title">LMS Analytics &amp; Activity</h2>
        <p class="ad-banner__sub">Here's what's happening on your platform right now.</p>
    </div>
    <div class="ad-banner__action">
        <button type="button" class="ad-btn-refresh" id="hs-lms-refresh-stats" data-hs-action="refresh-stats">
            <i class="bi bi-arrow-clockwise me-1" aria-hidden="true"></i> Refresh data
        </button>
    </div>
</div>

{{-- Stat cards --}}
<section class="mb-4 mb-lg-5" aria-labelledby="admin-stats-heading">
    <h2 id="admin-stats-heading" class="visually-hidden">Key metrics</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 g-3">
        <div class="col">
            <article class="ad-stat ad-stat--purple" data-hs-widget="stat-card" data-hs-stat-key="total_students">
                <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-people-fill"></i></div>
                <div class="ad-stat__body">
                    <span class="ad-stat__label">Total Students</span>
                    <span class="ad-stat__value" data-hs-bind="total_students">{{ $summary['total_students'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="ad-stat ad-stat--teal" data-hs-widget="stat-card" data-hs-stat-key="total_teachers">
                <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-person-video3"></i></div>
                <div class="ad-stat__body">
                    <span class="ad-stat__label">Total Teachers</span>
                    <span class="ad-stat__value" data-hs-bind="total_teachers">{{ $summary['total_teachers'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="ad-stat ad-stat--lime" data-hs-widget="stat-card" data-hs-stat-key="total_courses">
                <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-journal-bookmark-fill"></i></div>
                <div class="ad-stat__body">
                    <span class="ad-stat__label">Total Courses</span>
                    <span class="ad-stat__value" data-hs-bind="total_courses">{{ $summary['total_courses'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="ad-stat ad-stat--amber" data-hs-widget="stat-card" data-hs-stat-key="active_classes">
                <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-easel2"></i></div>
                <div class="ad-stat__body">
                    <span class="ad-stat__label">Active Classes</span>
                    <span class="ad-stat__value" data-hs-bind="active_classes">{{ $summary['active_classes'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="ad-stat ad-stat--rose" data-hs-widget="stat-card" data-hs-stat-key="total_enrollments">
                <div class="ad-stat__icon" aria-hidden="true"><i class="bi bi-clipboard-check-fill"></i></div>
                <div class="ad-stat__body">
                    <span class="ad-stat__label">Enrollments</span>
                    <span class="ad-stat__value" data-hs-bind="total_enrollments">{{ $summary['total_enrollments'] }}</span>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- Charts --}}
<section class="mb-4 mb-lg-5" aria-labelledby="charts-heading">
    <div class="ad-section-head">
        <h2 id="charts-heading" class="ad-section-head__title">Analytics</h2>
        <p class="ad-section-head__sub">Enrollment and registration insights</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="ad-panel" data-hs-widget="chart" data-hs-chart-id="studentsPerCourse">
                <div class="ad-panel__head">
                    <div>
                        <h3 class="ad-panel__title">Students per course</h3>
                        <p class="ad-panel__sub">Enrolled students by course</p>
                    </div>
                </div>
                <div class="ad-panel__body">
                    <div class="ad-panel__chart-wrap">
                        <canvas id="hs-chart-students-per-course" height="220" aria-label="Students per course chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ad-panel" data-hs-widget="chart" data-hs-chart-id="teacherStudentRatio">
                <div class="ad-panel__head">
                    <div>
                        <h3 class="ad-panel__title">Teachers vs Students</h3>
                        <p class="ad-panel__sub">Platform user distribution</p>
                    </div>
                </div>
                <div class="ad-panel__body">
                    <div class="ad-panel__chart-wrap">
                        <canvas id="hs-chart-teacher-student" height="220" aria-label="Teacher student ratio chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="ad-panel" data-hs-widget="chart" data-hs-chart-id="newAdmissions">
                <div class="ad-panel__head">
                    <div>
                        <h3 class="ad-panel__title">New Admissions</h3>
                        <p class="ad-panel__sub">Last {{ $charts['newAdmissions']['days'] ?? 30 }} days · by course</p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link admin-lms-icon-btn p-0" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false" title="Options">
                            <i class="bi bi-three-dots-vertical" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><span class="dropdown-item-text small text-muted px-3">Counts new enrollments per course.</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small" href="{{ route('admin.courses.index') }}">Manage courses</a></li>
                        </ul>
                    </div>
                </div>
                <div class="ad-panel__body">
                    <div class="hs-lms-donut-wrap">
                        <canvas id="hs-chart-new-admissions" height="220" aria-label="New admissions by course"></canvas>
                        <div class="hs-lms-donut-center">
                            <span class="hs-lms-donut-total" data-hs-bind="new_admissions_total">{{ $charts['newAdmissions']['total'] ?? 0 }}</span>
                            <span class="hs-lms-donut-sub">Admissions</span>
                        </div>
                    </div>
                    <ul class="hs-lms-legend hs-lms-legend--grid list-unstyled mb-0" id="hs-new-admissions-legend"></ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="ad-panel" data-hs-widget="chart" data-hs-chart-id="registrationTrend">
                <div class="ad-panel__head">
                    <div>
                        <h3 class="ad-panel__title">New Student Registrations</h3>
                        <p class="ad-panel__sub">Last 7 days · daily count</p>
                    </div>
                </div>
                <div class="ad-panel__body">
                    <canvas id="hs-chart-registration-trend" height="100" aria-label="Registration trend chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Pending leave requests --}}
<section class="mb-4 mb-lg-5" aria-labelledby="pending-leave-heading">
    <div class="ad-section-head">
        <h2 id="pending-leave-heading" class="ad-section-head__title">Leave Requests</h2>
        <p class="ad-section-head__sub">Review and approve or reject student leave</p>
    </div>
    <div class="ad-panel ad-table-panel">
        <div class="ad-panel__head">
            <h3 class="ad-panel__title">Pending approval</h3>
            @if($pendingLeaveRequests->isNotEmpty())
                <span class="badge bg-warning text-dark">{{ $pendingLeaveRequests->count() }} pending</span>
            @endif
        </div>
        <div class="ad-panel__body ad-panel__body--flush">
            @if($pendingLeaveRequests->isEmpty())
                <div class="ad-empty"><i class="bi bi-calendar-check"></i>No pending leave requests.</div>
            @else
                <div class="table-responsive">
                    <table class="table admin-lms-table mb-0">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Dates</th>
                                <th>Days</th>
                                <th>Reason</th>
                                <th>Submitted</th>
                                <th style="min-width: 14rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingLeaveRequests as $leave)
                                <tr>
                                    <td>
                                        <span class="fw-500 d-block">{{ $leave->user?->name ?? 'Student' }}</span>
                                        <span class="small text-muted">{{ $leave->user?->email }}</span>
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $leave->start_date->format('M j, Y') }}
                                        @if($leave->start_date->toDateString() !== $leave->end_date->toDateString())
                                            <span class="text-muted">– {{ $leave->end_date->format('M j, Y') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $leave->dayCount() }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($leave->reason, 80) }}</td>
                                    <td class="text-muted text-nowrap">{{ $leave->created_at->format('M j, Y g:i A') }}</td>
                                    <td>
                                        <div class="admin-leave-actions">
                                            <form action="{{ route('admin.leave-requests.approve', $leave) }}" method="POST" onsubmit="return confirm('Approve this leave request?');">
                                                @csrf
                                                <input type="text" name="admin_note" class="form-control form-control-sm" placeholder="Note (optional)" maxlength="1000">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-lg"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.leave-requests.reject', $leave) }}" method="POST" onsubmit="return confirm('Reject this leave request?');">
                                                @csrf
                                                <input type="text" name="admin_note" class="form-control form-control-sm" placeholder="Reason (optional)" maxlength="1000">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-x-lg"></i> Reject
                                                </button>
                                            </form>
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
</section>

{{-- Recent activity --}}
<section aria-labelledby="recent-activity-heading">
    <div class="ad-section-head mb-3">
        <h2 id="recent-activity-heading" class="ad-section-head__title">Recent Activity</h2>
        <p class="ad-section-head__sub">Latest registrations and students</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="ad-panel ad-table-panel">
                <div class="ad-panel__head">
                    <h3 class="ad-panel__title">Recent Registrations</h3>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-sm admin-lms-btn-outline">
                        All students <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="ad-panel__body ad-panel__body--flush">
                    @if($recentRegistrations->isEmpty())
                        <div class="ad-empty"><i class="bi bi-person-x"></i>No registrations yet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table admin-lms-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $u)
                                    <tr>
                                        <td class="fw-500">{{ $u->name }}</td>
                                        <td class="text-muted">{{ $u->email }}</td>
                                        <td><span class="badge admin-lms-badge admin-lms-badge--role">{{ $u->role }}</span></td>
                                        <td class="text-muted">{{ $u->created_at->format('M j, Y') }}</td>
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

<script type="application/json" id="hs-lms-initial-charts">@json($charts)</script>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    const apiUrl = @json($statsApiUrl);

    const parseCharts = () => {
        const el = document.getElementById('hs-lms-initial-charts');
        return el ? JSON.parse(el.textContent) : {};
    };

    let chartPayload = parseCharts();

    const bindSummary = (summary) => {
        if (!summary) return;
        document.querySelectorAll('[data-hs-bind]').forEach((el) => {
            const k = el.getAttribute('data-hs-bind');
            if (k === 'new_admissions_total') return;
            if (summary[k] !== undefined) el.textContent = summary[k];
        });
    };

    const setNewAdmissionsTotal = (n) => {
        document.querySelectorAll('[data-hs-bind="new_admissions_total"]').forEach((el) => {
            el.textContent = n;
        });
    };

    let chartStudents, chartRatio, chartTrend, chartAdmissions;

    const palette = {
        primary: '#322f89',
        teal:    '#0d9488',
        violet:  '#7c3aed',
        amber:   '#d97706',
        rose:    '#e11d48',
        lime:    '#b2cd34',
        grid:    'rgba(148,163,184,0.15)',
    };

    function buildCharts(data) {
        /* Students per course – bar */
        const spc = data.studentsPerCourse || [];
        if (chartStudents) chartStudents.destroy();
        chartStudents = new Chart(document.getElementById('hs-chart-students-per-course'), {
            type: 'bar',
            data: {
                labels: spc.map((x) => x.label),
                datasets: [{ label: 'Enrolled students', data: spc.map((x) => x.count), backgroundColor: palette.primary, borderRadius: 8 }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: palette.grid } },
                    x: { grid: { display: false } },
                },
            },
        });

        /* Teacher/student ratio – doughnut */
        const ratio = data.teacherStudentRatio || { labels: [], counts: [] };
        if (chartRatio) chartRatio.destroy();
        chartRatio = new Chart(document.getElementById('hs-chart-teacher-student'), {
            type: 'doughnut',
            data: {
                labels: ratio.labels,
                datasets: [{ data: ratio.counts, backgroundColor: [palette.teal, palette.primary], borderWidth: 3, borderColor: '#fff' }],
            },
            options: { responsive: true, cutout: '60%', plugins: { legend: { position: 'bottom' } } },
        });

        /* Registration trend – line */
        const trend = data.registrationTrend || [];
        if (chartTrend) chartTrend.destroy();
        chartTrend = new Chart(document.getElementById('hs-chart-registration-trend'), {
            type: 'line',
            data: {
                labels: trend.map((x) => x.label),
                datasets: [{
                    label: 'New students',
                    data: trend.map((x) => x.count),
                    borderColor: palette.primary,
                    backgroundColor: 'rgba(50,47,137,0.08)',
                    fill: true,
                    tension: 0.38,
                    pointBackgroundColor: palette.primary,
                    pointRadius: 4,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: palette.grid } },
                    x: { grid: { display: false } },
                },
            },
        });

        /* New admissions – donut */
        const na = data.newAdmissions || { total: 0, segments: [] };
        setNewAdmissionsTotal(na.total);

        const legEl = document.getElementById('hs-new-admissions-legend');
        if (legEl) {
            legEl.innerHTML = '';
            if (!na.segments || na.segments.length === 0 || na.total === 0) {
                const li = document.createElement('li');
                li.className = 'hs-lms-legend__empty small text-muted text-center py-2 w-100';
                li.textContent = 'No new enrollments in the last ' + (na.days || 30) + ' days.';
                legEl.appendChild(li);
            } else {
                na.segments.forEach((s) => {
                    const li = document.createElement('li');
                    li.className = 'hs-lms-legend__item';
                    const lab = String(s.label).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
                    li.innerHTML =
                        '<span class="hs-lms-legend__diamond" style="--hs-legend-color:' + String(s.color).replace(/[^#0-9a-fA-F,]/g, '') + '" aria-hidden="true"></span>' +
                        '<span class="hs-lms-legend__label">' + lab + '</span>' +
                        '<span class="hs-lms-legend__count">' + Number(s.count) + '</span>';
                    legEl.appendChild(li);
                });
            }
        }

        const admCanvas = document.getElementById('hs-chart-new-admissions');
        if (admCanvas) {
            if (chartAdmissions) chartAdmissions.destroy();
            let dLabels, dData, dColors;
            if (!na.segments || na.segments.length === 0 || na.total === 0) {
                dLabels = ['—']; dData = [1]; dColors = ['#e2e8f0'];
            } else {
                dLabels = na.segments.map((s) => s.label);
                dData   = na.segments.map((s) => s.count);
                dColors = na.segments.map((s) => s.color);
            }
            chartAdmissions = new Chart(admCanvas, {
                type: 'doughnut',
                data: { labels: dLabels, datasets: [{ data: dData, backgroundColor: dColors, borderWidth: 3, borderColor: '#fff', hoverOffset: 6 }] },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '66%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (ctx) => na.total === 0 ? 'No admissions yet' : ctx.label + ': ' + ctx.raw } },
                    },
                },
            });
        }
    }

    bindSummary(chartPayload.summary);
    buildCharts(chartPayload);

    document.getElementById('hs-lms-refresh-stats')?.addEventListener('click', async () => {
        const btn = document.getElementById('hs-lms-refresh-stats');
        btn?.classList.add('is-loading');
        try {
            const res = await fetch(apiUrl, { credentials: 'same-origin', headers: { Accept: 'application/json' } });
            if (!res.ok) throw new Error('Network error');
            chartPayload = await res.json();
            bindSummary(chartPayload.summary);
            buildCharts(chartPayload);
        } catch (e) {
            console.error(e);
        } finally {
            btn?.classList.remove('is-loading');
        }
    });
})();

(function () {
    const alertsUrl = @json($leaveAlertsApiUrl);
    const alertWindowMs = @json($leaveAlertMinutes * 60 * 1000);
    const container = document.getElementById('admin-leave-alerts');
    if (!container || !alertsUrl) return;

    const activeTimers = new Map();
    const renderedIds = new Set();

    const escapeHtml = (value) => String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/"/g, '&quot;');

    const formatTimer = (seconds) => {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return mins + ':' + String(secs).padStart(2, '0');
    };

    const removeAlert = (id) => {
        const el = container.querySelector('[data-leave-alert-id="' + id + '"]');
        if (!el) return;
        el.classList.add('is-closing');
        setTimeout(() => el.remove(), 350);
        if (activeTimers.has(id)) {
            clearInterval(activeTimers.get(id));
            activeTimers.delete(id);
        }
        renderedIds.delete(id);
    };

    const scheduleRemoval = (alert) => {
        const expiresAt = new Date(alert.expires_at).getTime();
        const tick = () => {
            const remainingMs = expiresAt - Date.now();
            const timerEl = container.querySelector('[data-leave-alert-id="' + alert.id + '"] .admin-leave-alert__timer');
            if (remainingMs <= 0) {
                removeAlert(alert.id);
                return;
            }
            if (timerEl) {
                timerEl.textContent = 'Auto-hide in ' + formatTimer(Math.ceil(remainingMs / 1000));
            }
        };
        tick();
        if (activeTimers.has(alert.id)) clearInterval(activeTimers.get(alert.id));
        activeTimers.set(alert.id, setInterval(tick, 1000));
    };

    const renderAlert = (alert) => {
        if (renderedIds.has(alert.id)) return;
        renderedIds.add(alert.id);

        const el = document.createElement('div');
        el.className = 'admin-leave-alert';
        el.setAttribute('data-leave-alert-id', alert.id);
        el.setAttribute('role', 'alert');
        el.innerHTML =
            '<div class="admin-leave-alert__head">' +
                '<div>' +
                    '<p class="admin-leave-alert__title"><i class="bi bi-bell-fill me-1"></i> New leave request</p>' +
                    '<p class="admin-leave-alert__text">' +
                        '<strong>' + escapeHtml(alert.student_name) + '</strong> requested leave for ' +
                        escapeHtml(alert.start_date) +
                        (alert.start_date !== alert.end_date ? ' – ' + escapeHtml(alert.end_date) : '') +
                        ' (' + Number(alert.days) + ' day' + (Number(alert.days) === 1 ? '' : 's') + ').' +
                    '</p>' +
                    '<p class="admin-leave-alert__text mb-0">' + escapeHtml(alert.reason) + '</p>' +
                '</div>' +
                '<span class="admin-leave-alert__timer">Auto-hide in ' + formatTimer(Math.max(0, Number(alert.seconds_remaining) || 0)) + '</span>' +
            '</div>' +
            '<div class="admin-leave-alert__actions">' +
                '<a href="#pending-leave-heading" class="btn btn-sm btn-primary">Review below</a>' +
                '<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss-leave-alert="' + alert.id + '">Dismiss</button>' +
            '</div>';
        container.prepend(el);
        scheduleRemoval(alert);
    };

    container.addEventListener('click', (event) => {
        const btn = event.target.closest('[data-dismiss-leave-alert]');
        if (!btn) return;
        removeAlert(btn.getAttribute('data-dismiss-leave-alert'));
    });

    const loadAlerts = async () => {
        try {
            const res = await fetch(alertsUrl, { credentials: 'same-origin', headers: { Accept: 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();
            (data.alerts || []).forEach(renderAlert);
        } catch (e) {
            console.error(e);
        }
    };

    const initialEl = document.getElementById('admin-leave-alerts-initial');
    if (initialEl) {
        try {
            JSON.parse(initialEl.textContent).forEach(renderAlert);
        } catch (e) {
            console.error(e);
        }
    }

    loadAlerts();
    setInterval(loadAlerts, 20000);
})();
</script>
@endpush
