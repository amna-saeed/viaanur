@extends('student.layout')
@section('title', 'Result: ' . $quiz->title)
@section('page_heading', 'Quiz result')

@section('content')
<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}">{{ $quiz->title }}</a>
    <span aria-hidden="true">/</span>
    <span>Result</span>
</nav>

<section class="student-quiz-result mb-4 {{ $attempt->is_passed ? 'student-quiz-result--pass' : 'student-quiz-result--fail' }}" aria-labelledby="result-heading">
    <div class="student-quiz-result__inner">
        <div class="student-quiz-result__icon" aria-hidden="true">
            <i class="bi {{ $attempt->is_passed ? 'bi-trophy-fill' : 'bi-x-circle-fill' }}"></i>
        </div>
        <div>
            <p class="student-quiz-result__eyebrow mb-1">{{ $attempt->is_passed ? 'Congratulations!' : 'Keep learning' }}</p>
            <h2 id="result-heading" class="student-quiz-result__title">{{ $attempt->is_passed ? 'You passed' : 'Not passed' }}</h2>
            <p class="student-quiz-result__score mb-0">
                <strong>{{ $attempt->obtained_marks }}</strong> / {{ $maxMarks }} marks
                · <strong>{{ round((float) $attempt->percentage) }}%</strong>
            </p>
            <p class="small mb-0 mt-1 opacity-75">Passing score: {{ $quiz->passing_marks }} marks · Submitted {{ $attempt->submitted_at->format('M j, Y g:i A') }}</p>
        </div>
    </div>
</section>

<div class="student-dash-panel mb-4">
    <div class="student-dash-panel__head">
        <h3 class="student-dash-panel__title mb-0"><i class="bi bi-list-check" aria-hidden="true"></i> Answer review</h3>
    </div>
    <div class="student-dash-panel__body">
        @php $answers = $attempt->answers ?? []; @endphp
        @foreach($quiz->questions as $index => $question)
            @php
                $selected = $answers[$question->id] ?? null;
                $correct = strtolower((string) $question->correct_option);
                $isCorrect = $selected && strtolower($selected) === $correct;
            @endphp
            <div class="student-quiz-review mb-4 pb-4 {{ ! $loop->last ? 'border-bottom' : '' }}">
                <p class="fw-semibold mb-2">
                    <span class="text-muted">{{ $index + 1 }}.</span> {{ $question->question_text }}
                </p>
                <ul class="list-unstyled mb-0">
                    @foreach($question->options() as $key => $label)
                        @php
                            $keyLower = strtolower($key);
                            $classes = 'student-quiz-review__option';
                            if ($keyLower === $correct) $classes .= ' student-quiz-review__option--correct';
                            if ($selected === $key && ! $isCorrect) $classes .= ' student-quiz-review__option--wrong';
                            if ($selected === $key) $classes .= ' student-quiz-review__option--selected';
                        @endphp
                        <li class="{{ $classes }}">
                            <span class="student-quiz-review__key">{{ strtoupper($key) }}</span>
                            {{ $label }}
                            @if($keyLower === $correct)
                                <i class="bi bi-check-circle-fill text-success ms-1" aria-hidden="true"></i>
                            @elseif($selected === $key)
                                <i class="bi bi-x-circle-fill text-danger ms-1" aria-hidden="true"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if(! $selected)
                    <p class="small text-muted mt-2 mb-0">No answer selected</p>
                @endif
            </div>
        @endforeach
    </div>
</div>

<div class="d-flex flex-wrap gap-2">
    <a href="{{ route('student.courses.quizzes.show', [$course, $quiz]) }}" class="btn btn-lms-primary">
        <i class="bi bi-arrow-repeat" aria-hidden="true"></i> Back to quiz
    </a>
    <a href="{{ route('student.courses.show', $course) }}" class="btn btn-outline-secondary">
        <i class="bi bi-journal-bookmark" aria-hidden="true"></i> Course home
    </a>
    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
</div>
@endsection
