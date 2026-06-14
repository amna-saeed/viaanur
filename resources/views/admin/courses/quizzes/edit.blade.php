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

<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Quiz Questions ({{ $quiz->questions->count() }})</h5>
    </div>
    <div class="card-body">
        @if($quiz->questions->isEmpty())
            <p class="text-muted mb-4">No questions yet. Add at least one question so students can attempt this quiz.</p>
        @else
            <div class="table-responsive mb-4">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Marks</th>
                            <th>Correct</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quiz->questions as $question)
                            <tr>
                                <td>{{ $question->order }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($question->question_text, 80) }}</td>
                                <td>{{ $question->marks }}</td>
                                <td><span class="badge bg-success text-uppercase">{{ $question->correct_option }}</span></td>
                                <td>
                                    <form action="{{ route('admin.quizzes.questions.destroy', [$course, $quiz, $question]) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this question?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <h6 class="mb-3">Add question</h6>
        <form action="{{ route('admin.quizzes.questions.store', [$course, $quiz]) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="question_text" class="form-label">Question *</label>
                <textarea class="form-control" id="question_text" name="question_text" rows="2" required>{{ old('question_text') }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="option_a" class="form-label">Option A *</label>
                    <input type="text" class="form-control" id="option_a" name="option_a" required value="{{ old('option_a') }}">
                </div>
                <div class="col-md-6">
                    <label for="option_b" class="form-label">Option B *</label>
                    <input type="text" class="form-control" id="option_b" name="option_b" required value="{{ old('option_b') }}">
                </div>
                <div class="col-md-6">
                    <label for="option_c" class="form-label">Option C</label>
                    <input type="text" class="form-control" id="option_c" name="option_c" value="{{ old('option_c') }}">
                </div>
                <div class="col-md-6">
                    <label for="option_d" class="form-label">Option D</label>
                    <input type="text" class="form-control" id="option_d" name="option_d" value="{{ old('option_d') }}">
                </div>
                <div class="col-md-4">
                    <label for="correct_option" class="form-label">Correct option *</label>
                    <select class="form-control" id="correct_option" name="correct_option" required>
                        @foreach(['a','b','c','d'] as $opt)
                            <option value="{{ $opt }}" {{ old('correct_option') === $opt ? 'selected' : '' }}>{{ strtoupper($opt) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="marks" class="form-label">Marks *</label>
                    <input type="number" class="form-control" id="marks" name="marks" min="1" value="{{ old('marks', 1) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="order" class="form-label">Order</label>
                    <input type="number" class="form-control" id="order" name="order" min="0" value="{{ old('order', $quiz->questions->count()) }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Add question</button>
        </form>
    </div>
</div>
@endsection
