@extends('admin.layout')
@section('title', 'Quiz Results - ' . $quiz->title)
@section('page_heading', 'Quiz Results: ' . $quiz->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-0">{{ $quiz->title }}</h5>
        <small class="text-muted">Total Marks: {{ $quiz->total_marks }} | Passing Marks: {{ $quiz->passing_marks }}</small>
    </div>
    <a href="{{ route('admin.quizzes.index', $course) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($attempts->isEmpty())
            <p class="text-muted p-4 mb-0">No student attempts yet.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Email</th>
                            <th>Obtained Marks</th>
                            <th>Percentage</th>
                            <th>Status</th>
                            <th>Submitted On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attempts as $attempt)
                        <tr>
                            <td>
                                <strong>{{ $attempt->user->name }}</strong>
                            </td>
                            <td>{{ $attempt->user->email }}</td>
                            <td>
                                {{ $attempt->obtained_marks }}/{{ $quiz->total_marks }}
                            </td>
                            <td>
                                {{ number_format($attempt->percentage, 2) }}%
                            </td>
                            <td>
                                @if($attempt->is_passed)
                                    <span class="badge bg-success">PASSED</span>
                                @else
                                    <span class="badge bg-danger">FAILED</span>
                                @endif
                            </td>
                            <td>
                                @if($attempt->submitted_at)
                                    {{ $attempt->submitted_at->format('M d, Y H:i') }}
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top">
                <strong>Summary:</strong>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <small class="text-muted">Total Attempts:</small>
                        <h6>{{ $attempts->count() }}</h6>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Passed:</small>
                        <h6>{{ $attempts->where('is_passed', true)->count() }}</h6>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Failed:</small>
                        <h6>{{ $attempts->where('is_passed', false)->count() }}</h6>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted">Avg Score:</small>
                        <h6>{{ number_format($attempts->avg('percentage'), 2) }}%</h6>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
