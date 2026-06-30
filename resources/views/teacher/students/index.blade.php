@extends('teacher.layout')
@section('title', 'Students')
@section('page_heading', 'Students')

@section('content')

{{-- Page toolbar --}}
<div class="stu-toolbar mb-4">
    <div class="stu-toolbar__left">
        <h2 class="stu-toolbar__title">My Students</h2>
        <span class="stu-toolbar__count">
            {{ $students->total() }} {{ Str::plural('student', $students->total()) }}
        </span>
    </div>
    <a href="{{ route('teacher.students.create') }}" class="btn btn-primary stu-add-btn">
        <i class="bi bi-plus-lg me-1"></i> Add Student
    </a>
</div>

{{-- Main card --}}
<div class="ad-panel">

    {{-- Search bar --}}
    <div class="stu-search-bar">
        <form method="GET" action="{{ route('teacher.students.index') }}" class="stu-search-form">
            <div class="stu-search-input-wrap">
                <i class="bi bi-search stu-search-icon" aria-hidden="true"></i>
                <input type="text" name="q" class="form-control stu-search-input"
                    placeholder="Search by name, email, or student ID…"
                    value="{{ request('q') }}"
                    autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary stu-search-btn">Search</button>
            @if(request('q'))
                <a href="{{ route('teacher.students.index') }}" class="btn admin-lms-btn-outline stu-search-btn">
                    <i class="bi bi-x-lg me-1"></i>Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="ad-panel__body ad-panel__body--flush">
        <div class="table-responsive">
            <table class="table admin-lms-table mb-0">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subjects</th>
                        <th>Guardian</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>
                            @if($student->studentProfile)
                                <span class="stu-id-badge">{{ $student->studentProfile->student_id_number }}</span>
                            @else
                                <span class="stu-incomplete">
                                    <i class="bi bi-exclamation-circle me-1"></i>Incomplete
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="stu-name-cell">
                                <span class="stu-avatar" aria-hidden="true">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </span>
                                <span class="stu-name">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $student->email }}</td>
                        <td>
                            @if($student->assignedSubjects->count() > 0)
                                <span class="badge bg-info">{{ $student->assignedSubjects->count() }}</span>
                            @else
                                <span class="text-muted">0</span>
                            @endif
                        </td>
                        <td>
                            @if($student->studentProfile && $student->studentProfile->guardian_name)
                                {{ $student->studentProfile->guardian_name }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $student->created_at->format('M j, Y') }}</td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('teacher.students.show', $student) }}"
                                    class="btn btn-sm admin-lms-btn-outline stu-row-btn">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <a href="{{ route('teacher.students.assign-subject', $student) }}"
                                    class="btn btn-sm btn-info stu-row-btn">
                                    <i class="bi bi-book-half me-1"></i>Subjects
                                </a>
                                <a href="{{ route('teacher.students.edit', $student) }}"
                                    class="btn btn-sm stu-edit-btn">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="ad-empty">
                                <i class="bi bi-people d-block mb-2"></i>
                                @if(request('q'))
                                    No students found for <strong>"{{ request('q') }}"</strong>.
                                    <a href="{{ route('teacher.students.index') }}" class="d-block mt-1 small">Clear search</a>
                                @else
                                    No students have registered yet.
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="stu-pagination">
                <p class="stu-pagination__summary">
                    Showing <strong>{{ $students->firstItem() }}</strong> to <strong>{{ $students->lastItem() }}</strong>
                    of <strong>{{ $students->total() }}</strong> students
                </p>
                {{ $students->onEachSide(1)->links() }}
            </div>
        @endif
    </div>

</div>

<style>
/* ── Toolbar ── */
.stu-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.stu-toolbar__left {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}
.stu-toolbar__title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.stu-toolbar__count {
    background: #eeedf8;
    color: #322f89;
    font-size: .75rem;
    font-weight: 700;
    padding: .25rem .65rem;
    border-radius: 999px;
    border: 1px solid #d1d0f0;
}
.stu-add-btn {
    font-size: .82rem !important;
    border-radius: 9px !important;
    padding: .55rem 1.1rem !important;
    font-weight: 600 !important;
}

/* ── Search bar ── */
.stu-search-bar {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f0f0f8;
    background: #fafbff;
}
.stu-search-form {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}
.stu-search-input-wrap {
    position: relative;
    flex: 1;
    min-width: 220px;
}
.stu-search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: .9rem;
    pointer-events: none;
}
.stu-search-input {
    padding-left: 34px !important;
    height: 40px;
    border-color: #e4e4f0;
    border-radius: 9px !important;
    font-size: .85rem;
    transition: border-color .2s, box-shadow .2s;
}
.stu-search-input:focus {
    border-color: #9c9ac2;
    box-shadow: 0 0 0 3px rgba(50,47,137,.1);
}
.stu-search-btn {
    height: 40px;
    font-size: .82rem !important;
    border-radius: 9px !important;
    font-weight: 600 !important;
    padding: 0 1rem !important;
    white-space: nowrap;
}

/* ── Name cell ── */
.stu-name-cell {
    display: flex;
    align-items: center;
    gap: .65rem;
}
.stu-avatar {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #322f89, #b2cd34);
    color: #fff;
    font-size: .72rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stu-name {
    font-weight: 500;
    color: #0f172a;
}

/* ── Badges ── */
.stu-id-badge {
    background: #eeedf8;
    color: #322f89;
    border: 1px solid #d1d0f0;
    padding: .2rem .55rem;
    border-radius: 6px;
    font-size: .76rem;
    font-weight: 600;
    font-family: ui-monospace, monospace;
}
.stu-incomplete {
    font-size: .78rem;
    color: #d97706;
    font-weight: 500;
}

/* ── Row buttons ── */
.stu-row-btn {
    font-size: .75rem !important;
    padding: .28rem .65rem !important;
    border-radius: 7px !important;
}
.stu-edit-btn {
    font-size: .75rem;
    padding: .28rem .65rem;
    border-radius: 7px;
    background: #f8f9ff;
    color: #475569;
    border: 1px solid #e4e4f0;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: background .15s, border-color .15s;
}
.stu-edit-btn:hover {
    background: #eeedf8;
    border-color: #c5c4e8;
    color: #322f89;
}

/* ── Empty state ── */
.ad-empty {
    padding: 3rem 1.5rem;
    text-align: center;
    color: #94a3b8;
    font-size: .875rem;
}
.ad-empty i {
    font-size: 2.2rem;
    opacity: .35;
}

/* ── Pagination ── */
.stu-pagination {
    padding: 1rem 1.25rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .75rem;
    border-top: 1px solid #f0f0f8;
    background: #fafbff;
}
.stu-pagination__summary {
    margin: 0;
    font-size: .82rem;
    color: #64748b;
}
.stu-pagination .pagination {
    margin-bottom: 0;
    flex-wrap: wrap;
    justify-content: center;
    gap: .25rem;
}
.stu-pagination .page-link {
    border-radius: 8px !important;
    min-width: 38px;
    text-align: center;
}

@media (max-width: 575.98px) {
    .stu-search-form { flex-direction: column; align-items: stretch; }
    .stu-search-input-wrap { min-width: unset; }
    .stu-search-btn { width: 100%; justify-content: center; }
}
</style>
@endsection
