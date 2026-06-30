@extends('student.layout')
@section('title', 'Result: ' . $quiz->title)
@section('page_heading', 'Quiz result')

@section('content')
<nav class="student-course-breadcrumb mb-3" aria-label="Breadcrumb">
    <a href="{{ student_course_route('student.courses.show', $course) }}">{{ $course->title }}</a>
    <span aria-hidden="true">/</span>
    <a href="{{ student_course_route('student.courses.quizzes.show', $course, ['quiz' => $quiz]) }}">{{ $quiz->title }}</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">Result</span>
</nav>

<a href="{{ student_course_route('student.courses.quizzes.show', $course, ['quiz' => $quiz]) }}" class="student-course-back d-lg-none mb-3">
    <i class="bi bi-arrow-left" aria-hidden="true"></i> Back to quiz
</a>

<section class="student-quiz-result-banner {{ $attempt->is_passed ? 'student-quiz-result-banner--pass' : 'student-quiz-result-banner--fail' }}" aria-labelledby="result-heading">
    <div class="student-quiz-result-banner__inner">
        <div class="student-quiz-result-banner__icon" aria-hidden="true">
            <i class="bi {{ $attempt->is_passed ? 'bi-trophy-fill' : 'bi-arrow-repeat' }}"></i>
        </div>
        <div class="student-quiz-result-banner__copy">
            <p class="student-quiz-result-banner__eyebrow">{{ $attempt->is_passed ? 'Congratulations!' : 'Keep learning' }}</p>
            <h2 id="result-heading" class="student-quiz-result-banner__title">{{ $attempt->is_passed ? 'You passed this quiz' : 'Not passed yet' }}</h2>
            <p class="student-quiz-result-banner__quiz mb-0">{{ $quiz->title }}</p>
        </div>
        <div class="student-quiz-result-banner__score">
            <span class="student-quiz-result-banner__percent">{{ round((float) $attempt->percentage) }}%</span>
            <span class="student-quiz-result-banner__marks">{{ $attempt->obtained_marks }} / {{ $maxMarks }} marks</span>
            <span class="badge rounded-pill {{ $attempt->is_passed ? 'student-dash-badge student-dash-badge--success' : 'student-dash-badge student-dash-badge--fail' }}">
                {{ $attempt->is_passed ? 'Passed' : 'Failed' }}
            </span>
        </div>
    </div>
    <p class="student-quiz-result-banner__foot mb-0">
        Passing score: {{ $quiz->passing_marks }} marks
        · Submitted {{ $attempt->submitted_at->format('M j, Y g:i A') }}
    </p>
</section>

<section class="student-lesson-panel student-quiz-review-panel" aria-labelledby="review-heading">
    <header class="student-lesson-panel__head">
        <span class="student-lesson-panel__icon student-course-list__icon--quiz" aria-hidden="true">
            <i class="bi bi-list-check"></i>
        </span>
        <div>
            <h3 id="review-heading" class="student-lesson-panel__title">Answer review</h3>
            <p class="student-lesson-panel__sub mb-0">See which answers were correct or incorrect</p>
        </div>
    </header>
    <div class="student-quiz-details__body">
        @php $answers = $attempt->answers ?? []; @endphp
        @foreach($quiz->questions as $index => $question)
            @php
                $selected = $answers[$question->id] ?? null;
                $correct = strtolower((string) $question->correct_option);
                $isCorrect = $selected && strtolower($selected) === $correct;
            @endphp
            <article class="student-quiz-review-item {{ $isCorrect ? 'student-quiz-review-item--correct' : ($selected ? 'student-quiz-review-item--wrong' : 'student-quiz-review-item--skipped') }}">
                <header class="student-quiz-review-item__head">
                    <span class="student-quiz-review-item__num">{{ $index + 1 }}</span>
                    <h4 class="student-quiz-review-item__question">{{ $question->question_text }}</h4>
                    <span class="badge student-dash-badge {{ $isCorrect ? 'student-dash-badge--success' : ($selected ? 'student-dash-badge--fail' : 'student-dash-badge--muted') }}">
                        @if(! $selected)
                            Skipped
                        @elseif($isCorrect)
                            Correct
                        @else
                            Wrong
                        @endif
                    </span>
                </header>
                <ul class="student-quiz-review-options list-unstyled mb-0">
                    @foreach($question->options() as $key => $label)
                        @php
                            $keyLower = strtolower($key);
                            $optionClass = 'student-quiz-review__option';
                            if ($keyLower === $correct) {
                                $optionClass .= ' student-quiz-review__option--correct';
                            }
                            if ($selected === $key && ! $isCorrect) {
                                $optionClass .= ' student-quiz-review__option--wrong';
                            }
                            if ($selected === $key) {
                                $optionClass .= ' student-quiz-review__option--selected';
                            }
                        @endphp
                        <li class="{{ $optionClass }}">
                            <span class="student-quiz-review__key">{{ strtoupper($key) }}</span>
                            <span class="student-quiz-review__label">{{ $label }}</span>
                            @if($keyLower === $correct)
                                <i class="bi bi-check-circle-fill student-quiz-review__status student-quiz-review__status--ok" aria-hidden="true"></i>
                            @elseif($selected === $key)
                                <i class="bi bi-x-circle-fill student-quiz-review__status student-quiz-review__status--bad" aria-hidden="true"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </article>
        @endforeach
    </div>
</section>

<nav class="student-quiz-result-nav" aria-label="Quiz result actions">
    <a href="{{ student_course_route('student.courses.quizzes.show', $course, ['quiz' => $quiz]) }}" class="btn btn-lms-primary">
        <i class="bi bi-arrow-repeat" aria-hidden="true"></i> Back to quiz
    </a>
    <a href="{{ student_course_route('student.courses.show', $course) }}" class="btn btn-outline-secondary">
        <i class="bi bi-journal-bookmark" aria-hidden="true"></i> Course home
    </a>
    <a href="{{ route('student.dashboard', student_route_params()) }}" class="btn btn-outline-secondary">
        <i class="bi bi-grid" aria-hidden="true"></i> Dashboard
    </a>
</nav>
@endsection
