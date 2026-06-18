@extends('admin.layout')
@section('title', 'Quizzes - ' . $course->title)
@section('page_heading', 'Quizzes for ' . $course->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h5 mb-0">Assessments & Quizzes</h2>
    <div class="gap-2">
        <a href="{{ route('admin.quizzes.create', $course) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Quiz
        </a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($quizzes->isEmpty())
            <p class="text-muted p-4 mb-0">No quizzes yet. <a href="{{ route('admin.quizzes.create', $course) }}">Add your first quiz</a>.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Quiz Title</th>
                            <th>Questions</th>
                            <th>Total Marks</th>
                            <th>Passing Marks</th>
                            <th>Attempts</th>
                            <th>Duration</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                        <tr>
                            <td>
                                <strong>{{ $quiz->title }}</strong>
                                @if($quiz->description)
                                    <br><small class="text-muted">{{ Str::limit($quiz->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if(($quiz->questions_count ?? 0) === 0)
                                    <span class="badge bg-warning text-dark">0 — add questions</span>
                                @else
                                    <span class="badge bg-success">{{ $quiz->questions_count }}</span>
                                @endif
                            </td>
                            <td>{{ $quiz->total_marks }}</td>
                            <td>
                                {{ $quiz->passing_marks }}
                                <br><small class="text-muted">({{ round(($quiz->passing_marks / $quiz->total_marks) * 100) }}%)</small>
                            </td>
                            <td>{{ $quiz->attempt_limit }}</td>
                            <td>{{ $quiz->duration_minutes ? $quiz->duration_minutes . ' mins' : '-' }}</td>
                            <td>
                                <a href="{{ route('admin.quizzes.edit', [$course, $quiz]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="{{ route('admin.quizzes.attempts', [$course, $quiz]) }}" class="btn btn-sm btn-outline-info">Results</a>
                                <form action="{{ route('admin.quizzes.destroy', [$course, $quiz]) }}" method="POST" class="d-inline">
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
    </div>
</div>
@endsection
