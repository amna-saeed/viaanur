@extends('student.layout')
@section('title', $quiz->title)
@section('page_heading', $quiz->title)

@section('content')
<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <span>{{ $quiz->title }}</span>
</nav>

<section class="student-dash-welcome mb-4" aria-labelledby="quiz-heading">
    <div class="student-dash-welcome__inner">
        <div class="student-dash-welcome__copy">
            <p class="student-dash-welcome__eyebrow mb-2">Quiz</p>
            <h2 id="quiz-heading" class="student-dash-welcome__title">{{ $quiz->title }}</h2>
            @if($quiz->description)
                <p class="student-dash-welcome__text mb-0">{{ strip_tags($quiz->description) }}</p>
            @endif
        </div>
    </div>
</section>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="student-dash-panel mb-4">
            <div class="student-dash-panel__head">
                <h3 class="student-dash-panel__title mb-0"><i class="bi bi-info-circle" aria-hidden="true"></i> Quiz details</h3>
            </div>
            <div class="student-dash-panel__body">
                <ul class="student-dash-meta list-unstyled mb-0">
                    <li><i class="bi bi-list-check" aria-hidden="true"></i> {{ $quiz->questions_count }} questions</li>
                    <li><i class="bi bi-award" aria-hidden="true"></i> Total marks: {{ $quiz->total_marks }}</li>
                    <li><i class="bi bi-check2-circle" aria-hidden="true"></i> Passing marks: {{ $quiz->passing_marks }}</li>
                    <li><i class="bi bi-arrow-repeat" aria-hidden="true"></i> Attempts: {{ $submittedCount }}/{{ $quiz->attempt_limit }}</li>
                    @if($quiz->duration_minutes)
                        <li><i class="bi bi-clock" aria-hidden="true"></i> Duration: {{ $quiz->duration_minutes }} minutes</li>
                    @else
                        <li><i class="bi bi-clock" aria-hidden="true"></i> No time limit</li>
                    @endif
                </ul>

                <div class="mt-4">
                    @if($quiz->questions_count === 0)
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            This quiz has no questions yet. Please ask your instructor to add questions from the admin panel.
                        </div>
                    @elseif($canAttempt)
                        <form action="{{ route('student.courses.quizzes.start', [$course, $quiz]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-lms-primary w-100 btn-lg">
                                <i class="bi bi-play-fill" aria-hidden="true"></i>
                                {{ $submittedCount > 0 ? 'Start new attempt' : 'Start quiz &amp; answer questions' }}
                            </button>
                        </form>
                        <p class="small text-muted mt-2 mb-0 text-center">You will answer {{ $quiz->questions_count }} question{{ $quiz->questions_count > 1 ? 's' : '' }} on the next screen.</p>
                    @else
                        <div class="alert alert-secondary mb-0">You have used all {{ $quiz->attempt_limit }} attempts.</div>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to course
        </a>
    </div>

    <div class="col-lg-7">
        @if($quiz->questions_count > 0)
            <div class="student-dash-panel mb-4">
                <div class="student-dash-panel__head">
                    <h3 class="student-dash-panel__title mb-0"><i class="bi bi-list-ul" aria-hidden="true"></i> Questions preview</h3>
                </div>
                <div class="student-dash-panel__body">
                    <ol class="mb-0 ps-3">
                        @foreach($quiz->questions as $question)
                            <li class="mb-2">
                                <span class="fw-semibold">{{ $question->question_text }}</span>
                                <span class="badge student-dash-badge student-dash-badge--muted ms-1">{{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        @endif

        <div class="student-dash-panel student-dash-panel--table">
            <div class="student-dash-panel__head">
                <h3 class="student-dash-panel__title mb-0"><i class="bi bi-clock-history" aria-hidden="true"></i> Your attempts</h3>
            </div>
            <div class="student-dash-panel__body student-dash-panel__body--flush">
                @if($attempts->whereNotNull('submitted_at')->isEmpty())
                    <div class="student-dash-panel student-dash-panel--empty student-dash-panel--empty-inline">
                        <p class="student-dash-panel__empty-text mb-0">No completed attempts yet.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover student-dash-table mb-0">
                            <thead>
                                <tr>
                                    <th>Score</th>
                                    <th>Result</th>
                                    <th>Submitted</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attempts->whereNotNull('submitted_at') as $pastAttempt)
                                    <tr>
                                        <td>{{ $pastAttempt->obtained_marks }}/{{ $quiz->total_marks }} ({{ round((float) $pastAttempt->percentage) }}%)</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $pastAttempt->is_passed ? 'student-dash-badge student-dash-badge--success' : 'student-dash-badge student-dash-badge--muted' }}">
                                                {{ $pastAttempt->is_passed ? 'Passed' : 'Failed' }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $pastAttempt->submitted_at->format('M j, Y g:i A') }}</td>
                                        <td>
                                            <a href="{{ route('student.courses.quizzes.result', [$course, $quiz, $pastAttempt]) }}" class="btn btn-sm btn-outline-primary">Review</a>
                                        </td>
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
@endsection
