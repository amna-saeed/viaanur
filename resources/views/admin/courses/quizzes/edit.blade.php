@extends('admin.layout')
@section('title', 'Edit Quiz - ' . $course->title)
@section('page_heading', 'Edit Quiz')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit: {{ $quiz->title }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.quizzes.update', [$course, $quiz]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <label for="title" class="form-label">Quiz Title *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required value="{{ old('title', $quiz->title) }}">
                    @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $quiz->description) }}</textarea>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="lesson_id" class="form-label">Lesson (Optional)</label>
                    <select class="form-control @error('lesson_id') is-invalid @enderror" id="lesson_id" name="lesson_id">
                        <option value="">-- Select a lesson --</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" {{ old('lesson_id', $quiz->lesson_id) == $lesson->id ? 'selected' : '' }}>
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
                    <input type="number" class="form-control @error('total_marks') is-invalid @enderror" id="total_marks" name="total_marks" required value="{{ old('total_marks', $quiz->total_marks) }}" min="1">
                    @error('total_marks')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="passing_marks" class="form-label">Passing Marks *</label>
                    <input type="number" class="form-control @error('passing_marks') is-invalid @enderror" id="passing_marks" name="passing_marks" required value="{{ old('passing_marks', $quiz->passing_marks) }}" min="0">
                    <small class="text-muted">Marks needed to pass the quiz</small>
                    @error('passing_marks')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="attempt_limit" class="form-label">Attempt Limit *</label>
                    <input type="number" class="form-control @error('attempt_limit') is-invalid @enderror" id="attempt_limit" name="attempt_limit" required value="{{ old('attempt_limit', $quiz->attempt_limit) }}" min="1">
                    <small class="text-muted">How many times can students attempt this quiz?</small>
                    @error('attempt_limit')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="col-md-6">
                    <label for="duration_minutes" class="form-label">Duration (Minutes)</label>
                    <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $quiz->duration_minutes) }}" min="1">
                    <small class="text-muted">Leave blank for unlimited time</small>
                    @error('duration_minutes')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Quiz</button>
                <a href="{{ route('admin.quizzes.index', $course) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
