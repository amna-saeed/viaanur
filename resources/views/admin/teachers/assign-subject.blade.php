@extends('admin.layout')
@section('title', 'Assign Subject - ' . $teacher->name)
@section('page_heading', 'Assign Subject to Teacher')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-plus-circle text-primary me-2"></i>Add New Subject</h5>
            </div>
            <div class="card-body p-4">
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>{{ $teacher->name }}</strong> - Assigning subjects
                </div>

                <form action="{{ route('admin.teachers.store-subject', $teacher) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Subject Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="e.g., Calculus I" required value="{{ old('name') }}">
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course *</label>
                        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                            <option value="">Select a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="e.g., CALC101" value="{{ old('code') }}">
                        @error('code')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="credit_hours" class="form-label">Credit Hours</label>
                        <input type="number" class="form-control @error('credit_hours') is-invalid @enderror" id="credit_hours" name="credit_hours" step="0.5" min="0.5" placeholder="e.g., 3" value="{{ old('credit_hours') }}">
                        @error('credit_hours')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-plus-lg me-2"></i>Assign Subject
                        </button>
                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-book-fill text-info me-2"></i>Currently Assigned Subjects</h5>
            </div>
            <div class="card-body p-4">
                @if($assignedSubjects->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3 mb-0">No subjects assigned yet</p>
                    </div>
                @else
                    <div class="list-group">
                        @foreach($assignedSubjects as $subject)
                        <div class="list-group-item d-flex justify-content-between align-items-start p-3 mb-2 rounded border">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $subject->name }}</h6>
                                <p class="mb-1 text-muted small">
                                    <i class="bi bi-journal-bookmark me-2"></i>
                                    {{ $subject->course->title ?? 'N/A' }}
                                </p>
                                @if($subject->code)
                                    <p class="mb-0 text-muted small">
                                        <i class="bi bi-hash me-2"></i>{{ $subject->code }}
                                    </p>
                                @endif
                                @if($subject->credit_hours)
                                    <p class="mb-0 text-muted small">
                                        <i class="bi bi-star me-2"></i>{{ $subject->credit_hours }} hours
                                    </p>
                                @endif
                            </div>
                            <form action="{{ route('admin.teachers.remove-subject', [$teacher, $subject]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
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
    .list-group-item {
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection
