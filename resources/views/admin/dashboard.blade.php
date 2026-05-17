@extends('admin.layout')
@section('title', 'LMS Dashboard')
@section('page_heading', 'LMS Dashboard')

@section('content')
<section class="admin-dash-toolbar mb-4" aria-label="Dashboard actions">
    <div class="admin-dash-welcome">
        <p class="admin-dash-welcome__eyebrow mb-1">Overview</p>
        <h2 class="admin-dash-welcome__title mb-0">LMS analytics & activity</h2>
    </div>
    <button type="button" class="btn btn-sm admin-lms-btn-primary" id="hs-lms-refresh-stats" data-hs-action="refresh-stats">
        <i class="bi bi-arrow-clockwise" aria-hidden="true"></i> Refresh data
    </button>
</section>

<section class="mb-4 mb-lg-5" aria-labelledby="admin-stats-heading">
    <h2 id="admin-stats-heading" class="visually-hidden">Key metrics</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 g-3 g-lg-4">
        <div class="col">
            <article class="admin-dash-stat admin-dash-stat--primary" data-hs-widget="stat-card" data-hs-stat-key="total_students">
                <div class="admin-dash-stat__icon" aria-hidden="true"><i class="bi bi-people-fill"></i></div>
                <div class="admin-dash-stat__body">
                    <span class="admin-dash-stat__label">Total Students</span>
                    <span class="admin-dash-stat__value" data-hs-bind="total_students">{{ $summary['total_students'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="admin-dash-stat admin-dash-stat--teal" data-hs-widget="stat-card" data-hs-stat-key="total_teachers">
                <div class="admin-dash-stat__icon" aria-hidden="true"><i class="bi bi-person-video3"></i></div>
                <div class="admin-dash-stat__body">
                    <span class="admin-dash-stat__label">Total Teachers</span>
                    <span class="admin-dash-stat__value" data-hs-bind="total_teachers">{{ $summary['total_teachers'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="admin-dash-stat admin-dash-stat--violet" data-hs-widget="stat-card" data-hs-stat-key="total_courses">
                <div class="admin-dash-stat__icon" aria-hidden="true"><i class="bi bi-journal-bookmark-fill"></i></div>
                <div class="admin-dash-stat__body">
                    <span class="admin-dash-stat__label">Total Courses</span>
                    <span class="admin-dash-stat__value" data-hs-bind="total_courses">{{ $summary['total_courses'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="admin-dash-stat admin-dash-stat--amber" data-hs-widget="stat-card" data-hs-stat-key="active_classes">
                <div class="admin-dash-stat__icon" aria-hidden="true"><i class="bi bi-easel2"></i></div>
                <div class="admin-dash-stat__body">
                    <span class="admin-dash-stat__label">Active Classes</span>
                    <span class="admin-dash-stat__value" data-hs-bind="active_classes">{{ $summary['active_classes'] }}</span>
                </div>
            </article>
        </div>
        <div class="col">
            <article class="admin-dash-stat admin-dash-stat--rose" data-hs-widget="stat-card" data-hs-stat-key="total_enrollments">
                <div class="admin-dash-stat__icon" aria-hidden="true"><i class="bi bi-clipboard-check"></i></div>
                <div class="admin-dash-stat__body">
                    <span class="admin-dash-stat__label">Enrollments</span>
                    <span class="admin-dash-stat__value" data-hs-bind="total_enrollments">{{ $summary['total_enrollments'] }}</span>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="mb-4 mb-lg-5" aria-labelledby="charts-heading">
    <header class="admin-dash-section-head admin-dash-section-head--compact">
        <h2 id="charts-heading" class="admin-dash-section-head__title">Analytics</h2>
        <p class="admin-dash-section-head__sub">Enrollment and registration insights</p>
    </header>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="hs-lms-panel admin-lms-chart-panel" data-hs-widget="chart" data-hs-chart-id="studentsPerCourse">
                <div class="hs-lms-panel__head">
                    <h3 class="hs-lms-panel__title">Students per course</h3>
                </div>
                <div class="hs-lms-panel__body admin-lms-chart-panel__body">
                    <canvas id="hs-chart-students-per-course" height="220" aria-label="Students per course chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="hs-lms-panel admin-lms-chart-panel" data-hs-widget="chart" data-hs-chart-id="teacherStudentRatio">
                <div class="hs-lms-panel__head">
                    <h3 class="hs-lms-panel__title">Teachers vs students</h3>
                </div>
                <div class="hs-lms-panel__body admin-lms-chart-panel__body admin-lms-chart-panel__body--donut">
                    <canvas id="hs-chart-teacher-student" height="220" aria-label="Teacher student ratio chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="hs-lms-panel hs-lms-panel--admissions admin-lms-chart-panel" data-hs-widget="chart" data-hs-chart-id="newAdmissions">
                <div class="hs-lms-panel__head hs-lms-panel__head--row d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="hs-lms-panel__title mb-0">New Admissions</h3>
                        <span class="hs-lms-panel__subtitle small text-muted">Last {{ $charts['newAdmissions']['days'] ?? 30 }} days · by course</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-link admin-lms-icon-btn p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Options">
                            <i class="bi bi-three-dots-vertical fs-5" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><span class="dropdown-item-text small text-muted px-3">Counts new enrollments per course.</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small" href="{{ route('admin.courses.index') }}">Manage courses</a></li>
                        </ul>
                    </div>
                </div>
                <div class="hs-lms-panel__body">
                    <div class="hs-lms-donut-wrap">
                        <canvas id="hs-chart-new-admissions" height="220" aria-label="New admissions by course"></canvas>
                        <div class="hs-lms-donut-center">
                            <span class="hs-lms-donut-total" data-hs-bind="new_admissions_total">{{ $charts['newAdmissions']['total'] ?? 0 }}</span>
                            <span class="hs-lms-donut-sub">Total Admissions</span>
                        </div>
                    </div>
                    <ul class="hs-lms-legend hs-lms-legend--grid list-unstyled mb-0" id="hs-new-admissions-legend"></ul>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="hs-lms-panel admin-lms-chart-panel" data-hs-widget="chart" data-hs-chart-id="registrationTrend">
                <div class="hs-lms-panel__head">
                    <h3 class="hs-lms-panel__title">New student registrations (last 7 days)</h3>
                </div>
                <div class="hs-lms-panel__body admin-lms-chart-panel__body">
                    <canvas id="hs-chart-registration-trend" height="100" aria-label="Registration trend chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<section aria-labelledby="recent-activity-heading">
    <header class="admin-dash-section-head">
        <div>
            <h2 id="recent-activity-heading" class="admin-dash-section-head__title">Recent activity</h2>
            <p class="admin-dash-section-head__sub">Latest registrations and students</p>
        </div>
    </header>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="admin-lms-panel">
                <div class="admin-lms-panel__head d-flex justify-content-between align-items-center">
                    <h3 class="admin-lms-panel__title mb-0">Recent registrations</h3>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-sm admin-lms-btn-outline">Students</a>
                </div>
                <div class="admin-lms-panel__body admin-lms-panel__body--flush">
                    @if($recentRegistrations->isEmpty())
                        <p class="admin-lms-empty mb-0">No registrations yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table admin-lms-table mb-0">
                                <thead>
                                    <tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($recentRegistrations as $u)
                                    <tr>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td><span class="badge admin-lms-badge admin-lms-badge--role">{{ $u->role }}</span></td>
                                        <td>{{ $u->created_at->format('M j, Y') }}</td>
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
            <div class="admin-lms-panel">
                <div class="admin-lms-panel__head d-flex justify-content-between align-items-center">
                    <h3 class="admin-lms-panel__title mb-0">Recent students</h3>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-sm admin-lms-btn-outline">View all</a>
                </div>
                <div class="admin-lms-panel__body admin-lms-panel__body--flush">
                    @if($stats['recent_students']->isEmpty())
                        <p class="admin-lms-empty mb-0">No students yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table admin-lms-table mb-0">
                                <thead>
                                    <tr><th>Name</th><th>Email</th><th></th></tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_students'] as $u)
                                    <tr>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.students.show', $u) }}" class="btn btn-sm admin-lms-btn-outline">View</a>
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
        primary: '#4f46e5',
        teal: '#0d9488',
        violet: '#7c3aed',
        amber: '#d97706',
        rose: '#e11d48',
        grid: 'rgba(148,163,184,0.2)',
    };

    function buildCharts(data) {
        const spc = data.studentsPerCourse || [];
        const labels = spc.map((x) => x.label);
        const counts = spc.map((x) => x.count);

        if (chartStudents) chartStudents.destroy();
        chartStudents = new Chart(document.getElementById('hs-chart-students-per-course'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Enrolled students',
                    data: counts,
                    backgroundColor: palette.primary,
                    borderRadius: 8,
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

        const ratio = data.teacherStudentRatio || { labels: [], counts: [] };
        if (chartRatio) chartRatio.destroy();
        chartRatio = new Chart(document.getElementById('hs-chart-teacher-student'), {
            type: 'doughnut',
            data: {
                labels: ratio.labels,
                datasets: [{
                    data: ratio.counts,
                    backgroundColor: [palette.teal, palette.primary],
                }],
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
        });

        const trend = data.registrationTrend || [];
        if (chartTrend) chartTrend.destroy();
        chartTrend = new Chart(document.getElementById('hs-chart-registration-trend'), {
            type: 'line',
            data: {
                labels: trend.map((x) => x.label),
                datasets: [{
                    label: 'New students',
                    data: trend.map((x) => x.count),
                    borderColor: palette.violet,
                    backgroundColor: 'rgba(124,58,237,0.1)',
                    fill: true,
                    tension: 0.35,
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
                dLabels = ['—'];
                dData = [1];
                dColors = ['#e2e8f0'];
            } else {
                dLabels = na.segments.map((s) => s.label);
                dData = na.segments.map((s) => s.count);
                dColors = na.segments.map((s) => s.color);
            }
            chartAdmissions = new Chart(admCanvas, {
                type: 'doughnut',
                data: {
                    labels: dLabels,
                    datasets: [{
                        data: dData,
                        backgroundColor: dColors,
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    cutout: '66%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    if (na.total === 0) return 'No admissions yet';
                                    return ctx.label + ': ' + ctx.raw;
                                },
                            },
                        },
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
            if (!res.ok) throw new Error('Network');
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
</script>
@endpush
