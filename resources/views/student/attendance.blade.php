@extends('student.layout')
@section('title', 'Attendance')
@section('page_heading', 'Attendance')

@section('content')
@php
    $attendancePct = $attendance['percentage'] !== null ? (float) $attendance['percentage'] : null;
    $pctDisplay    = $attendancePct !== null ? number_format($attendancePct, 0) : '—';
    $pctColor      = $attendancePct === null ? '#94a3b8'
                   : ($attendancePct >= 80  ? '#0d9488'
                   : ($attendancePct >= 60  ? '#d97706' : '#e11d48'));
    $pctLabel      = $attendancePct === null ? 'No data'
                   : ($attendancePct >= 80  ? 'Good standing'
                   : ($attendancePct >= 60  ? 'Needs improvement' : 'At risk'));
@endphp

{{-- ── Hero overview ── --}}
<div class="att-hero mb-4">
    {{-- Rate ring --}}
    <div class="att-hero__ring-wrap" aria-label="Attendance rate: {{ $pctDisplay }}%">
        <svg class="att-ring" viewBox="0 0 100 100" aria-hidden="true">
            <circle class="att-ring__track" cx="50" cy="50" r="42"/>
            <circle class="att-ring__fill" cx="50" cy="50" r="42"
                stroke="{{ $pctColor }}"
                style="stroke-dashoffset: calc(264 - (264 * {{ $attendancePct ?? 0 }}) / 100);"/>
        </svg>
        <div class="att-ring__center">
            <span class="att-ring__pct" style="color:{{ $pctColor }};">{{ $pctDisplay }}@if($attendancePct !== null)<span class="att-ring__symbol">%</span>@endif</span>
            <span class="att-ring__label">Rate</span>
        </div>
    </div>

    {{-- Summary text + stats --}}
    <div class="att-hero__body">
        <p class="att-hero__eyebrow">Attendance Overview</p>
        <h2 class="att-hero__title">Your Attendance Record</h2>
        <p class="att-hero__status" style="color:{{ $pctColor }};">
            <i class="bi bi-circle-fill me-1" style="font-size:.55rem; vertical-align:middle;"></i>{{ $pctLabel }}
        </p>

        <div class="att-hero__stats">
            <div class="att-mini-stat att-mini-stat--teal">
                <i class="bi bi-check-circle-fill"></i>
                <span class="att-mini-stat__val">{{ $attendance['present_count'] }}</span>
                <span class="att-mini-stat__lbl">Present</span>
            </div>
            <div class="att-mini-stat att-mini-stat--rose">
                <i class="bi bi-x-circle-fill"></i>
                <span class="att-mini-stat__val">{{ $attendance['absent_count'] }}</span>
                <span class="att-mini-stat__lbl">Absent</span>
            </div>
            <div class="att-mini-stat att-mini-stat--amber">
                <i class="bi bi-clock-fill"></i>
                <span class="att-mini-stat__val">{{ $attendance['late_count'] }}</span>
                <span class="att-mini-stat__lbl">Late</span>
            </div>
            <div class="att-mini-stat att-mini-stat--violet">
                <i class="bi bi-shield-check"></i>
                <span class="att-mini-stat__val">{{ $attendance['excused_count'] }}</span>
                <span class="att-mini-stat__lbl">Excused</span>
            </div>
            <div class="att-mini-stat att-mini-stat--primary">
                <i class="bi bi-hourglass-split"></i>
                <span class="att-mini-stat__val">{{ $attendance['pending_leave_count'] }}</span>
                <span class="att-mini-stat__lbl">Pending</span>
            </div>
        </div>
    </div>
</div>

