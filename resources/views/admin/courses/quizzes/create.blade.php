@extends('admin.layout')
@section('title', 'Create Quiz - ' . $course->title)
@section('page_heading', 'Create New Quiz')

@section('content')
<form action="{{ route('admin.quizzes.store', $course) }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">New Assessment/Quiz</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <label for="title" class="form-label">Quiz Title *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required value="{{ old('title') }}">
                    @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="lesson_id" class="form-label">Lesson (Optional)</label>
                    <select class="form-control @error('lesson_id') is-invalid @enderror" id="lesson_id" name="lesson_id">
                        <option value="">-- Select a lesson --</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ old('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                {{ $lesson->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('lesson_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="total_marks" class="form-label">Total Marks *</label>
                    <input type="number" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" required value="{{ old('total_marks', 100) }}" min="1">
                    @error('total_marks')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="passing_marks" class="form-label">Passing Marks *</label>
                    <input type="number" class="form-control @error('passing_marks') is-invalid @enderror" id="passing_marks" name="passing_marks" required value="{{ old('passing_marks', 40) }}" min="0">
                    <small class="text-muted">Marks needed to pass the quiz</small>
                    @error('passing_marks')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="attempt_limit" class="form-label">Attempt Limit *</label>
                    <input type="number" class="form-control @error('attempt_limit') is-invalid @enderror" id="attempt_limit" name="attempt_limit" required value="{{ old('attempt_limit', 3) }}" min="1">
                    <small class="text-muted">How many times can students attempt this quiz?</small>
                    @error('attempt_limit')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="duration_minutes" class="form-label">Duration (Minutes)</label>
                    <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1">
                    <small class="text-muted">Leave blank for unlimited time</small>
                    @error('duration_minutes')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Quiz Questions *</h5>
            <small class="text-muted">Add at least one question so students can attempt this quiz.</small>
        </div>
        <div class="card-body">
            @error('questions')<div class="alert alert-danger">{{ $message }}</div>@enderror
            @include('admin.courses.quizzes.partials.question-fields')
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Create Quiz &amp; Questions</button>
        <a href="{{ route('admin.quizzes.index', $course) }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>
@endsection
