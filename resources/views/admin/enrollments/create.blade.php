@extends('admin.layout')
@section('title', 'Enroll Student')
@section('page_heading', 'Enroll Student in Course')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>New Enrollment</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.enrollments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="form-label">Select Student *</label>
                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Choose a student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="course_id" class="form-label">Select Course *</label>
                        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                            <option value="">Choose a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Enroll Student
                        </button>
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-info-circle-fill text-info me-2" style="font-size: 1.5rem;"></i>
                    <h6 class="mb-0">Enrollment Info</h6>
                </div>
                <p class="text-muted small mb-2">
                    <strong>What is enrollment?</strong> Enrollment allows a student to participate in a course, access course materials, submit assignments, and take quizzes.
                </p>
                <hr>
                <p class="text-muted small mb-0">
                    <i class="bi bi-check-circle me-2"></i>Students can view course content
                    <br>
                    <i class="bi bi-check-circle me-2"></i>Access lessons and quizzes
                    <br>
                    <i class="bi bi-check-circle me-2"></i>Submit assessments
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