{{-- ── Leave request + history ── --}}
<div class="row g-4 g-xl-5 align-items-start mb-4 mb-lg-5">

    <div class="col-12 col-lg-5">
        <div class="att-panel">
            <div class="att-panel__head">
                <div class="att-panel__icon att-panel__icon--primary"><i class="bi bi-send-fill"></i></div>
                <div>
                    <h3 class="att-panel__title">Request Leave</h3>
                    <p class="att-panel__sub">Submit a request for admin review</p>
                </div>
            </div>
            <div class="att-panel__body">
                <form action="{{ route('student.leave-requests.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="leave_start_date" class="form-label att-label">Start Date</label>
                        <input type="date" name="start_date" id="leave_start_date"
                            class="form-control att-input @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date') }}"
                            min="{{ now()->toDateString() }}" required>
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="leave_end_date" class="form-label att-label">End Date</label>
                        <input type="date" name="end_date" id="leave_end_date"
                            class="form-control att-input @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date') }}"
                            min="{{ now()->toDateString() }}" required>
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label for="leave_reason" class="form-label att-label">Reason</label>
                        <textarea name="reason" id="leave_reason" rows="4"
                            class="form-control att-input @error('reason') is-invalid @enderror"
                            placeholder="Briefly explain why you need leave…" required>{{ old('reason') }}</textarea>
                        @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-lms-primary w-100 att-submit-btn">
                        <i class="bi bi-send me-2" aria-hidden="true"></i>Submit Leave Request
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="att-panel">
            <div class="att-panel__head">
                <div class="att-panel__icon att-panel__icon--violet"><i class="bi bi-calendar2-week-fill"></i></div>
                <div>
                    <h3 class="att-panel__title">Leave Requests</h3>
                    <p class="att-panel__sub">Your submitted leave requests</p>
                </div>
            </div>
            <div class="att-panel__body--flush">
                @if($attendance['leave_requests']->isEmpty())
                    <div class="att-empty">
                        <i class="bi bi-calendar-x"></i>
                        <p>No leave requests yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table student-dash-table att-table mb-0">
                            <thead>
                                <tr>
                                    <th>Dates</th>
                                    <th>Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance['leave_requests'] as $leave)
                                    @php
                                        $sc = match($leave->status) {
                                            'approved' => 'att-status att-status--green',
                                            'rejected' => 'att-status att-status--red',
                                            default    => 'att-status att-status--amber',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="text-nowrap">
                                            <span class="att-date">{{ $leave->start_date->format('M j') }}</span>
                                            @if($leave->start_date->toDateString() !== $leave->end_date->toDateString())
                                                <span class="text-muted"> – {{ $leave->end_date->format('M j, Y') }}</span>
                                            @else
                                                <span class="text-muted">, {{ $leave->start_date->format('Y') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $leave->dayCount() }}</td>
                                        <td class="text-muted">{{ \Illuminate\Support\Str::limit($leave->reason, 50) }}</td>
                                        <td><span class="{{ $sc }}">{{ $leave->statusLabel() }}</span></td>
                                        <td class="text-muted">{{ $leave->admin_note ?: '—' }}</td>
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

{{-- ── Info row: last active + overall rate ── --}}
<div class="row g-3 g-lg-4 mb-4">
    <div class="col-md-6">
        <div class="att-info-card">
            <div class="att-info-card__icon att-info-card__icon--primary">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <span class="att-info-card__label">Last Active</span>
                @if($user->last_active_at)
                    <span class="att-info-card__value">{{ $user->last_active_at->format('M j, Y · g:i A') }}</span>
                @else
                    <span class="att-info-card__value text-muted">No activity recorded yet</span>
                @endif
                <span class="att-info-card__meta">Member since {{ $user->created_at->format('M j, Y') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="att-info-card">
            <div class="att-info-card__icon att-info-card__icon--teal">
                <i class="bi bi-percent"></i>
            </div>
            <div class="flex-grow-1">
                <span class="att-info-card__label">Overall Attendance Rate</span>
                @if($attendancePct !== null)
                    <div class="d-flex align-items-center gap-3 mt-1">
                        <div class="att-bar-wrap flex-grow-1">
                            <div class="att-bar" style="width:{{ min(100,$attendancePct) }}%; background:{{ $pctColor }};"></div>
                        </div>
                        <span class="att-bar-pct" style="color:{{ $pctColor }};">{{ number_format($attendancePct,1) }}%</span>
                    </div>
                @else
                    <span class="att-info-card__value text-muted">Not recorded yet</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ── Daily attendance records ── --}}
<div class="att-panel">
    <div class="att-panel__head">
        <div class="att-panel__icon att-panel__icon--teal"><i class="bi bi-calendar-check-fill"></i></div>
        <div>
            <h3 class="att-panel__title">Attendance Records</h3>
            <p class="att-panel__sub">Complete daily attendance history</p>
        </div>
    </div>
    <div class="att-panel__body--flush">
        @if($attendance['records']->isEmpty())
            <div class="att-empty">
                <i class="bi bi-calendar2-week"></i>
                <p>No daily records yet.</p>
                <small class="text-muted">Your school will mark daily attendance here. Submit a leave request above when needed.</small>
            </div>
        @else
            <div class="table-responsive">
                <table class="table student-dash-table att-table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendance['records'] as $record)
                            @php
                                $sc = match($record->status) {
                                    'present' => 'att-status att-status--green',
                                    'absent'  => 'att-status att-status--red',
                                    'late'    => 'att-status att-status--amber',
                                    'excused' => 'att-status att-status--blue',
                                    default   => 'att-status',
                                };
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $record->record_date->format('M j, Y') }}</td>
                                <td class="text-muted">{{ $record->record_date->format('l') }}</td>
                                <td><span class="{{ $sc }}">{{ $record->statusLabel() }}</span></td>
                                <td class="text-muted">{{ $record->notes ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<style>
/* ── Hero ── */
.att-hero {
    background: #fff;
    border: 1px solid #e0e7ff;
    border-radius: 16px;
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
    box-shadow: 0 1px 3px rgba(15,23,42,.04), 0 8px 24px rgba(79,70,229,.07);
}

/* Ring */
.att-hero__ring-wrap {
    position: relative;
    width: 130px;
    height: 130px;
    flex-shrink: 0;
}
.att-ring {
    width: 100%; height: 100%;
    transform: rotate(-90deg);
}
.att-ring__track {
    fill: none;
    stroke: #f1f5f9;
    stroke-width: 10;
}
.att-ring__fill {
    fill: none;
    stroke-width: 10;
    stroke-linecap: round;
    stroke-dasharray: 264;
    transition: stroke-dashoffset .6s ease;
}
.att-ring__center {
    position: absolute;
    inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
}
.att-ring__pct {
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1;
    display: flex; align-items: flex-start;
}
.att-ring__symbol { font-size: .95rem; margin-top: .2rem; font-weight: 700; }
.att-ring__label {
    font-size: .65rem;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #94a3b8;
    margin-top: 2px;
}

/* Hero text */
.att-hero__body { flex: 1; min-width: 200px; }
.att-hero__eyebrow {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: #6366f1;
    margin-bottom: .25rem;
}
.att-hero__title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: .25rem;
}
.att-hero__status {
    font-size: .8rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

/* Mini stats strip */
.att-hero__stats {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
}
.att-mini-stat {
    display: flex;
    align-items: center;
    gap: .4rem;
    background: #f8f9ff;
    border: 1px solid #e0e7ff;
    border-radius: 999px;
    padding: .3rem .75rem;
    font-size: .78rem;
}
.att-mini-stat i { font-size: .8rem; }
.att-mini-stat__val { font-weight: 700; color: #0f172a; }
.att-mini-stat__lbl { color: #64748b; }
.att-mini-stat--teal   { border-color: #a7f3d0; } .att-mini-stat--teal   i { color: #0d9488; }
.att-mini-stat--rose   { border-color: #fecdd3; } .att-mini-stat--rose   i { color: #e11d48; }
.att-mini-stat--amber  { border-color: #fde68a; } .att-mini-stat--amber  i { color: #d97706; }
.att-mini-stat--violet { border-color: #ddd6fe; } .att-mini-stat--violet i { color: #7c3aed; }
.att-mini-stat--primary{ border-color: #c7d2fe; } .att-mini-stat--primary i { color: #4f46e5; }

/* ── Panel ── */
.att-panel {
    background: #fff;
    border: 1px solid #e4e4f0;
    border-radius: 14px;
    box-shadow: 0 1px 3px rgba(15,23,42,.04), 0 6px 18px rgba(15,23,42,.05);
    overflow: hidden;
}
.att-panel__head {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f0f0f8;
    background: #fafbff;
    display: flex;
    align-items: center;
    gap: .85rem;
}
.att-panel__icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.att-panel__icon--primary { background: #eef2ff; color: #4f46e5; }
.att-panel__icon--violet  { background: #f5f3ff; color: #7c3aed; }
.att-panel__icon--teal    { background: #f0fdfb; color: #0d9488; }
.att-panel__title {
    font-size: .92rem;
    font-weight: 600;
    color: #0f172a;
    margin: 0;
    line-height: 1.3;
}
.att-panel__sub {
    font-size: .75rem;
    color: #64748b;
    margin: 0;
}
.att-panel__body { padding: 1.25rem; }
.att-panel__body--flush { padding: 0; }

/* ── Form ── */
.att-label {
    font-size: .8rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: .35rem;
}
.att-input {
    border-color: #e0e7ff;
    border-radius: 9px !important;
    font-size: .875rem;
    transition: border-color .2s, box-shadow .2s;
}
.att-input:focus {
    border-color: #818cf8;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.att-submit-btn {
    border-radius: 10px !important;
    font-size: .875rem !important;
    font-weight: 600 !important;
    padding: .65rem 1rem !important;
}

/* ── Status badges ── */
.att-status {
    display: inline-flex;
    align-items: center;
    padding: .25rem .65rem;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    white-space: nowrap;
}
.att-status--green  { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
.att-status--red    { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
.att-status--amber  { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
.att-status--blue   { background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; }
.att-date { font-weight: 600; color: #0f172a; }

/* ── Info cards ── */
.att-info-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: #fff;
    border: 1px solid #e4e4f0;
    border-radius: 12px;
    padding: 1.1rem 1.25rem;
    box-shadow: 0 1px 3px rgba(15,23,42,.04);
    height: 100%;
}
.att-info-card__icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.att-info-card__icon--primary { background: #eef2ff; color: #4f46e5; }
.att-info-card__icon--teal    { background: #f0fdfb; color: #0d9488; }
.att-info-card__label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #94a3b8;
    display: block;
    margin-bottom: .3rem;
}
.att-info-card__value {
    font-size: .9rem;
    font-weight: 600;
    color: #0f172a;
    display: block;
}
.att-info-card__meta {
    font-size: .75rem;
    color: #94a3b8;
    display: block;
    margin-top: .25rem;
}

/* Progress bar */
.att-bar-wrap {
    height: 7px;
    background: #f1f5f9;
    border-radius: 999px;
    overflow: hidden;
}
.att-bar {
    height: 100%;
    border-radius: 999px;
    transition: width .5s ease;
}
.att-bar-pct { font-size: .82rem; font-weight: 700; flex-shrink: 0; }

/* ── Table ── */
.att-table thead th { background: #fafbff; }

/* ── Empty ── */
.att-empty {
    padding: 2.75rem 1.5rem;
    text-align: center;
    color: #94a3b8;
}
.att-empty i {
    font-size: 2.2rem;
    opacity: .4;
    display: block;
    margin-bottom: .75rem;
}
.att-empty p { font-size: .875rem; margin-bottom: .25rem; }

@media (max-width: 575.98px) {
    .att-hero { padding: 1.25rem; gap: 1.25rem; }
    .att-hero__ring-wrap { width: 100px; height: 100px; }
    .att-ring__pct { font-size: 1.3rem; }
}
</style>
@endsection
