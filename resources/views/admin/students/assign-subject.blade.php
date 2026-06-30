@extends('admin.layout')
@section('title', 'Assign Subjects - ' . $student->name)
@section('page_heading', 'Assign Subjects to Student')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-lg-6">
        <div class="ad-panel">
            <div class="ad-panel__head sp-panel-head">
                <div class="sp-panel-icon sp-panel-icon--purple"><i class="bi bi-plus-circle"></i></div>
                <h3 class="ad-panel__title mb-0">Assign Subject</h3>
            </div>
            <div class="ad-panel__body">
                <div class="sp-notice sp-notice--warning mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Assigning <strong>{{ $student->name }}</strong> to a subject also approves LMS access for the linked course when one exists.
                </div>

                @if($availableSubjects->isEmpty())
                    <div class="ad-empty">
                        <i class="bi bi-journal-x d-block mb-2"></i>
                        @if($assignedSubjects->isEmpty())
                            No subjects are available yet. Create subjects under <a href="{{ route('admin.teachers.index') }}">Teachers</a> first, then assign them here.
                        @else
                            This student is already assigned to every available subject.
                        @endif
                    </div>
                @else
                    <form action="{{ route('admin.students.store-subject', $student) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subject_id" class="form-label">Subject *</label>
                            <select class="form-select @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                                <option value="">Select a subject…</option>
                                @foreach($availableSubjects as $subject)
                                    <option value="{{ $subject->id }}" {{ (string) old('subject_id') === (string) $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                        @if($subject->course)
                                            — {{ $subject->course->title }}
                                        @endif
                                        @if($subject->teacher)
                                            ({{ $subject->teacher->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes (optional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Any admin notes about this assignment">{{ old('notes') }}</textarea>
                            @error('notes')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary sp-save-btn">
                                <i class="bi bi-plus-lg me-2"></i>Assign Subject
                            </button>
                            <a href="{{ route('admin.students.show', $student) }}" class="btn admin-lms-btn-outline">
                                <i class="bi bi-arrow-left me-2"></i>Back to Profile
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="ad-panel">
            <div class="ad-panel__head sp-panel-head justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="sp-panel-icon sp-panel-icon--teal"><i class="bi bi-book-fill"></i></div>
                    <h3 class="ad-panel__title mb-0">Assigned Subjects</h3>
                </div>
                <span class="sp-count-badge">{{ $assignedSubjects->count() }}</span>
            </div>
            <div class="ad-panel__body">
                @if($assignedSubjects->isEmpty())
                    <div class="ad-empty">
                        <i class="bi bi-inbox d-block mb-2"></i>
                        No subjects assigned to this student yet.
                    </div>
                @else
                    <div class="stu-subject-list">
                        @foreach($assignedSubjects as $subject)
                            <div class="stu-subject-item">
                                <div class="stu-subject-item__body">
                                    <h4 class="stu-subject-item__title">{{ $subject->name }}</h4>
                                    <p class="stu-subject-item__meta mb-1">
                                        <i class="bi bi-journal-bookmark me-1"></i>
                                        {{ $subject->course->title ?? 'No linked course' }}
                                    </p>
                                    @if($subject->teacher)
                                        <p class="stu-subject-item__meta mb-1">
                                            <i class="bi bi-person-workspace me-1"></i>{{ $subject->teacher->name }}
                                        </p>
                                    @endif
                                    @if($subject->code)
                                        <p class="stu-subject-item__meta mb-1">
                                            <i class="bi bi-hash me-1"></i>{{ $subject->code }}
                                        </p>
                                    @endif
                                    @if($subject->pivot && $subject->pivot->assigned_at)
                                        <p class="stu-subject-item__meta mb-0">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            Assigned {{ \Illuminate\Support\Carbon::parse($subject->pivot->assigned_at)->format('M j, Y') }}
                                        </p>
                                    @endif
                                    @if($subject->pivot && $subject->pivot->notes)
                                        <p class="stu-subject-item__notes mb-0">{{ $subject->pivot->notes }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('admin.students.remove-subject', [$student, $subject]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this subject from the student?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.stu-subject-list { display: flex; flex-direction: column; gap: .75rem; }
.stu-subject-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    border: 1px solid #e4e4f0;
    border-radius: 10px;
    padding: 1rem;
    background: #fafbff;
}
.stu-subject-item__title {
    font-size: .95rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: .35rem;
}
.stu-subject-item__meta {
    font-size: .8rem;
    color: #64748b;
}
.stu-subject-item__notes {
    margin-top: .5rem;
    font-size: .82rem;
    color: #334155;
    background: #fff;
    border: 1px solid #eef2ff;
    border-radius: 8px;
    padding: .55rem .75rem;
}
</style>
@endsection
